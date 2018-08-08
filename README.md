### 框架目录结构
|--- 目录结构
|
|--Application 						应用目录
|   |--admin						后台模块
|	|	|--controller 				控制器目录
|	|	|	|--Base.php  			后台基本控制器
|	|	|	|--Index.php  			Index控制器,测试代码参考
|   |   |--model	  				model目录
|	|	|--view       				视图目录
|	|	|	|--index				index控制器视图文件
|	|	|	|	|--findone.html     index控制器下findone方法解析视图
|	|	|	|	|--views.html  		index控制器下views方法解析视图
|	|--service  					业务逻辑层
|	|	|--controller  				处理逻辑的控制层
|	|	|--model	   				处理逻辑的model层
|--Config							配置文件目录
|	|	|--config.php  				框架配置文件
|--CoolPHP
|	|--Base							框架核心基础类库
|	|	|--Controller.php 			框架控制器基类
|	|	|--Model.php	  			框架Model基类
|	|	|--View  		  			视图基类
|	|--Common 						框架系统工具类
|	|	|--Common.php				框架系统工具类
|	|--Db
|	|	|--Db.php  					框架数据库操作类
|	|	|--Sql.php 					基础SQL类库
|--CoolPHP.php  					框架核心运行文件
|--define.php						框架自定义常量
|-- Public  						框架公共目录
|	|--cool_thirdPartyResources  	框架第三方静态资源
|	|--cool_upload 					上传文件目录
|-- Runtime 						应用的运行时目录
|	|--errorlog 					错误日志目录/以天为单位进行记录
|	|--syslog   					系统日子目录/以天为单位进行记录
|--coolPHP.sql  					测试sql文件
|--index.php						入口文件
|--README.MD
|
|
### 一些约定
	1*.完全采用传统 <MVC> ,并支持路由解析
		1.1* 数据库连接采用PDO,框架已封装了基本的增删改查,复杂SQL语句的执行可自定义SQL语句
		1.2* 引入Smarty模板引擎 
		1.3* 内置boostrap,layer等插件
	2*.可在Config目录下进行数据库配置
	3*.默认访问 admin/Index/index
	4*.默认URL格式为:http://localhost/coolPHP/index.php/admin/index/findOne?id=1&field=coolPHP
	5*.
	控制器    ****
	数据库模型	  **  均以Index.php 命名 首字母大写
	第三方公共类**
	6*.
	必须使用命名空间
	7*.
	所有自定义及引入的第三方类库均放在   /CoolPHP/Common下  并使用命名空间
	8*.调试模式动态开关PHP错误提示
	9*.建议使用try...catch..
