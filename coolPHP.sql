/*
Navicat MySQL Data Transfer

Source Server         : phpstudy
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : coolphp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-07-30 10:35:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cool_users
-- ----------------------------
DROP TABLE IF EXISTS `cool_users`;
CREATE TABLE `cool_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_disabled` int(1) NOT NULL DEFAULT '0',
  `register_time` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cool_users
-- ----------------------------
INSERT INTO `cool_users` VALUES ('1', 'lily', '123456', '0', '2018-07-29 10:34:14');
INSERT INTO `cool_users` VALUES ('2', 'make', '123456', '0', '2018-07-30 10:34:40');
INSERT INTO `cool_users` VALUES ('3', 'korl', '12345', '0', '2018-07-30 10:35:00');
