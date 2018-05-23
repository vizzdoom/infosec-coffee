CREATE DATABASE  IF NOT EXISTS `infosec_coffee` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `infosec_coffee`;
--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `code` varchar(12) NOT NULL,
  `value` int(11) DEFAULT NULL,
  `claimed` int(11) DEFAULT '0',
  PRIMARY KEY (`code`)
);

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` VALUES ('code1000',1000,0),('code10000',10000,0),('code1500',1500,0),('code2000',2000,0),('code2500',2500,0),('code3000',3000,0),('code3500',3500,0),('code4000',4000,0),('code4500',4500,0),('code5000',5000,0);
--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Dumping data for table `products`
--

INSERT INTO `products` VALUES (1,'Sweet Bread (1kg)',0,499),(2,'Whole Homemade Big Pie (250 dag)',0,749),(3,'Bread Pudding (1kg)',0,999),(4,'Arusha Coffee Beans (100 dag)',1,1499),(5,'Columbian Coffee Beans (100 dag)',1,1399),(6,'Java Coffee Beans (100 dag)',1,2099),(7,'Santos Coffee Beans (100dag)',1,1599),(8,'Uganda Coffee Beans (100 dag)',1,1199);

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `products_list` varchar(300) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`)
);

--
-- Dumping data for table `transactions`
--

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `wallet` int(11) DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES (1,'admin','65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5',10000,'2018-05-16 21:16:11');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`192.168.1.%`*/ /*!50003 TRIGGER `infosec_coffee`.`users_BEFORE_UPDATE` BEFORE UPDATE ON `users` FOR EACH ROW
BEGIN

SET NEW.lastupdate = sleep(0.1);
SET NEW.lastupdate = now();

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'infosec_coffee'
--

--
-- Dumping routines for database 'infosec_coffee'
--

-- Dump completed
