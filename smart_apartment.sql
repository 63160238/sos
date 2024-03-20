CREATE TABLE `smart_apartment`.`users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_card` VARCHAR(13) NOT NULL,
  `prename` VARCHAR(20) NOT NULL,
  `fname_th` VARCHAR(100) NOT NULL,
  `fname_en` VARCHAR(100) NOT NULL,
  `lname_th` VARCHAR(100) NOT NULL,
  `lname_en` VARCHAR(100) NOT NULL,
  `position` VARCHAR(100) NOT NULL,
  `role` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT(11) NOT NULL,
  `created_ip` VARCHAR(50) NOT NULL,
  `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `updated_ip` VARCHAR(50) NULL DEFAULT NULL,
  `status` ENUM('1','0','-1') NOT NULL DEFAULT '1',
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`user_id`)) ENGINE = InnoDB;

INSERT INTO `users` (`user_id`, `id_card`, `prename`, `fname_th`, `fname_en`, `lname_th`, `lname_en`, `position`, `role`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `status`, `last_login`, `username`, `password`) VALUES
('-9', '212224236', 'นาย', 'ivsoft', 'ivsoft', 'admin', 'admin', 'admin', '4', current_timestamp(), '-9', '127.0.0.1', NULL, NULL, NULL, '1', NULL, 'ivsoft', '$2y$10$FT8qnVIG0JDaThYUQhHUV.12DLIPKXeFuZTbTx3iindVzoA5ycFQC');

ALTER TABLE `users` MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

CREATE TABLE `smart_apartment`.`system_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `action` TEXT NOT NULL,
  `table_name` TEXT NOT NULL,
  `related_data` TEXT NOT NULL,
  `command` TEXT NOT NULL,
  `user` INT(11) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `smart_apartment`.`map_info` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `emb_id` INT(11) NOT NULL ,
  `addr` VARCHAR(150) NOT NULL ,
  `type` ENUM('p','w') NOT NULL COMMENT 'p = ไฟฟ้า\r\nw = น้ำ' ,
  `loc_id` VARCHAR(150) NOT NULL ,
  `ss_label` VARCHAR(150) NOT NULL ,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `smart_apartment`. `water_display` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `date_time` TIMESTAMP NOT NULL ,
  `loc_id` VARCHAR(150) NOT NULL ,
  `flow_sum` DOUBLE(7,2) NOT NULL ,
  `flow_rate` DOUBLE(3,2) NOT NULL ,
  `vbatt` DOUBLE(3,2) NOT NULL ,
  `ss_label` VARCHAR(150) NOT NULL ,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `smart_apartment`.`power_display` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `date_time` TIMESTAMP NOT NULL ,
  `loc_id` VARCHAR(150) NOT NULL ,
  `va` DOUBLE(5,4) NOT NULL ,
  `vb` DOUBLE(5,4) NOT NULL ,
  `vc` DOUBLE(5,4) NOT NULL ,
  `vavg` DOUBLE(5,4) NOT NULL ,
  `ia` DOUBLE(5,4) NOT NULL ,
  `ib` DOUBLE(5,4) NOT NULL ,
  `ic` DOUBLE(5,4) NOT NULL ,
  `iavg` DOUBLE(5,4) NOT NULL ,
  `kw_a` DOUBLE(5,4) NOT NULL ,
  `kw_b` DOUBLE(5,4) NOT NULL ,
  `kw_c` DOUBLE(5,4) NOT NULL ,
  `kw_tot` DOUBLE(5,4) NOT NULL ,
  `kwh` DOUBLE(7,4) NOT NULL ,
  `freq` DOUBLE(5,4) NOT NULL ,
  `pf` DOUBLE(5,4) NOT NULL ,
  `breaker_name` VARCHAR(150) NOT NULL ,
  `ss_label` VARCHAR(150) NOT NULL ,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;