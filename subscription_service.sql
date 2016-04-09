-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema subscription_service
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema subscription_service
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `subscription_service` DEFAULT CHARACTER SET latin1 ;
USE `subscription_service` ;

-- -----------------------------------------------------
-- Table `subscription_service`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `subscription_service`.`users` ;

CREATE TABLE IF NOT EXISTS `subscription_service`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `password` VARCHAR(40) NULL DEFAULT NULL,
  `name` VARCHAR(250) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `subscription_service`.`lists`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `subscription_service`.`lists` ;

CREATE TABLE IF NOT EXISTS `subscription_service`.`lists` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `users_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_lists_users_idx` (`users_id` ASC),
  CONSTRAINT `fk_lists_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `subscription_service`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `subscription_service`.`tasks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `subscription_service`.`tasks` ;

CREATE TABLE IF NOT EXISTS `subscription_service`.`tasks` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `order` INT(11) NULL DEFAULT NULL,
  `completed` TINYINT(1) NULL DEFAULT '0',
  `lists_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tasks_lists1_idx` (`lists_id` ASC),
  CONSTRAINT `fk_tasks_lists1`
    FOREIGN KEY (`lists_id`)
    REFERENCES `subscription_service`.`lists` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
