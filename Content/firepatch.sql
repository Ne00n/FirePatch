SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `Servers` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Token` varchar(50) NOT NULL,
  `Lastrun` int(11) NOT NULL DEFAULT '0',
  `Lastupdate` int(11) NOT NULL DEFAULT '0',
  `Update_Running` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `Servers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Token` (`Token`);


ALTER TABLE `Servers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
