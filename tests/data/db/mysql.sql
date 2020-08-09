
DROP TABLE IF EXISTS `TestEntity`;
CREATE TABLE `TestEntity` (
  `userId` bigint(20) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(250) DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `intType` int(11) DEFAULT NULL,
  `floatType` double DEFAULT NULL,
  `doubleType` double DEFAULT NULL,
  `booleanType` tinyint(1) DEFAULT NULL,
  `extraProperty` text,
  `relativeExtendedId` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `TestRelativeEntity`;
CREATE TABLE `TestRelativeEntity` (
  `relativeId` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `relativeName` varchar(250) DEFAULT NULL,
  `extraProperty` text,
  PRIMARY KEY (`relativeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `TestRelativeExtendedEntity`;
CREATE TABLE `TestRelativeExtendedEntity` (
  `relativeExtendedId` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `extraProperty` text,
  PRIMARY KEY (`relativeExtendedId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
