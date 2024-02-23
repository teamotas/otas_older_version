CREATE DATABASE IF NOT EXISTS `otas` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

USE `otas`;


DROP TABLE IF EXISTS `otasprojectdata`;
CREATE TABLE `otas`.`otasprojectdata` (
 `ClientId` varchar(20) NOT NULL,
 `projid` varchar(15) NOT NULL,
 `NameOfProject` text NOT NULL,
 `Year` year(4) NOT NULL,
 `WorkOrderDate` date NOT NULL,
 `Service` text NOT NULL,
 `Duration` text NOT NULL,
 `SchedDateCompl` date NOT NULL,
 `PerCandRate` float NOT NULL,
 `DelayReason` text NOT NULL,
 `InvAmtRaised` double NOT NULL,
 `AmntRcvdByClient` bigint(20) NOT NULL,
 `TotOutstndBal` double NOT NULL,
 `Status` text NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `otasprcandcount`;
CREATE TABLE `otas`.`otasprcandcount`  (
 `projid` varchar(15) NOT NULL,
 `ExpectCandCount` bigint(20) NOT NULL,
 `ActualCandCount` bigint(20) NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `otasprojval`;
CREATE TABLE `otas`.`otasprojval`  (
 `projid` varchar(15) NOT NULL,
 `ExpectProjVal` double NOT NULL,
 `ActualProjVal` double NOT NULL,
 `QPCost` int(10) NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `otasprojdates`;
CREATE TABLE `otas`.`otasprojdates` (
 `projid` varchar(15) NOT NULL,
 `AplicLivDate` date NOT NULL,
 `AplicLiveEndDate` date NOT NULL,
 `AdmitLivDate` text NOT NULL,
 `ObjMngLiveDate` date NOT NULL,
 `ObjMngEndDate` date NOT NULL,
 `CBTDate` text NOT NULL,
 `NoOfCBTShifts` int(11) NOT NULL,
 `ResultSubmitDate` date NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `otasservicesprice`;
CREATE TABLE `otas`.`otasservicesprice` (
 `projid` varchar(20) NOT NULL,
  `jammerVendorName` text NOT NULL,
 `otherServiceVendor` text NOT NULL,
 `JammerPrice` float NOT NULL,
 `cctvRecordPrice` float NOT NULL,
 `cctvStreamPrice` float NOT NULL,
 `irisScanPrice` float NOT NULL,
 `biometricPrice` float NOT NULL,
 `hhmdPrice` float NOT NULL,
 `gateScorePrice` float NOT NULL,
 `skillTestPrice` float NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


DROP TABLE IF EXISTS `stg1pymntdetail`;
CREATE TABLE `otas`.`stg1pymntdetail` (
 `projid` varchar(20) NOT NULL,
 `stg1name` text NOT NULL,
 `stg1pcnt` float NOT NULL,
 `stg1amt` double NOT NULL,
 `stg1InvNum` int(5) NOT NULL,
 `stg1InvDate` date NOT NULL,
 `stg1InvAmt` double NOT NULL,
 `stg1pymntRcvd` double NOT NULL,
 `stg1NetPymnt` double NOT NULL,
 `stg1TDS` double NOT NULL,
 `stg1GstTDS` double NOT NULL,
 `stg1GrossPymnt` double NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `stg2pymntdetail`;
CREATE TABLE `otas`.`stg2pymntdetail` (
 `projid` varchar(20) NOT NULL,
 `stg2name` text NOT NULL,
 `stg2pcnt` float NOT NULL,
 `stg2amt` double NOT NULL,
 `stg2InvNum` int(5) NOT NULL,
 `stg2InvDate` date NOT NULL,
 `stg2InvAmt` double NOT NULL,
 `stg2pymntRcvd` double NOT NULL,
 `stg2NetPymnt` double NOT NULL,
 `stg2TDS` double NOT NULL,
 `stg2GstTDS` double NOT NULL,
 `stg2GrossPymnt` double NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `stg3pymntdetail`;
CREATE TABLE `otas`.`stg3pymntdetail` (
 `projid` varchar(20) NOT NULL,
 `stg3name` text NOT NULL,
 `stg3pcnt` float NOT NULL,
 `stg3amt` double NOT NULL,
 `stg3InvNum` int(5) NOT NULL,
 `stg3InvDate` date NOT NULL,
 `stg3InvAmt` double NOT NULL,
 `stg3pymntRcvd` double NOT NULL,
 `stg3NetPymnt` double NOT NULL,
 `stg3TDS` double NOT NULL,
 `stg3GstTDS` double NOT NULL,
 `stg3GrossPymnt` double NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `stg4pymntdetail`;
CREATE TABLE `otas`.`stg4pymntdetail` (
 `projid` varchar(20) NOT NULL,
 `stg4name` text NOT NULL,
 `stg4pcnt` float NOT NULL,
 `stg4amt` double NOT NULL,
 `stg4InvNum` int(5) NOT NULL,
 `stg4InvDate` date NOT NULL,
 `stg4InvAmt` double NOT NULL,
 `stg4pymntRcvd` double NOT NULL,
 `stg4NetPymnt` double NOT NULL,
 `stg4TDS` double NOT NULL,
 `stg4GstTDS` double NOT NULL,
 `stg4GrossPymnt` double NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `stg5pymntdetail`;
CREATE TABLE `otas`.`stg5pymntdetail` (
 `projid` varchar(20) NOT NULL,
 `stg5name` text NOT NULL,
 `stg5pcnt` float NOT NULL,
 `stg5amt` double NOT NULL,
 `stg5InvNum` int(5) NOT NULL,
 `stg5InvDate` date NOT NULL,
 `stg5InvAmt` double NOT NULL,
 `stg5pymntRcvd` double NOT NULL,
 `stg5NetPymnt` double NOT NULL,
 `stg5TDS` double NOT NULL,
 `stg5GstTDS` double NOT NULL,
 `stg5GrossPymnt` double NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `userotasproject`;
CREATE TABLE `otas`.`userotasproject` (
 `EmployeeId` varchar(20) NOT NULL,
 `projid` varchar(20) NOT NULL,
 PRIMARY KEY (`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;