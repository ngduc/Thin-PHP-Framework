DROP TABLE `user`;

CREATE TABLE `user` ( 
    `userId` int UNSIGNED AUTO_INCREMENT NOT NULL, 
    `email` varchar(100) NULL, 
    `username` varchar(50) NULL,    
    `password` varchar(32) NULL, 
    `oauth_provider` varchar(50) NULL,
    `oauth_uid` varchar(50) NULL,
    `oauth_username` varchar(50) NULL,
    `firstName` varchar(30) NULL, 
    `lastName` varchar(30) NULL, 
    `website` varchar(100) NULL, 
    `createdTime` datetime NOT NULL,  
    PRIMARY KEY (`userId`)
) ENGINE=InnoDB  AUTO_INCREMENT=1  COLLATE=utf8_general_ci ;
CREATE UNIQUE INDEX `username` ON `user` (`username`);
CREATE UNIQUE INDEX `email` ON `user` (`email`);
