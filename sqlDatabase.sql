-- for mysql 
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE TABLE `Users` (
`UserId` INT  NOT NULL,
`Nickname` VARCHAR(20)  NOT NULL,
`Age` INT  NOT NULL,
`Email` VARCHAR(20)  NOT NULL,
`Uid` VARCHAR(20)  NOT NULL,
`CreationTime` DATETIME  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Users` ADD PRIMARY KEY(`UserId`); 
ALTER TABLE `Users`  MODIFY `UserId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1; 

CREATE TABLE `Sessions` (
`SessionId` INT  NOT NULL,
`UserId` INT  NOT NULL,
`CreationTime` DATETIME  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Sessions` ADD PRIMARY KEY(`SessionId`); 
ALTER TABLE `Sessions`  MODIFY `SessionId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1; 

CREATE TABLE `Messages` (
`MessageId` INT  NOT NULL,
`UserId` INT  NOT NULL,
`SessionId` INT  NOT NULL,
`Value` VARCHAR(20)  NOT NULL,
`CreationTime` DATETIME  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Messages` ADD PRIMARY KEY(`MessageId`); 
ALTER TABLE `Messages`  MODIFY `MessageId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1; 

CREATE TABLE `Moderaters` (
`ModeraterId` INT  NOT NULL,
`UserId` INT  NOT NULL,
`Role` INT  NOT NULL,
`CreationTime` DATETIME  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Moderaters` ADD PRIMARY KEY(`ModeraterId`); 
ALTER TABLE `Moderaters`  MODIFY `ModeraterId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1; 

CREATE TABLE `Feedback` (
`FeedbackId` INT  NOT NULL,
`SessionId` INT  NOT NULL,
`Value` VARCHAR(20)  NOT NULL,
`Description` TEXT  NOT NULL,
`CreationTime` DATETIME  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Feedback` ADD PRIMARY KEY(`FeedbackId`); 
ALTER TABLE `Feedback`  MODIFY `FeedbackId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1; 

CREATE TABLE `Notifications` (
`NotificationId` INT  NOT NULL,
`Title` VARCHAR(15)  NOT NULL,
`CreationTime` DATETIME  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Notifications` ADD PRIMARY KEY(`NotificationId`); 
ALTER TABLE `Notifications`  MODIFY `NotificationId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 1; 

