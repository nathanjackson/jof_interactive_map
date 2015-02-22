CREATE TABLE IF NOT EXISTS `MapDb`.`JofMembers` (
    `MemberId` int(11) NOT NULL AUTO_INCREMENT,
    `LastName` varchar(1024) NOT NULL,
    `FirstName` varchar(1024) NOT NULL,
    `Title` varchar(1024) NOT NULL,
    `Address` varchar(1024) NOT NULL,
    `Email` varchar(1024) NOT NULL,
    `Skills` text NOT NULL,
    PRIMARY KEY (`MemberId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `MapDb`.`JofRegions` (
    `RegionId` int(11) NOT NULL AUTO_INCREMENT,
    `Name` varchar(1024) NOT NULL,
    `GeoGsonStr` text,
    PRIMARY KEY (`RegionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
