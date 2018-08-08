<?php

namespace CoolPHP;

class CoolPHP
{
    // 初始化配置文件
    protected $config = [];

    public function __construct($config)
    {   
        date_default_timezone_set('PRC');
        $this->config = $config;
    }

    // 运行程序
    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->setDbConfig();
        $this->route();
    }
    // 路由处理
    public function route()
    {      

        $param = array();
        $url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']; // 获取当前完整URL
        $paramStr = trim(strrchr( $url, '?'),'?');
        $param = $param  == '' ? $param : explode('&',$paramStr);
        $substrUrl = $this->returnSubStr($url,'index.php','?');
        // 截取路由字符串
        if(false == $substrUrl){
            $moduleName = $this->config['defaultModule'];  //读取配置文件中默认模块
            $controllerName = ucfirst($this->config['defaultController']); //读取配置文件中默认控制器
            $actionName  = $this->config['defaultAction']; //读取配置文件中默认的方法名
        }else{
            $arrUrl = explode('/',$substrUrl);
            //删除空值
            $arrUrl = array_filter($arrUrl);
            if(count($arrUrl) >= 3){
                //获取模块名
                $moduleName = strtolower(reset($arrUrl));
                //获取控制器名
                $controllerName = $arrUrl[2];
                //获取方法名
                $actionName = strtolower(end($arrUrl));
            }
            else{
                $moduleName = $this->config['defaultModule'];
                $controllerName = ucfirst($this->config['defaultController']);
                $actionName  = $this->config['defaultAction'];
            }
        }
        // 判断控制器和操作是否存在
        $controller = 'Application\\'.$moduleName.'\\controller\\'. $controllerName;
        // 检测类是否存在
        if (!class_exists($controller)) {
            $wErrLog = $this->writeError("控制器 ".$controller."不存在");
            if(false !==  $wErrLog){
              exit($controller . '控制器不存在');
            }
        }
        if (!method_exists($controller, $actionName)) {
            $wErrLog = $this->writeError("方法 ".$actionName."不存在");
            if(false !== $wErrLog){
              exit($actionName . '方法不存在');
            }
        }

        // 如果控制器和操作名存在，则实例化控制器，因为控制器对象里面
        // 还会用到控制器名和操作名，所以实例化的时候把他们俩的名称也
        // 传进去。结合Controller基类一起看
        $dispatch = new $controller($controllerName, $actionName);
        // $dispatch保存控制器实例化后的对象，我们就可以调用它的方法，
        // 也可以像方法中传入参数，以下等同于：$dispatch->$actionName($param)
        call_user_func_array(array($dispatch, $actionName), $param);
    }

    // 是否打开调试模式
    public function setReporting()
    {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
        }
    }

    // 删除敏感字符
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    // 检测敏感字符并删除
    public function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET ) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST ) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    // 检测自定义全局变量并移除。因为 register_globals 已经弃用，如果
    // 已经弃用的 register_globals 指令被设置为 on，那么局部变量也将
    // 在脚本的全局作用域中可用。 例如， $_POST['foo'] 也将以 $foo 的
    // 形式存在，这样写是不好的实现，会影响代码中的其他变量。 相关信息，
    // 参考: http://php.net/manual/zh/faq.using.php#faq.register-globals
    public function unregisterGlobals()
    {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    // 配置数据库信息
    public function setDbConfig()
    {
        if ($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['dbname']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }

    // 自动加载类
    public function loadClass($className)
    {
        $classMap = $this->classMap();

        if (isset($classMap[$className])) {
            // 包含内核文件
            $file = $classMap[$className];
        } elseif (false !== strpos($className, '\\')) {
            // 包含应用（application目录）文件
            $file = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!is_file($file)) {
                $wErrLog = $this->writeError("文件".$file."不存在或不是文件");
                if(false !== $wErrLog){
                    return;
                }
            }
        } else {
            $wErrLog = $this->writeError('自动加载类失败');
            if(false !== $wErrLog){
              return;
            }
        }
        include $file;
    }

    // 内核文件命名空间映射关系
    protected function classMap()
    {
        return [
            'CoolPHP\Base\Controller' => APP_PATH . '/Base/Controller.php',  // 控制器基类
            'CoolPHP\Base\Model' => APP_PATH . '/Base/Model.php', // Model基类
            'CoolPHP\Base\View' => APP_PATH . '/Base/View.php',  // 视图基类
            'CoolPHP\Db\Db' => APP_PATH . 'CoolPHP/Db/Db.php', // PDO基类
            'CoolPHP\Db\Sql' => APP_PATH . '/CoolPHP/Db/Sql.php', // SQL基类
            'CoolPHP\Common\Common' => APP_PATH . '/CoolPHP/Common/Common.php', // 公共类库
        ];
    }
    /**
     * 截取指定字符串
     * @param  [type] $input [被截取字符串]
     * @param  [type] $start [起始位置]
     * @param  [type] $end   [结束位置]
     * @return [type]        [description]
     */
    public function returnSubStr($input, $start, $end) {
        $substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
        if($substr){
            if(empty($substr) || is_null($substr)){
                return false;
            }
            else{
                return $substr;
            }
        }
        else{
            return false;
        }
    }
    /**
     * @param  [type] $errStr [错误信息]
     * @return [type]         [description]
     */
    public function writeError($errStr)
    {   
        if('' !== $errStr){
            $writeError = file_put_contents(RUNTIME_PATH."errorlog/".date("Y-m-d",time()).".log", $errStr.' '.date("Y-m-d H:i:s",time())."\r\n",FILE_APPEND);
            if(false !== $writeError){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
}