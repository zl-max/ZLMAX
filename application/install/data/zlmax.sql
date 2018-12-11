
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zl_role
-- ----------------------------
DROP TABLE IF EXISTS `zl_role`;
CREATE TABLE `zl_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zl_user
-- ----------------------------
DROP TABLE IF EXISTS `zl_user`;
CREATE TABLE `zl_user` (
  `id` bigint(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `userpwd` char(36) NOT NULL,
  `useremail` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
