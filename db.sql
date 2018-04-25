-- 存储游戏注册码的数据表
CREATE TABLE `data` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `code` int(10) unsigned NOT NULL,
 `status` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 UNIQUE KEY `code` (`code`),
 KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

-- 此表用于存储模拟被用户成功抢到的注册码
CREATE TABLE `orders` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `code` int(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8