/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : yii_cms

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 30/03/2020 15:14:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for my_login_log
-- ----------------------------
DROP TABLE IF EXISTS `my_login_log`;
CREATE TABLE `my_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '登陆日志',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `ip` varchar(20) DEFAULT NULL COMMENT 'ip地址',
  `address` varchar(100) DEFAULT NULL COMMENT '位置',
  `browser` varchar(100) DEFAULT NULL COMMENT '浏览器',
  `os` varchar(50) DEFAULT NULL COMMENT '操作系统',
  `user_agent` varchar(255) DEFAULT NULL COMMENT '用户代理',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of my_login_log
-- ----------------------------
BEGIN;
INSERT INTO `my_login_log` VALUES (1, 1, '127.0.0.1', '本地 本地', 'Chrome(80.0.3987.149)', 'Mac', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36', 1585550783);
COMMIT;

-- ----------------------------
-- Table structure for my_member
-- ----------------------------
DROP TABLE IF EXISTS `my_member`;
CREATE TABLE `my_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '前台用户表',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称',
  `tel` varchar(15) DEFAULT NULL COMMENT '手机号',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1:启用 2:禁用',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of my_member
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for my_menu
-- ----------------------------
DROP TABLE IF EXISTS `my_menu`;
CREATE TABLE `my_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单表',
  `name` varchar(100) DEFAULT NULL COMMENT '菜单名',
  `icon` varchar(32) DEFAULT NULL COMMENT '图标',
  `sort` int(11) DEFAULT '10' COMMENT '排序',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '是否显示 1:显示 2:隐藏',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of my_menu
-- ----------------------------
BEGIN;
INSERT INTO `my_menu` VALUES (1, '会员管理', '&#xe6b8;', 20, 1, 1521768073);
INSERT INTO `my_menu` VALUES (2, '管理员管理', '&#xe726;', 16, 1, 1521768073);
INSERT INTO `my_menu` VALUES (3, '日志管理', '', 10, 1, 1521768073);
INSERT INTO `my_menu` VALUES (4, '系统设置', '', 8, 1, 1521768073);
COMMIT;

-- ----------------------------
-- Table structure for my_operate_log
-- ----------------------------
DROP TABLE IF EXISTS `my_operate_log`;
CREATE TABLE `my_operate_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '操作日志表',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `route_name` varchar(100) DEFAULT NULL COMMENT '路由名',
  `route` varchar(100) DEFAULT NULL COMMENT '路由',
  `param` text COMMENT '参数',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of my_operate_log
-- ----------------------------
BEGIN;
INSERT INTO `my_operate_log` VALUES (5, 1, '会员添加', 'member/create', '[]', 1553523661);
INSERT INTO `my_operate_log` VALUES (6, 1, '会员添加', 'member/create', '{\"nickname\":\"1234545\",\"email\":\"12123232\",\"tel\":\"17352909090\",\"status\":\"1\",\"pwd\":\"123\"}', 1553523684);
INSERT INTO `my_operate_log` VALUES (7, 1, '会员编辑', 'member/update', '{\"id\":\"58\"}', 1553523693);
INSERT INTO `my_operate_log` VALUES (8, 1, '会员编辑', 'member/update', '{\"id\":\"58\",\"nickname\":\"1234545\",\"email\":\"12123232@qq.com\",\"tel\":\"17352909090\",\"status\":\"1\",\"pwd\":\"\"}', 1553523699);
INSERT INTO `my_operate_log` VALUES (9, 1, '子菜单列表', 'menu/submenu', '{\"id\":\"3\"}', 1553525219);
INSERT INTO `my_operate_log` VALUES (10, 1, '路由列表', 'menu/route', '{\"id\":\"6\"}', 1553525223);
INSERT INTO `my_operate_log` VALUES (11, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"6\"}', 1553525225);
INSERT INTO `my_operate_log` VALUES (12, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"6\"}', 1553525274);
INSERT INTO `my_operate_log` VALUES (13, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"6\",\"route_name\":\"\\u64cd\\u4f5c\\u65e5\\u5fd7\\u67e5\\u770b\\u53c2\\u6570\",\"route\":\"operate-log\\/view\",\"status\":\"1\"}', 1553525306);
INSERT INTO `my_operate_log` VALUES (14, 1, '路由列表', 'menu/route', '{\"id\":\"6\"}', 1553525308);
INSERT INTO `my_operate_log` VALUES (15, 1, '角色编辑', 'role/update', '{\"id\":\"1\"}', 1553525316);
INSERT INTO `my_operate_log` VALUES (16, 1, '角色编辑', 'role/update', '{\"id\":\"1\",\"name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"description\":\"\\u62e5\\u6709\\u6240\\u6709\\u6743\\u9650\",\"ids\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"41\",\"42\",\"43\",\"44\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"38\",\"39\",\"40\",\"18\",\"19\",\"20\",\"21\",\"22\"]}', 1553525327);
INSERT INTO `my_operate_log` VALUES (17, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"16\"}', 1553525365);
INSERT INTO `my_operate_log` VALUES (18, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"17\"}', 1553525837);
INSERT INTO `my_operate_log` VALUES (19, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"15\"}', 1553525847);
INSERT INTO `my_operate_log` VALUES (20, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"17\"}', 1553525862);
INSERT INTO `my_operate_log` VALUES (21, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"17\"}', 1553525867);
INSERT INTO `my_operate_log` VALUES (22, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"13\"}', 1553525875);
INSERT INTO `my_operate_log` VALUES (23, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"17\"}', 1553525892);
INSERT INTO `my_operate_log` VALUES (24, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"23\"}', 1553526068);
INSERT INTO `my_operate_log` VALUES (25, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"23\"}', 1553526097);
INSERT INTO `my_operate_log` VALUES (26, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"25\"}', 1553526182);
INSERT INTO `my_operate_log` VALUES (27, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"26\"}', 1553526221);
INSERT INTO `my_operate_log` VALUES (28, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"26\"}', 1553526337);
INSERT INTO `my_operate_log` VALUES (29, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"28\"}', 1553526395);
INSERT INTO `my_operate_log` VALUES (30, 1, '管理员编辑', 'user/update', '{\"id\":\"7\"}', 1553526410);
INSERT INTO `my_operate_log` VALUES (31, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"28\"}', 1553526422);
INSERT INTO `my_operate_log` VALUES (32, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"31\"}', 1553526455);
INSERT INTO `my_operate_log` VALUES (33, 1, '操作日志查看参数', 'operate-log/view', '{\"id\":\"30\"}', 1553526482);
INSERT INTO `my_operate_log` VALUES (34, 1, '会员编辑', 'member/update', '{\"id\":\"58\"}', 1553528085);
INSERT INTO `my_operate_log` VALUES (35, 1, '会员编辑', 'member/update', '{\"id\":\"58\",\"nickname\":\"12345451\",\"email\":\"12123232@qq.com\",\"tel\":\"17352909090\",\"status\":\"1\",\"pwd\":\"\"}', 1553528091);
INSERT INTO `my_operate_log` VALUES (36, 1, '会员删除', 'member/del', '{\"id\":\"58\"}', 1553528100);
INSERT INTO `my_operate_log` VALUES (37, 1, '角色编辑', 'role/update', '{\"id\":\"1\"}', 1553528108);
INSERT INTO `my_operate_log` VALUES (38, 1, '角色编辑', 'role/update', '{\"id\":\"15\"}', 1553528121);
INSERT INTO `my_operate_log` VALUES (39, 1, '角色编辑', 'role/update', '{\"id\":\"15\",\"name\":\"财务\",\"description\":\"财务权限\",\"ids\":{\"0\":\"1\",\"6\":\"23\",\"7\":\"24\",\"8\":\"25\",\"9\":\"26\",\"10\":\"27\",\"11\":\"28\",\"12\":\"29\",\"13\":\"30\",\"14\":\"31\",\"15\":\"32\",\"16\":\"33\",\"17\":\"34\",\"18\":\"35\",\"19\":\"36\",\"20\":\"37\",\"21\":\"41\",\"25\":\"12\",\"31\":\"38\",\"34\":\"18\"}}', 1553528140);
INSERT INTO `my_operate_log` VALUES (40, 1, '子菜单添加', 'menu/submenu-create', '{\"menu_id\":\"1\"}', 1553559723);
INSERT INTO `my_operate_log` VALUES (41, 1, '角色编辑', 'role/update', '{\"id\":\"1\"}', 1553559843);
INSERT INTO `my_operate_log` VALUES (42, 1, '会员状态修改', 'member/change-status', '{\"id\":\"56\",\"status\":\"2\"}', 1553562837);
INSERT INTO `my_operate_log` VALUES (43, 1, '会员状态修改', 'member/change-status', '{\"id\":\"40\",\"status\":\"1\"}', 1553562840);
INSERT INTO `my_operate_log` VALUES (44, 1, '会员状态修改', 'member/change-status', '{\"id\":\"28\",\"status\":\"1\"}', 1553562872);
INSERT INTO `my_operate_log` VALUES (45, 1, '会员状态修改', 'member/change-status', '{\"id\":\"28\",\"status\":\"1\"}', 1553562873);
INSERT INTO `my_operate_log` VALUES (46, 1, '会员编辑', 'member/update', '{\"id\":\"28\"}', 1553562882);
INSERT INTO `my_operate_log` VALUES (47, 1, '管理员状态修改', 'user/change-status', '{\"id\":\"6\",\"status\":\"1\"}', 1553562913);
INSERT INTO `my_operate_log` VALUES (48, 1, '管理员编辑', 'user/update', '{\"id\":\"6\"}', 1553562915);
INSERT INTO `my_operate_log` VALUES (49, 1, '管理员状态修改', 'user/change-status', '{\"id\":\"6\",\"status\":\"1\"}', 1553562919);
INSERT INTO `my_operate_log` VALUES (50, 1, '管理员编辑', 'user/update', '{\"id\":\"7\"}', 1553563411);
INSERT INTO `my_operate_log` VALUES (51, 1, '管理员编辑', 'user/update', '{\"id\":\"1\"}', 1553595960);
INSERT INTO `my_operate_log` VALUES (52, 1, '管理员编辑', 'user/update', '{\"id\":\"1\",\"name\":\"admin\",\"role_id\":\"1\",\"status\":\"1\",\"pwd\":\"123456\"}', 1553595964);
INSERT INTO `my_operate_log` VALUES (53, 1, '子菜单添加', 'menu/submenu-create', '{\"menu_id\":\"4\"}', 1553599063);
INSERT INTO `my_operate_log` VALUES (54, 1, '子菜单添加', 'menu/submenu-create', '{\"menu_id\":\"4\"}', 1553599079);
INSERT INTO `my_operate_log` VALUES (55, 1, '子菜单添加', 'menu/submenu-create', '{\"menu_id\":\"4\",\"route_name\":\"系统设置\",\"route\":\"set\\/index\",\"sort\":\"10\",\"is_show\":\"1\"}', 1553599092);
INSERT INTO `my_operate_log` VALUES (56, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"7\"}', 1553599100);
INSERT INTO `my_operate_log` VALUES (57, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"7\",\"route_name\":\"系统设置查看\",\"route\":\"set\\/index\",\"status\":\"1\"}', 1553599121);
INSERT INTO `my_operate_log` VALUES (58, 1, '角色编辑', 'role/update', '{\"id\":\"1\"}', 1553599562);
INSERT INTO `my_operate_log` VALUES (59, 1, '角色编辑', 'role/update', '{\"id\":\"1\",\"name\":\"超级管理员\",\"description\":\"拥有所有权限\",\"ids\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"45\",\"41\",\"42\",\"43\",\"44\"]}', 1553599565);
INSERT INTO `my_operate_log` VALUES (60, 1, '菜单编辑', 'menu/update', '{\"id\":\"4\"}', 1553599619);
INSERT INTO `my_operate_log` VALUES (61, 1, '菜单编辑', 'menu/update', '{\"id\":\"4\",\"name\":\"系统设置\",\"icon\":\"\",\"sort\":\"12\",\"is_show\":\"1\"}', 1553599622);
INSERT INTO `my_operate_log` VALUES (62, 1, '菜单编辑', 'menu/update', '{\"id\":\"4\"}', 1553599628);
INSERT INTO `my_operate_log` VALUES (63, 1, '菜单编辑', 'menu/update', '{\"id\":\"4\",\"name\":\"系统设置\",\"icon\":\"\",\"sort\":\"8\",\"is_show\":\"1\"}', 1553599631);
INSERT INTO `my_operate_log` VALUES (64, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"7\"}', 1553603344);
INSERT INTO `my_operate_log` VALUES (65, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"7\",\"route_name\":\"系统网站设置修改\",\"route\":\"set\\/change-text\",\"status\":\"1\"}', 1553603409);
INSERT INTO `my_operate_log` VALUES (66, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"7\"}', 1553603412);
INSERT INTO `my_operate_log` VALUES (67, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"7\",\"route_name\":\"系统图片设置上传\",\"route\":\"set\\/change-img\",\"status\":\"1\"}', 1553603448);
INSERT INTO `my_operate_log` VALUES (68, 1, '角色编辑', 'role/update', '{\"id\":\"1\"}', 1553603455);
INSERT INTO `my_operate_log` VALUES (69, 1, '角色编辑', 'role/update', '{\"id\":\"1\",\"name\":\"超级管理员\",\"description\":\"拥有所有权限\",\"ids\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\",\"40\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"45\",\"46\",\"47\",\"18\",\"19\",\"20\",\"21\",\"22\",\"41\",\"42\",\"43\",\"44\"]}', 1553603459);
INSERT INTO `my_operate_log` VALUES (70, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"3\",\"val\":\"测试值\"}', 1553603471);
INSERT INTO `my_operate_log` VALUES (71, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"3\",\"val\":\"测试值\"}', 1553603473);
INSERT INTO `my_operate_log` VALUES (72, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"3\",\"val\":\"测试值\"}', 1553603476);
INSERT INTO `my_operate_log` VALUES (73, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"1\",\"val\":\"Colin CMS\"}', 1553603482);
INSERT INTO `my_operate_log` VALUES (74, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"1\",\"val\":\"Colin CMS2\"}', 1553603483);
INSERT INTO `my_operate_log` VALUES (75, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"3\",\"val\":\"测试值2\"}', 1553603485);
INSERT INTO `my_operate_log` VALUES (76, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"3\",\"val\":\"测试值\"}', 1553603487);
INSERT INTO `my_operate_log` VALUES (77, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"1\",\"val\":\"Colin CMS\"}', 1553603489);
INSERT INTO `my_operate_log` VALUES (78, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"3\",\"val\":\"测试值\"}', 1553603491);
INSERT INTO `my_operate_log` VALUES (79, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"1\",\"val\":\"Colin CMS2\"}', 1553603493);
INSERT INTO `my_operate_log` VALUES (80, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"1\",\"val\":\"Colin CMS\"}', 1553603511);
INSERT INTO `my_operate_log` VALUES (81, 1, '系统图片设置上传', 'set/change-img', '[]', 1553604397);
INSERT INTO `my_operate_log` VALUES (82, 1, '系统图片设置上传', 'set/change-img', '[]', 1553604785);
INSERT INTO `my_operate_log` VALUES (83, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"D:\\\\softwares\\\\phpStudy\\\\PHPTutorial\\\\WWW\\\\cms\\/uploads\\/image\\/20190326\\/5c9a20b19e059.jpg\"}', 1553604785);
INSERT INTO `my_operate_log` VALUES (84, 1, '系统图片设置上传', 'set/change-img', '[]', 1553604861);
INSERT INTO `my_operate_log` VALUES (85, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"D:\\\\softwares\\\\phpStudy\\\\PHPTutorial\\\\WWW\\\\cms\\/uploads\\/image\\/20190326\\/5c9a20fdea485.jpg\"}', 1553604862);
INSERT INTO `my_operate_log` VALUES (86, 1, '系统图片设置上传', 'set/change-img', '[]', 1553604942);
INSERT INTO `my_operate_log` VALUES (87, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605006);
INSERT INTO `my_operate_log` VALUES (88, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"D:\\\\softwares\\\\phpStudy\\\\PHPTutorial\\\\WWW\\\\cms\\/uploads\\/image\\/20190326\\/5c9a218e10d00.png\"}', 1553605006);
INSERT INTO `my_operate_log` VALUES (89, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605086);
INSERT INTO `my_operate_log` VALUES (90, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"http:\\/\\/dev.xadmin.com\\/uploads\\/image\\/20190326\\/5c9a21de8fab5.png\"}', 1553605086);
INSERT INTO `my_operate_log` VALUES (91, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605307);
INSERT INTO `my_operate_log` VALUES (92, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"http:\\/\\/dev.xadmin.com\\/uploads\\/image\\/20190326\\/5c9a22bbb1466.png\"}', 1553605307);
INSERT INTO `my_operate_log` VALUES (93, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605398);
INSERT INTO `my_operate_log` VALUES (94, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"http:\\/\\/dev.xadmin.com\\/uploads\\/image\\/20190326\\/5c9a23165c9a7.jpg\"}', 1553605398);
INSERT INTO `my_operate_log` VALUES (95, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605454);
INSERT INTO `my_operate_log` VALUES (96, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605520);
INSERT INTO `my_operate_log` VALUES (97, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605572);
INSERT INTO `my_operate_log` VALUES (98, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605655);
INSERT INTO `my_operate_log` VALUES (99, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605730);
INSERT INTO `my_operate_log` VALUES (100, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605758);
INSERT INTO `my_operate_log` VALUES (101, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"uploads\\/image\\/20190326\\/5c9a247ee24cd.jpg\"}', 1553605759);
INSERT INTO `my_operate_log` VALUES (102, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605868);
INSERT INTO `my_operate_log` VALUES (103, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a24ecb9d77.png\"}', 1553605868);
INSERT INTO `my_operate_log` VALUES (104, 1, '系统图片设置上传', 'set/change-img', '[]', 1553605946);
INSERT INTO `my_operate_log` VALUES (105, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a253a79fc6.jpg\"}', 1553605946);
INSERT INTO `my_operate_log` VALUES (106, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606082);
INSERT INTO `my_operate_log` VALUES (107, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a25c27ae89.png\"}', 1553606082);
INSERT INTO `my_operate_log` VALUES (108, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606090);
INSERT INTO `my_operate_log` VALUES (109, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a25ca36a82.gif\"}', 1553606090);
INSERT INTO `my_operate_log` VALUES (110, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606091);
INSERT INTO `my_operate_log` VALUES (111, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"4\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a25cb35733.gif\"}', 1553606091);
INSERT INTO `my_operate_log` VALUES (112, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606146);
INSERT INTO `my_operate_log` VALUES (113, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"4\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a2602dfe7d.png\"}', 1553606147);
INSERT INTO `my_operate_log` VALUES (114, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606152);
INSERT INTO `my_operate_log` VALUES (115, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"4\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a2608871df.png\"}', 1553606152);
INSERT INTO `my_operate_log` VALUES (116, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606153);
INSERT INTO `my_operate_log` VALUES (117, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a26099450b.png\"}', 1553606153);
INSERT INTO `my_operate_log` VALUES (118, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606176);
INSERT INTO `my_operate_log` VALUES (119, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a2620c2c82.png\"}', 1553606176);
INSERT INTO `my_operate_log` VALUES (120, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606180);
INSERT INTO `my_operate_log` VALUES (121, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a26249eb3e.jpg\"}', 1553606180);
INSERT INTO `my_operate_log` VALUES (122, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606181);
INSERT INTO `my_operate_log` VALUES (123, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a26259ff00.jpg\"}', 1553606181);
INSERT INTO `my_operate_log` VALUES (124, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606319);
INSERT INTO `my_operate_log` VALUES (125, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a26afd2739.png\"}', 1553606319);
INSERT INTO `my_operate_log` VALUES (126, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606323);
INSERT INTO `my_operate_log` VALUES (127, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a26b354090.gif\"}', 1553606323);
INSERT INTO `my_operate_log` VALUES (128, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606326);
INSERT INTO `my_operate_log` VALUES (129, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"4\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a26b6dd894.png\"}', 1553606327);
INSERT INTO `my_operate_log` VALUES (130, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606331);
INSERT INTO `my_operate_log` VALUES (131, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"4\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a26bb0e131.png\"}', 1553606331);
INSERT INTO `my_operate_log` VALUES (132, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606340);
INSERT INTO `my_operate_log` VALUES (133, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a26c437f36.png\"}', 1553606340);
INSERT INTO `my_operate_log` VALUES (134, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"3\",\"val\":\"测试值1\"}', 1553606385);
INSERT INTO `my_operate_log` VALUES (135, 1, '系统网站设置修改', 'set/change-text', '{\"id\":\"3\",\"val\":\"测试值\"}', 1553606387);
INSERT INTO `my_operate_log` VALUES (136, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606472);
INSERT INTO `my_operate_log` VALUES (137, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"2\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a27484e4d9.png\"}', 1553606472);
INSERT INTO `my_operate_log` VALUES (138, 1, '系统图片设置上传', 'set/change-img', '[]', 1553606475);
INSERT INTO `my_operate_log` VALUES (139, 1, '系统图片设置上传', 'set/change-img', '{\"id\":\"4\",\"val\":\"\\/uploads\\/image\\/20190326\\/5c9a274b460b2.png\"}', 1553606475);
INSERT INTO `my_operate_log` VALUES (140, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"1\"}', 1555930906);
INSERT INTO `my_operate_log` VALUES (141, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"1\"}', 1555930913);
INSERT INTO `my_operate_log` VALUES (142, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"1\",\"route_name\":\"member\\/export\",\"route\":\"数据导出\",\"status\":\"1\"}', 1555930932);
INSERT INTO `my_operate_log` VALUES (143, 1, '路由编辑', 'menu/route-update', '{\"id\":\"48\"}', 1555930939);
INSERT INTO `my_operate_log` VALUES (144, 1, '路由编辑', 'menu/route-update', '{\"id\":\"48\",\"route_name\":\"数据导出\",\"route\":\"member\\/export\",\"status\":\"1\"}', 1555930949);
INSERT INTO `my_operate_log` VALUES (145, 1, '角色编辑', 'role/update', '{\"id\":\"1\"}', 1555930959);
INSERT INTO `my_operate_log` VALUES (146, 1, '角色编辑', 'role/update', '{\"id\":\"1\",\"name\":\"超级管理员\",\"description\":\"拥有所有权限\",\"ids\":[\"45\",\"46\",\"47\",\"41\",\"42\",\"43\",\"44\",\"38\",\"39\",\"40\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"18\",\"19\",\"20\",\"21\",\"22\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"48\"],\"submenu_name\":{\"6\":\"on\"}}', 1555930964);
INSERT INTO `my_operate_log` VALUES (147, 1, '数据导出', 'member/export', '[]', 1555930971);
INSERT INTO `my_operate_log` VALUES (148, 1, '数据导出', 'member/export', '[]', 1555931009);
INSERT INTO `my_operate_log` VALUES (149, 1, '数据导出', 'member/export', '[]', 1555931072);
INSERT INTO `my_operate_log` VALUES (150, 1, '数据导出', 'member/export', '[]', 1555931104);
INSERT INTO `my_operate_log` VALUES (151, 1, '数据导出', 'member/export', '[]', 1555931185);
INSERT INTO `my_operate_log` VALUES (152, 1, '数据导出', 'member/export', '[]', 1555931218);
INSERT INTO `my_operate_log` VALUES (153, 1, '数据导出', 'member/export', '{\"search\":{\"nickname\":\"test\",\"tel\":\"\",\"b_time\":\"\",\"e_time\":\"\"}}', 1555931276);
INSERT INTO `my_operate_log` VALUES (154, 1, '数据导出', 'member/export', '{\"search\":{\"nickname\":\"test\",\"tel\":\"\",\"b_time\":\"\",\"e_time\":\"\"}}', 1555931338);
INSERT INTO `my_operate_log` VALUES (155, 1, '数据导出', 'member/export', '[]', 1557297926);
INSERT INTO `my_operate_log` VALUES (156, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"5\"}', 1557309331);
INSERT INTO `my_operate_log` VALUES (157, 1, '路由添加', 'menu/route-create', '{\"submenu_id\":\"5\",\"route_name\":\"查看UA\",\"route\":\"login-log\\/view\",\"status\":\"1\"}', 1557309365);
INSERT INTO `my_operate_log` VALUES (158, 1, '管理员编辑', 'user/update', '{\"id\":\"1\"}', 1557309377);
INSERT INTO `my_operate_log` VALUES (159, 1, '角色编辑', 'role/update', '{\"id\":\"1\"}', 1557309382);
INSERT INTO `my_operate_log` VALUES (160, 1, '角色编辑', 'role/update', '{\"id\":\"1\",\"name\":\"超级管理员\",\"description\":\"拥有所有权限\",\"ids\":[\"45\",\"46\",\"47\",\"41\",\"42\",\"43\",\"44\",\"38\",\"39\",\"40\",\"49\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"18\",\"19\",\"20\",\"21\",\"22\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"48\"]}', 1557309388);
INSERT INTO `my_operate_log` VALUES (161, 1, '会员状态修改', 'member/change-status', '{\"s\":\"\\/\\/member\\/change-status\",\"id\":\"57\",\"status\":\"2\"}', 1585550297);
INSERT INTO `my_operate_log` VALUES (162, 1, '会员状态修改', 'member/change-status', '{\"s\":\"\\/\\/member\\/change-status\",\"id\":\"43\",\"status\":\"2\"}', 1585550298);
INSERT INTO `my_operate_log` VALUES (163, 1, '会员状态修改', 'member/change-status', '{\"s\":\"\\/\\/member\\/change-status\",\"id\":\"40\",\"status\":\"2\"}', 1585550300);
INSERT INTO `my_operate_log` VALUES (164, 1, '会员状态修改', 'member/change-status', '{\"s\":\"\\/\\/member\\/change-status\",\"id\":\"36\",\"status\":\"2\"}', 1585550300);
INSERT INTO `my_operate_log` VALUES (165, 1, '会员添加', 'member/create', '{\"s\":\"\\/\\/member\\/create\"}', 1585550301);
INSERT INTO `my_operate_log` VALUES (166, 1, '管理员删除', 'user/del', '{\"s\":\"\\/\\/user\\/del\",\"id\":\"7\"}', 1585550488);
INSERT INTO `my_operate_log` VALUES (167, 1, '管理员删除', 'user/del', '{\"s\":\"\\/\\/user\\/del\",\"id\":\"6\"}', 1585550492);
INSERT INTO `my_operate_log` VALUES (168, 1, '角色删除', 'role/del', '{\"s\":\"\\/\\/role\\/del\",\"id\":\"15\"}', 1585550499);
INSERT INTO `my_operate_log` VALUES (169, 1, '角色删除', 'role/del', '{\"s\":\"\\/\\/role\\/del\",\"id\":\"7\"}', 1585550502);
INSERT INTO `my_operate_log` VALUES (170, 1, '角色删除', 'role/del', '{\"s\":\"\\/\\/role\\/del\",\"id\":\"4\"}', 1585550505);
INSERT INTO `my_operate_log` VALUES (171, 1, '系统网站设置修改', 'set/change-text', '{\"s\":\"\\/\\/set\\/change-text\",\"id\":\"1\",\"val\":\"Yii通用管理系统\"}', 1585550830);
COMMIT;

-- ----------------------------
-- Table structure for my_role
-- ----------------------------
DROP TABLE IF EXISTS `my_role`;
CREATE TABLE `my_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户角色表',
  `name` varchar(50) DEFAULT NULL COMMENT '角色名',
  `description` varchar(100) DEFAULT NULL COMMENT '角色描述',
  `permission` varchar(500) DEFAULT NULL COMMENT '权限',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of my_role
-- ----------------------------
BEGIN;
INSERT INTO `my_role` VALUES (1, '超级管理员', '拥有所有权限', '[45,46,47,41,42,43,44,38,39,40,49,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,18,19,20,21,22,12,13,14,15,16,17,1,2,3,4,5,6,48]', 1557309388);
COMMIT;

-- ----------------------------
-- Table structure for my_route
-- ----------------------------
DROP TABLE IF EXISTS `my_route`;
CREATE TABLE `my_route` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '路由表',
  `submenu_id` int(11) DEFAULT NULL COMMENT '子菜单id',
  `route_name` varchar(100) DEFAULT NULL COMMENT '路由名',
  `route` varchar(100) DEFAULT NULL COMMENT '路由',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1:启用 2:禁用',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of my_route
-- ----------------------------
BEGIN;
INSERT INTO `my_route` VALUES (1, 1, '会员列表', 'member/index', 1, 1521768073);
INSERT INTO `my_route` VALUES (2, 1, '会员删除', 'member/del', 1, 1521768073);
INSERT INTO `my_route` VALUES (3, 1, '会员批量删除', 'member/batch-del', 1, 1521768073);
INSERT INTO `my_route` VALUES (4, 1, '会员添加', 'member/create', 1, 1521768073);
INSERT INTO `my_route` VALUES (5, 1, '会员编辑', 'member/update', 1, 1521768073);
INSERT INTO `my_route` VALUES (6, 1, '会员状态修改', 'member/change-status', 1, 1521768073);
INSERT INTO `my_route` VALUES (12, 2, '管理员列表', 'user/index', 1, 1553244064);
INSERT INTO `my_route` VALUES (13, 2, '管理员删除', 'user/del', 1, 1553244091);
INSERT INTO `my_route` VALUES (14, 2, '管理员批量删除', 'user/batch-del', 1, 1553244124);
INSERT INTO `my_route` VALUES (15, 2, '管理员添加', 'user/create', 1, 1553244151);
INSERT INTO `my_route` VALUES (16, 2, '管理员编辑', 'user/update', 1, 1553244172);
INSERT INTO `my_route` VALUES (17, 2, '管理员状态修改', 'user/change-status', 1, 1553244208);
INSERT INTO `my_route` VALUES (18, 3, '角色列表', 'role/index', 1, 1553244281);
INSERT INTO `my_route` VALUES (19, 3, '角色删除', 'role/del', 1, 1553244307);
INSERT INTO `my_route` VALUES (20, 3, '角色批量删除', 'role/batch-del', 1, 1553244335);
INSERT INTO `my_route` VALUES (21, 3, '角色添加', 'role/create', 1, 1553244359);
INSERT INTO `my_route` VALUES (22, 3, '角色编辑', 'role/update', 1, 1553244392);
INSERT INTO `my_route` VALUES (23, 4, '菜单列表', 'menu/index', 1, 1553245834);
INSERT INTO `my_route` VALUES (24, 4, '菜单删除', 'menu/del', 1, 1553245871);
INSERT INTO `my_route` VALUES (25, 4, '菜单批量删除', 'menu/batch-del', 1, 1553246089);
INSERT INTO `my_route` VALUES (26, 4, ' 菜单添加', 'menu/create', 1, 1553246123);
INSERT INTO `my_route` VALUES (27, 4, '菜单编辑', 'menu/update', 1, 1553246169);
INSERT INTO `my_route` VALUES (28, 4, '子菜单列表', 'menu/submenu', 1, 1553246215);
INSERT INTO `my_route` VALUES (29, 4, '子菜单删除', 'menu/submenu-del', 1, 1553246313);
INSERT INTO `my_route` VALUES (30, 4, '子菜单批量删除', 'menu/submenu-batch-del', 1, 1553246362);
INSERT INTO `my_route` VALUES (31, 4, '子菜单添加', 'menu/submenu-create', 1, 1553246414);
INSERT INTO `my_route` VALUES (32, 4, '子菜单更新', 'menu/submenu-update', 1, 1553246441);
INSERT INTO `my_route` VALUES (33, 4, '路由列表', 'menu/route', 1, 1553246467);
INSERT INTO `my_route` VALUES (34, 4, '路由删除', 'menu/route-del', 1, 1553246494);
INSERT INTO `my_route` VALUES (35, 4, '路由批量删除', 'menu/route-batch-del', 1, 1553246527);
INSERT INTO `my_route` VALUES (36, 4, '路由添加', 'menu/route-create', 1, 1553246558);
INSERT INTO `my_route` VALUES (37, 4, '路由编辑', 'menu/route-update', 1, 1553246585);
INSERT INTO `my_route` VALUES (38, 5, '登陆日志列表', 'login-log/index', 1, 1553436275);
INSERT INTO `my_route` VALUES (39, 5, '登陆日志删除', 'login-log/del', 1, 1553436909);
INSERT INTO `my_route` VALUES (40, 5, '登陆日志批量删除', 'login-log/batch-del', 1, 1553436940);
INSERT INTO `my_route` VALUES (41, 6, '操作日志列表', 'operate-log/index', 1, 1553521420);
INSERT INTO `my_route` VALUES (42, 6, '操作日志删除', 'operate-log/del', 1, 1553521445);
INSERT INTO `my_route` VALUES (43, 6, '操作日志批量删除', 'operate-log/batch-del', 1, 1553521474);
INSERT INTO `my_route` VALUES (44, 6, '操作日志查看参数', 'operate-log/view', 1, 1553525306);
INSERT INTO `my_route` VALUES (45, 7, '系统设置查看', 'set/index', 1, 1553599121);
INSERT INTO `my_route` VALUES (46, 7, '系统网站设置修改', 'set/change-text', 1, 1553603409);
INSERT INTO `my_route` VALUES (47, 7, '系统图片设置上传', 'set/change-img', 1, 1553603448);
INSERT INTO `my_route` VALUES (48, 1, '数据导出', 'member/export', 1, 1555930932);
INSERT INTO `my_route` VALUES (49, 5, '查看UA', 'login-log/view', 1, 1557309365);
COMMIT;

-- ----------------------------
-- Table structure for my_set
-- ----------------------------
DROP TABLE IF EXISTS `my_set`;
CREATE TABLE `my_set` (
  `id` int(31) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统设置表',
  `key` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '键',
  `desc` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '描述',
  `value` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '值',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型 1:文本 2:图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of my_set
-- ----------------------------
BEGIN;
INSERT INTO `my_set` VALUES (1, 'title', '网站标题', 'Yii通用管理系统', 1);
INSERT INTO `my_set` VALUES (2, 'logo', 'logo', '/uploads/image/20190326/5c9a27484e4d9.png', 2);
INSERT INTO `my_set` VALUES (3, 'test', '测试', '测试值', 1);
INSERT INTO `my_set` VALUES (4, 'test_img', '测试图片', '/uploads/image/20190326/5c9a274b460b2.png', 2);
COMMIT;

-- ----------------------------
-- Table structure for my_submenu
-- ----------------------------
DROP TABLE IF EXISTS `my_submenu`;
CREATE TABLE `my_submenu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '子菜单表',
  `menu_id` int(11) DEFAULT NULL COMMENT '主菜单id',
  `route_name` varchar(100) DEFAULT NULL COMMENT '路由名',
  `route` varchar(100) DEFAULT NULL COMMENT '路由',
  `sort` int(11) DEFAULT '10' COMMENT '排序',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '是否显示 1:显示 2:隐藏',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of my_submenu
-- ----------------------------
BEGIN;
INSERT INTO `my_submenu` VALUES (1, 1, '会员管理', 'member/index', 10, 1, 1521768073);
INSERT INTO `my_submenu` VALUES (2, 2, '管理员管理', 'user/index', 10, 1, 1521768073);
INSERT INTO `my_submenu` VALUES (3, 2, '角色管理', 'role/index', 10, 1, 1521768073);
INSERT INTO `my_submenu` VALUES (4, 2, '菜单路由管理', 'menu/index', 10, 1, 1521768073);
INSERT INTO `my_submenu` VALUES (5, 3, '登陆日志', 'login-log/index', 10, 1, 1553436248);
INSERT INTO `my_submenu` VALUES (6, 3, '操作日志', 'operate-log/index', 10, 1, 1553521325);
INSERT INTO `my_submenu` VALUES (7, 4, '系统设置', 'set/index', 10, 1, 1553599092);
COMMIT;

-- ----------------------------
-- Table structure for my_user
-- ----------------------------
DROP TABLE IF EXISTS `my_user`;
CREATE TABLE `my_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台用户表',
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  `name` varchar(100) DEFAULT NULL COMMENT '用户名',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 1:启用 2:禁用',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of my_user
-- ----------------------------
BEGIN;
INSERT INTO `my_user` VALUES (1, 1, 'admin', '$2y$13$Ln878YXekD23XBX8Xexyse3ys8dFBJRJf3CV5hoB3Uz.CDXgmYIn2', 1, 1521768073);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
