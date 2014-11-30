
tblAccess | CREATE TABLE `tblAccess` (
  `pmkUsername` varchar(50) NOT NULL,
  `fldDateIn` date NOT NULL,
  `fldTimeIn` time NOT NULL,
  `fldTimeOut` time DEFAULT NULL,
  `fldDateOut` date DEFAULT NULL,
  PRIMARY KEY (`pmkUsername`)
);

tblAdmin | CREATE TABLE `tblAdmin` (
  `pmkUsername` varchar(50) NOT NULL,
  `fldPassword` varchar(100) NOT NULL,
  PRIMARY KEY (`pmkUsername`)
);

tblFacialExpression | CREATE TABLE `tblFacialExpression` (
  `pmkType` varchar(12) NOT NULL,
  `fldImage` varchar(100) NOT NULL,
  `fldDescription` varchar(10000) NOT NULL,
  PRIMARY KEY (`pmkType`)
);

tblGameType | CREATE TABLE `tblGameType` (
  `pmkType` varchar(50) NOT NULL,
  `fldHeight` int(50) NOT NULL,
  `fldWidth` int(50) NOT NULL,
  PRIMARY KEY (`pmkType`)
);

tblImage | CREATE TABLE `tblImage` (
  `pmkImageId` varchar(12) NOT NULL,
  `fldName` varchar(100) NOT NULL,
  `fldImageFile` blob NOT NULL,
  `fldLevel` varchar(11) NOT NULL,
  `fldType` varchar(2) NOT NULL,
  PRIMARY KEY (`pmkImageId`)
);

tblSound | CREATE TABLE `tblSound` (
  `pmkSoundType` int(4) NOT NULL AUTO_INCREMENT,
  `fldSoundFile` blob NOT NULL,
  `fldLevel` int(1) NOT NULL,
  `fldType` varchar(2) NOT NULL,
  `fldName` varchar(20) NOT NULL,
  PRIMARY KEY (`pmkSoundType`)
);

tblUser | CREATE TABLE `tblUser` (
  `fldPassword` varchar(100) NOT NULL,
  `fldApproved` tinyint(4) NOT NULL DEFAULT '0',
  `fldConfirmed` tinyint(1) NOT NULL DEFAULT '0',
  `fldDateJoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pmkUsername` varchar(100) NOT NULL,
  `fldFName` varchar(20) NOT NULL,
  `fldLName` varchar(20) NOT NULL,
  `fldEmail` varchar(65) NOT NULL,
  `fldCrypt` varchar(100) NOT NULL,
  PRIMARY KEY (`pmkUsername`)
);


