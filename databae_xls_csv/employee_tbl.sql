CREATE DATABASE IF NOT EXISTS `otas` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

USE `otas`;


-- admin--

-- DROP TABLE IF EXISTS `admin`;
-- CREATE TABLE `otas`.`admin` (
--  `AdminId` varchar(50) NOT NULL,
--  `AdminName` varchar(70) NOT NULL,
--  `AdminEmailId` varchar(50) NOT NULL,
--  `EmployeeId` varchar(50) NOT NULL,
--  `Password` varchar(10) NOT NULL,
--  PRIMARY KEY (`AdminId`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT INTO `admin`(`AdminId`, `AdminName`,`AdminEmailId`,`Password`) VALUES ('admin','admin','admin@gmail.com','otas@123');

-- employee--
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `otas`.`employee` (
 `emplimage` text Not NULL,
 `Name` text NOT NULL,
 `EmailId` varchar(100) NOT NULL,
 `EmployeeId` varchar(50) NOT NULL,
 `Designation` text NOT NULL,
 `MobileNo` bigint(10) NOT NULL,
 `DateOfBirth` date NOT NULL,
 `Gender` text NOT NULL,
 `Password` varchar(100) NOT NULL,
 `token` text NOT NULL,
 PRIMARY KEY (`EmployeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `employee` (`Name`,`EmailId`, `EmployeeId`,`Designation`,`Gender`, `Password`) VALUES ('U. S. Gaikwad','ugaikwad@edcil.co.in', '1','Manager','Male', '$2y$10$Clr2UUV7QgchOW0y2AgFY.MSXlpCjtsIzLaBVJtpyxM.yW6KNsqGe');

-- roles--
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `otas`.`roles` (
 `EmployeeId` varchar(30) NOT NULL,
 `UserRole` varchar(30) NOT NULL,
 PRIMARY KEY (`EmployeeId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `roles` (`EmployeeId`, `UserRole`) VALUES ('1','Admin');

-- Department--
DROP TABLE IF EXISTS `department`;
CREATE TABLE `otas`.`department` (
 `DepartmentName` text NOT NULL,
 `DepartmentId` varchar(20) NOT NULL,
 `EmployeeId` varchar(20) NOT NULL,
 PRIMARY KEY (`EmployeeId`),
 UNIQUE KEY `DepartmentId` (`DepartmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `department` (`DepartmentName`,`DepartmentId`,`EmployeeId`) VALUES ('OTAS','OTAS00001','1');
