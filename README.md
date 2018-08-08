### 框架目录结构

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
