<?php
namespace Application\admin\controller;
/**
 * 后台基础控制器,可处理如登录等
 */
class Base
{
    public function __construct()
    {	
    	/**
    	 * 引入Smarty
    	 */
    	try {
			require APP_PATH.'CoolPHP/Common/libs/Smarty.class.php';
    		$this->_smarty = new \Smarty;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
}