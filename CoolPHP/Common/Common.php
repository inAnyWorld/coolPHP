<?php
namespace CoolPHP\Common;
/**
 * 系统工具类
 */
class Common
{
	
	/**
	 * 写日志 
     * @param  [type] $logStr [错误信息]
     * @return [type]         [description]
     */
    public static function writeSysLog($logStr)
    {   
        if('' !== $logStr){
            $writeSysLog = file_put_contents(RUNTIME_PATH."syslog/".date("Y-m-d",time()).".log", $logStr.' '.date("Y-m-d H:i:s",time())."\r\n",FILE_APPEND);
            if(false !== $writeSysLog){
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

	/** 
	 * 生成随机字符串,可以自己扩展   //若想唯一，只需在开头加上用户id
	 * $type可以为：upper(只生成大写字母),lower(只生成小写字母),number(只生成数字)
	 * $len为长度,定义字符串长度
	 * @param $len   int 指定字符串长度
	 * @param $type  类型
	 * @param return 随机字符串
	 */
	public static function randomString($type, $len = 0) {
	    $new = '';
	    $string = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';  //数据池
	    if ($type == 'upper') {
	        for ($i = 0; $i < $len; $i++) {
	            $new .= $string[mt_rand(36, 61)];
	        }
	        return $new;
	    }
	    if ($type == 'lower') {
	        for ($i = 0; $i < $len; $i++) {
	            $new .= $string[mt_rand(10, 35)];
	        }
	        return $new;
	    }
	    if ($type == 'number') {
	        for ($i = 0; $i < $len; $i++) {
	            $new .= $string[mt_rand(0, 9)];
	        }
	        return $new;
	    }
	}
	/**
	* 正则验证邮箱地址
	* @param $email String
	* @return Bool 
	*/
	public static function matchEmail($email){
		if(!preg_match('/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/', $email)){
			return false;
		}
		else{
			return true;
		}
	}
	/**
	* 正则匹配电话号码
	* @param Int $phone
	* @return Bool
	*/
	public static function matchPhone($phone)
	{
		if(!preg_match('/^(13[0-9]|14[5|7]|15[0-9]|16[0-9]|17[0-9]|18[0-9]|19[0-9])\d{8}$/', $phone)){
          	return false;
        }
        else{
        	return true;
        }
	}
	/**
	 * 返回经addslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	public static function newAddslashes($string){
	    if(!is_array($string)) return addslashes($string);
	    foreach($string as $key => $val) $string[$key] = new_addslashes($val);
	    return $string;
	}
	/**
	 * 返回经stripslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	public static function newStripslashes($string) {
	    if(!is_array($string)) return stripslashes($string);
	    foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
	    return $string;
	}
	/**
     * 截取指定字符串
     * @param  [type] $input [被截取字符串]
     * @param  [type] $start [起始位置]
     * @param  [type] $end   [结束位置]
     * @return [type]        [description]
     */
    public static function returnSubStr($input, $start, $end) {
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
	* 获取给定月份的天数
	* @param Int $month  需要获取天数的月份
	* @param Int $year 	 需要获取天数的年份
	* @return Int 天数
	*/
	public static function getDays($month,$year){
	    switch($month){
	        case '1':
	        case '3':
	        case '5':
	        case '7':
	        case '8':
	        case '10':
	        case '12':
	            return 31;
	        break;
	        case '4':
	        case '6':
	        case '9':
	        case '11':
	            return 30;
	        break;
	        case '2':
	            if(($year%4==0 && $year%100!=0) || $year%400==0){//整百的年份要同时满足400的倍数才算闰年
	                return 29;
	            }else{
	                return 28;
	            }
	        break;
	    }
	}
	/**
	* 获取下个月第一天和最后一天
	* @param 上月时间
	* @return 返回下月最后一天
	*/
	public static function getNextMonthDays($date){
		$timestamp=strtotime($date);
		$arr=getdate($timestamp);
		if($arr['mon'] == 12){
			$year=$arr['year'] +1;
			$month=$arr['mon'] -11;
			$firstday=$year.'-0'.$month.'-01';
			$lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
		}else{
			$firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)+1).'-01'));
			$lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
		}
		 return array($firstday,$lastday);
	}
	/**
	* 获取指定日期的前/后多少天,月,年
	* @param Date $vdate 指定的日期
	* @param Int  $num  向前还是向后
	* @param string $vtype 天/月/年
	* @return Date 获取的时间
	*/
	public static function dateCount($vdate,$vnum,$vtype){
	    $day = date('j',strtotime($vdate));
	    $month = date('n',strtotime($vdate));
	    $year = date('Y',strtotime($vdate));
	    switch($vtype){
	        case 'day':
	            if($vnum >= 0){
	                $day = $day + abs($vnum);
	            }else{
	                $day = $day - abs($vnum);
	            }
	        break;
	        case 'month':
	            if($vnum >= 0){
	                $month = $month+ abs($vnum);
	            }else{
	                $month = $month- abs($vnum);
	            }
	            $next = self::getDays($month,$year);//获取变换后月份的总天数
	            if($next<$day){
	                $day = $next;
	            }
	        break;
	        case 'year':
	            if($vnum >= 0){
	                $year = $year+ abs($vnum);
	            }else{
	                $year = $year - abs($vnum);
	            }
	        break;
	        default :
	 
	        break;
	    }
	    $time = mktime(0,0,0,$month,$day,$year);
	    return date('Y-m-d',$time);
	}
	/**
     * 日期转换成几分钟前
     */
    public static function formatTime($date) {
        $timer = strtotime($date);
        $diff = $_SERVER['REQUEST_TIME'] - $timer;
        $day = floor($diff / 86400);
        $free = $diff % 86400;
        if($day > 0) {
            if(15 < $day && $day <30){
                return "半个月前";
            }elseif(30 <= $day && $day <90){
                return "1个月前";
            }elseif(90 <= $day && $day <187){
                return "3个月前";
            }elseif(187 <= $day && $day <365){
                return "半年前";
            }elseif(365 <= $day){
                return "1年前";
            }else{
                return $day."天前";
            }
        }else{
            if($free>0){
                $hour = floor($free / 3600);
                $free = $free % 3600;
                if($hour>0){
                    return $hour."小时前";
                }else{
                    if($free>0){
                        $min = floor($free / 60);
                        $free = $free % 60;
                    if($min>0){
                        return $min."分钟前";
                    }else{
                        if($free>0){
                            return $free."秒前";
                        }else{
                            return '刚刚';
                        }
                    }
                    }else{
                        return '刚刚';
                    }
                }
            }else{
                return '刚刚';
            }
        }
    }
	/**
	 * 取得文件扩展
	 * @param $filename 文件名
	 * @return 扩展名
	 */
	public static function fileExt($filename) {
	    return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
	}
	/**
	 * 文件下载
	 * @param $filepath 文件路径
	 * @param $filename 文件名称
	 */
	 
	public static function fileDown($filepath, $filename = '') {
	    if(!$filename) $filename = basename($filepath);
	    if(is_ie()) $filename = rawurlencode($filename);
	    $filetype = fileext($filename);
	    $filesize = sprintf("%u", filesize($filepath));
	    if(ob_get_length() !== false) @ob_end_clean();
	    header('Pragma: public');
	    header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
	    header('Cache-Control: no-store, no-cache, must-revalidate');
	    header('Cache-Control: pre-check=0, post-check=0, max-age=0');
	    header('Content-Transfer-Encoding: binary');
	    header('Content-Encoding: none');
	    header('Content-type: '.$filetype);
	    header('Content-Disposition: attachment; filename="'.$filename.'"');
	    header('Content-length: '.$filesize);
	    readfile($filepath);
	    exit;
	}
	/**
     * 判断是PC端还是wap端访问
     * @return type判断手机移动设备访问
     */
    public static function isMobile()
    { 
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        } 
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        { 
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        } 
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
                ); 
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            } 
        } 
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        { 
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            } 
        } 
        return false;
    }
    /**
    * 判断是否是微信浏览器还是企业微信浏览器
    */
    public static function isWxbrowser()
    {
    	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {  
        	return true;  
	    }  
	    else{  
	        return false;  
	    }
    }
    /**
    * 判断是否是企业微信浏览器
    */
    public static function isWxCompany()
    {
    	if( strpos($_SERVER['HTTP_USER_AGENT'], 'wxwork') !== false ) {  
        	return true;  
	    }  
	    else{  
	        return false;  
	    } 
    }
    /**
    * 整合到一起，判断当前设备，1：安卓；2：IOS；3：微信；0：未知
    */
    public static function isDevice()
    {
        if($_SERVER['HTTP_USER_AGENT']){
            $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
            if(strpos($agent, 'micromessenger') !== false)
                return 'wchat';
            elseif(strpos($agent, 'iphone')||strpos($agent, 'ipad'))
                return 'ios';
            else
                return 'android';
        }
        return 0;
    }
}