DELETE FROM `coupons`;
INSERT INTO `coupons` VALUES ('code1000',1000,0),('code10000',10000,0),('code1500',1500,0),('code2000',2000,0),('code2500',2500,0),('code3000',3000,0),('code3500',3500,0),('code4000',4000,0),('code4500',4500,0),('code5000',5000,0);

DELETE FROM `products`;
INSERT INTO `products` VALUES (1,'Sweet Bread (1kg)',0,499),(2,'Whole Homemade Big Pie (250 dag)',0,749),(3,'Bread Pudding (1kg)',0,999),(4,'Arusha Coffee Beans (100 dag)',1,1499),(5,'Columbian Coffee Beans (100 dag)',1,1399),(6,'Java Coffee Beans (100 dag)',1,2099),(7,'Santos Coffee Beans (100dag)',1,1599),(8,'Uganda Coffee Beans (100 dag)',1,1199);

DELETE FROM `users`;
INSERT INTO `users` VALUES (1,'admin','65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5',10000,'2018-05-16 21:16:11');


DELETE FROM `transactions`;