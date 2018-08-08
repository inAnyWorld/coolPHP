<?php
/**
 * 框架配置文件
 * 带 * 为必须
 */
return  [
	'defaultModule'	=> 'admin',  	 	// * 默认访问模块
	'defaultController'	=> 'Index',  	// * 默认访问控制器 
	'defaultAction' => 'index',      	// * 默认访问方法名
	'db' =>[
		'type' 		=> 'mysql', 		// * 数据库类型
		'username' 	=> 'root',  		// * 数据库用户名
		'password'	=> 'root', 			// * 数据库密码
		'dbname' 	=> 'coolphp', 			// * 数据库名
		'host'		=> '127.0.0.1',  	// * 数据库主机地址
	],
];