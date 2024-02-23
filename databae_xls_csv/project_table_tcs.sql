CREATE DATABASE IF NOT EXISTS `otas` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

USE `otas`;

DROP TABLE IF EXISTS `tcsprojectdata`;
CREATE TABLE `otas`. `tcsprojectdata` (
 `projid` varchar(20) NOT NULL,
 `ClientId` varchar(10) NOT NULL,
 `NameOfProject` text NOT NULL,
 `Year` text NOT NULL,
 `WorkOrderDate` date NOT NULL,
 `Duration` int(5) NOT NULL,
 `SchedDateCompl` date NOT NULL,
 `PerCanRate` float NOT NULL,
 `ExpectedVal` double NOT NULL,
 `ActualVal` double NOT NULL,
 `Service` text NOT NULL,
 `tcsInvRaised` double NOT NULL,
 `TotPymntDone` double NOT NULL,
 `OutstndBal` double NOT NULL,
 `Status` text NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `tcscbtdata`;
CREATE TABLE `otas`.`tcscbtdata` (
 `projid` varchar(20) NOT NULL,
 `cbtPcnt` float NOT NULL,
 `cbtPymntAmt` double NOT NULL,
 `cbtInvNum` varchar(10) NOT NULL,
 `cbtInvAmt` double NOT NULL,
 `cbtInvDate` date NOT NULL,
 `cbtPDAmt1` double NOT NULL,
 `cbtPDDate1` date NOT NULL,
 `cbtPDAmt2` double NOT NULL,
 `cbtPDDate2` date NOT NULL,
 `cbtPDAmt3` double NOT NULL,
 `cbtPDDate3` date NOT NULL,
 `cbtPymntDone` double NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `tcsresultdata`;
CREATE TABLE `otas`.`tcsresultdata`(
 `projid` varchar(20) NOT NULL,
  `resPcnt` float NOT NULL,
 `resPymntAmt` double NOT NULL,
 `resInvNum` varchar(10) NOT NULL,
 `resInvAmt` double NOT NULL,
 `resInvDate` date NOT NULL,
 `resPDAmt1` double NOT NULL,
 `resPDDate1` date NOT NULL,
 `resPDAmt2` double NOT NULL,
 `resPDDate2` date NOT NULL,
 `resPDAmt3` double NOT NULL,
 `resPDDate3` date NOT NULL,
 `resPymntDone` double NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

