# 1.服务分类字典表
create table bt_category(
    `id` int unsigned not null auto_increment ,
    `code` varchar(20) not null ,
    `name` varchar(50) not null ,
    `parent_id` int unsigned not null ,
    `listorder` int unsigned not null ,
    `status` varchar(1) not null default 'Y',
    `create_time` datetime default current_timestamp,
    `update_time` datetime,
    primary key (`id`),
    key (`parent_id`),
    key (`name`),
    unique key(`code`)
)engine =InnoDB default charset =utf8;

# 2.城市字典表
create table bt_city(
    `id` int unsigned not null auto_increment ,
    `code` varchar(20) not null ,
    `name` varchar(50) not null ,
    `parent_id` int unsigned not null ,
    `listorder` int unsigned not null ,
    `status` varchar(1) not null default 'Y',
    `create_time` datetime default current_timestamp,
    `update_time` datetime,
    primary key (`id`),
    key (`parent_id`),
    key (`name`),
    unique key(`code`)
)engine =InnoDB default charset =utf8;

# 3.商组表
create table bs_area(
    `id` int unsigned not null auto_increment ,
    `name` varchar(50) not null ,
    `city_id` int unsigned,
    `parent_id` int unsigned not null ,
    `listorder` int unsigned not null ,
    `status` varchar(1) not null default 'Y',
    `create_time` datetime default current_timestamp,
    `update_time` datetime,
    primary key (`id`),
    foreign key (`city_id`) references bt_city(`id`),
    key (`parent_id`),
    key (`name`),
    key(`city_id`)
)engine =InnoDB default charset =utf8;

# 4.商户表
create table bs_busi(
    `id` int unsigned not null auto_increment ,
    `name` varchar(50) not null ,
    `email` varchar(50) not null ,
    `logo` varchar(255) not null ,
    `licence_logo` varchar(255) not null ,
    `desc` text,
    `city_id` int unsigned,
    `city_path` varchar(50),
    `bank_info` varchar(50),
    `money` decimal(20,2),
    `bank_name` varchar(50),
    `bank_user` varchar(20),
    `faren` varchar(20),
    `faren_tel` varchar(20),
    `parent_id` int unsigned not null ,
    `listorder` int unsigned not null ,
    `status` varchar(1) not null default 'Y',
    `create_time` datetime default current_timestamp,
    `update_time` datetime,
    primary key (`id`),
    foreign key (`city_id`) references bt_city(`id`),
    key (`parent_id`),
    key (`name`),
    key(`city_id`)
)engine =InnoDB default charset =utf8;

# 5.商户账号表
create table bs_busi_account(
    `id` int unsigned not null auto_increment ,
    `username` varchar(50) not null ,
    `password` varchar(32) not null ,
    `code` varchar(10) not null ,
    `busi_id` int unsigned ,
    `last_login_ip` varchar(20),
    `last_login_time` datetime,
    `is_main` varchar(1) default 'N',
    `listorder` int unsigned not null ,
    `status` varchar(1) not null default 'Y',
    `create_time` datetime default current_timestamp,
    `update_time` datetime,
    primary key (`id`),
    foreign key (`busi_id`) references bs_busi(`id`),
    key (`busi_id`),
    key (`username`)
)engine =InnoDB default charset =utf8;

# 6.商户门店表
create table bs_busi_location(
    `id` int unsigned not null auto_increment ,
    `name` varchar(50) not null ,
    `logo` varchar(255) not null ,
    `address` varchar(255) not null ,
    `tel` varchar(20),
    `contact` varchar(20),
    `xpoint` varchar(20),
    `ypoint` varchar(20),
    `busi_id` int unsigned ,
    `open_time` datetime,
    `content` text,
    `api_address` varchar(255),
    `city_id` int unsigned,
    `city_path` varchar(50),
    `category_id` int unsigned,
    `category_path` varchar(50),
    `bank_info` varchar(50),
    `is_main` varchar(1) default 'N',
    `listorder` int unsigned not null ,
    `status` varchar(1) not null default 'Y',
    `create_time` datetime default current_timestamp,
    `update_time` datetime,
    primary key (`id`),
    foreign key (`busi_id`) references bs_busi(`id`),
    foreign key (`city_id`) references bt_city(`id`),
    foreign key (`category_id`) references bt_category(`id`),
    key (`busi_id`),
    key (`city_id`),
    key (`category_id`),
    key (`name`)
)engine =InnoDB default charset =utf8;

# 7.团购商品表
create table `bt_deal`(
    `id` int unsigned not null  auto_increment,
    `name` varchar(100) not null ,
    `category_id` int unsigned not null ,
    `sec_category_id` int unsigned not null ,
    `busi_id` int unsigned not null ,
    `location_ids` varchar(100),
    `image` varchar(200),
    `desc` text,
    `start_time` datetime,
    `end_time` datetime,
    `origin_price` decimal(20,2) not null ,
    `current_price` decimal(20,2) not null ,
    `city_id` int unsigned,
    `buy_count` int unsigned,
    `total_coumt` int unsigned,
    `coupons_begin_time` datetime,  # 优惠券时间
    `coupons_end_time` datetime,
    `xpoint` varchar(20),
    `ypoint` varchar(20),
    `busi_account_id` int unsigned,
    `balance_price` decimal(20,2),
    `notes` varchar(255),
    `listorder` int unsigned not null ,
    `status` varchar(1) not null default 'Y',
    `create_time` datetime default current_timestamp,
    `update_time` datetime,
    primary key (`id`),
    foreign key (`category_id`) references bt_category(`id`),
    foreign key (`sec_category_id`) references bt_category(`id`),
    foreign key (`busi_id`) references bs_busi(`id`),
    foreign key (`city_id`) references bt_city(`id`),
    foreign key (`busi_account_id`) references bs_busi_account(`id`),
    key (`category_id`),
    key (`sec_category_id`),
    key (`city_id`),
    key (`start_time`),
    key (`end_time`),
    key (`coupons_begin_time`),
    key (`coupons_end_time`),
    key (`coupons_end_time`)
)engine =InnoDB default charset =utf8;

# 8.用户表
create table `bt_user`(
      `id` int unsigned not null auto_increment ,
      `username` varchar(50) not null ,
      `password` varchar(32) not null ,
      `code` varchar(10) not null ,
      `last_login_ip` varchar(20),
      `last_login_time` datetime,
      `email` varchar(30),
      `mobile` varchar(20),
      `listorder` int unsigned not null ,
      `status` varchar(1) not null default 'Y',
      `create_time` datetime default current_timestamp,
      `update_time` datetime,
      primary key (`id`),
      unique key (`username`),
      unique key (`email`)
)engine =InnoDB default charset =utf8;

# 9.推荐位表
create table `bs_recommend`(
      `id` int unsigned not null auto_increment ,
      `type` varchar(1) ,
      `title` varchar(32) not null ,
      `image` varchar(255)  ,
      `url` varchar(255),
      `desc` varchar(500),
      `listorder` int unsigned not null ,
      `status` varchar(1) not null default 'Y',
      `create_time` datetime default current_timestamp,
      `update_time` datetime,
      primary key (`id`)
)engine =InnoDB default charset =utf8;

# 10.订单表
CREATE TABLE `bs_order` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `order_no` varchar(100) NOT NULL COMMENT '订单号',
    `transaction_no` varchar(100) NOT NULL COMMENT '微信支付交易号',
    `user_id` int(10) unsigned DEFAULT NULL COMMENT '用户id',
    `user_name` varchar(100) DEFAULT NULL,
    `pay_time` datetime DEFAULT NULL COMMENT '支付时间',
    `pay_mode` varchar(10) DEFAULT NULL COMMENT '支付方式',
    `grobuy_id` int(10) unsigned DEFAULT NULL COMMENT '商品id',
    `grobuy_count` int(10) unsigned DEFAULT NULL,
    `pay_status` varchar(2) DEFAULT NULL COMMENT '支付状态',
    `total_amount` decimal(20,2) DEFAULT NULL COMMENT '总额',
    `pay_amount` decimal(20,2) DEFAULT NULL COMMENT '支付总额',
    `refer_url` varchar(300) DEFAULT NULL COMMENT '订单源URL',
    `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
    `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `order_no` (`order_no`),
    UNIQUE KEY `transaction_no` (`transaction_no`),
    KEY `user_id` (`user_id`),
    KEY `grobuy_id` (`grobuy_id`),
    KEY `bs_order_pay_time_IDX` (`pay_time`) USING BTREE,
    KEY `bs_order_pay_mode_IDX` (`pay_mode`) USING BTREE,
    KEY `bs_order_user_name_IDX` (`user_name`) USING BTREE,
    KEY `bs_order_pay_status_IDX` (`pay_status`) USING BTREE,
    CONSTRAINT `bs_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `bt_user` (`id`),
    CONSTRAINT `bs_order_ibfk_2` FOREIGN KEY (`grobuy_id`) REFERENCES `bt_grobuy` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='订单表';



