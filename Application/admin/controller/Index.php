<?php
namespace Application\admin\controller;
use CoolPHP\Db\Db as DbModel;
use CoolPHP\Common\Common as CommonClass;

class Index extends Base
{
	public function index()
	{
		echo '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p><br/><span style="font-size:30px"> CoolPHP </span></p></div>';
	}
	/**
	 * PDO 操作数据库
	 * @param  [type] $id [参数 id]
	 * @return [type]     [description]
	 */
	public function queryAll($id)
    {	
    	try{
    		$statement = "select * from cool_users where user_id =".(int)$_GET['id'];
			$newPdo = DbModel::Pdo();
			$query = $newPdo->query($statement);
			$fetchAll = $query->FetchAll();
			// var_dump($fetchAll);
			if(!empty($fetchAll)) CommonClass::writeSysLog('第二次测试写入系统日志,查询成功');
    	} catch(Exception $e){
    		echo $e->getMessage();
    	}
		
    }
    /**
     * Smarty 模板解析
     * @return [type] [description]
     */
    public function views()
    {	
    	//获取当前操作的控制器名与方法名
    	$_controller = __CLASS__;
    	$_method  = __METHOD__;
    	@$strController = strtolower(end(array_filter(explode('\\',$_controller))));
    	$strMethod = substr($_method,strpos($_method,':')+2);
        $route = dirname(dirname(__FILE__)).'/view/'.$strController.'/'.$strMethod.'.html';
    	$_smarty =  $this->_smarty;
    	//end
    	//分配变量与模板解析
		$content = '假装模板已经解析';
		$_smarty->assign('content', $content);
		$_smarty->display($route);
    }
    public function findOne($findid)
    {	
    	//url http://localhost/coolPHP/index.php/admin/index/findOne?id=1
    	$findid = (int)$_GET['id'];
    	$find = '我是查找的ID为'.$findid.'的值';
    	
    	$_controller = __CLASS__;
    	$_method  = __METHOD__;
    	@$strController = strtolower(end(array_filter(explode('\\',$_controller))));
    	$strMethod = substr($_method,strpos($_method,':')+2);
    	$route = dirname(dirname(__FILE__)).'/view/'.$strController.'/'.$strMethod.'.html';
    	$_smarty =  $this->_smarty;

		$_smarty->assign('find', $find);
		$_smarty->display($route);
    }
}