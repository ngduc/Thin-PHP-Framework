SET FOREIGN_KEY_CHECKS=0;

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
    `website` varchar(200) NULL, 
    `createTime` datetime NOT NULL,  
    PRIMARY KEY (`userId`)
) ENGINE=InnoDB  COLLATE=utf8_general_ci ;
CREATE UNIQUE INDEX `username` ON `user` (`username`);
CREATE UNIQUE INDEX `email` ON `user` (`email`);

DROP TABLE `post`;
CREATE TABLE `post` (
  `postId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `authorId` int(11) unsigned,
  `title` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `content` TEXT NULL,
  `allowComment` int(11) DEFAULT NULL,
  `updateTime` datetime DEFAULT NULL,
  `createTime` datetime NOT NULL,
  PRIMARY KEY (`postId`),
  KEY `authorId` (`authorId`),
  CONSTRAINT `fk_authorId_userId` FOREIGN KEY (`authorId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE `comment`;
CREATE TABLE `comment` (
  `commentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postId` int(11) unsigned NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` TEXT NULL,
  `authorName` varchar(50) DEFAULT NULL,
  `authorEmail` varchar(100) DEFAULT NULL,
  `authorURL` varchar(200) DEFAULT NULL,
  `authorIP` varchar(40) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `isApproved` int(11) DEFAULT NULL,
  `createTime` datetime NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `postId` (`postId`),
  CONSTRAINT `fk_postId_postId` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1;