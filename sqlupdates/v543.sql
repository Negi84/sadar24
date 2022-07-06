UPDATE `business_settings` SET `value` = '5.4.3' WHERE `business_settings`.`type` = 'current_version';

alter table orders add  column sla_breach tinyint default 0; 
insert into `business_settings` (`type`,`value`) values ('sla_time','72'); 
insert into `business_settings` (`type`,`value`) values ('sla_charge_type','flat'); 
insert into `business_settings` (`type`,`value`) values ('sla_charge','100'); 

CREATE TABLE `recently_viewed_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `products` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `type` enum('guest','user') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

 CREATE TABLE `sla_breach_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `sla_amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sla_breach_orders_order_id_index` (`order_id`),
  CONSTRAINT `sla_breach_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=280 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

--recently viewed items
alter table products add cross_id mediumtext default '[]'  after colors; 
alter table products add up_id mediumtext default '[]'  after colors; 
COMMIT;
