-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema event_booking_system
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema event_booking_system
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `event_booking_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `event_booking_system` ;

-- -----------------------------------------------------
-- Table `event_booking_system`.`employees`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `event_booking_system`.`employees` (
  `employee_id` INT NOT NULL AUTO_INCREMENT,
  `employee_name` VARCHAR(255) NOT NULL,
  `employee_mail` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE INDEX `employee_mail` (`employee_mail` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `event_booking_system`.`events`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `event_booking_system`.`events` (
  `event_id` INT NOT NULL AUTO_INCREMENT,
  `event_name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE INDEX `event_name` (`event_name` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `event_booking_system`.`participation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `event_booking_system`.`participation` (
  `participation_id` INT NOT NULL,
  `employee_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `participation_fee` DECIMAL(10,2) NULL DEFAULT NULL,
  `event_date` DATETIME NOT NULL,
  `version` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`participation_id`),
  INDEX `employee_id` (`employee_id` ASC) VISIBLE,
  INDEX `event_id` (`event_id` ASC) VISIBLE,
  CONSTRAINT `participation_ibfk_1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `event_booking_system`.`employees` (`employee_id`),
  CONSTRAINT `participation_ibfk_2`
    FOREIGN KEY (`event_id`)
    REFERENCES `event_booking_system`.`events` (`event_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
