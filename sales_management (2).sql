-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`제조 공장`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`제조 공장` (
  `공장번호` INT NOT NULL AUTO_INCREMENT,   #공장번호 1씩 증가
  `공장주소` VARCHAR(45) NOT NULL,
  `공장 전화번호` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`공장번호`),
  UNIQUE INDEX `공장주소_UNIQUE` (`공장주소` ASC) VISIBLE,
  UNIQUE INDEX `공장 전화번호_UNIQUE` (`공장 전화번호` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`제품 정보`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`제품 정보` (
  `제품 이름` VARCHAR(20) NOT NULL,
  `사용 부위` VARCHAR(10) NOT NULL,
  `가격` INT NOT NULL,
  `성분` VARCHAR(40) NOT NULL,
  `생산공장번호` INT NOT NULL,
  PRIMARY KEY (`제품 이름`),
  INDEX `fk_제품 정보_제조 공장1_idx` (`생산공장번호` ASC) VISIBLE,
  CONSTRAINT CK_price CHECK (`가격`>=0 ),     #가격은 음수값이 안 되게 하고, 제약조건관리를 위한 이름은 CK_price로 설정함
  CONSTRAINT `fk_제품 정보_제조 공장1`
    FOREIGN KEY (`생산공장번호`)
    REFERENCES `mydb`.`제조 공장` (`공장번호`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`점장 정보`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`점장 정보` (
  `점장번호` INT NOT NULL AUTO_INCREMENT, #점장번호 자동으로 증가
  `이름` VARCHAR(10) NOT NULL,
  `전화번호` VARCHAR(14) NOT NULL,
  `이메일` VARCHAR(45) NOT NULL,
  `주소` VARCHAR(45) NOT NULL,
  `계좌번호` VARCHAR(20) NOT NULL,
  `사업자 번호` INT NOT NULL,
  `추천 점장번호` INT NOT NULL,
  `계약날짜` DATE NOT NULL CHECK (`계약날짜`>='1900-01-01'),
  `해지날짜` DATE NULL,
  PRIMARY KEY (`점장번호`),
  INDEX `fk_점장 정보_점장 정보1_idx` (`추천 점장번호` ASC) VISIBLE,
  UNIQUE INDEX `전화번호_UNIQUE` (`전화번호` ASC) VISIBLE,
  UNIQUE INDEX `이메일_UNIQUE` (`이메일` ASC) VISIBLE,
  UNIQUE INDEX `계좌번호_UNIQUE` (`계좌번호` ASC) VISIBLE,
  UNIQUE INDEX `사업자 번호_UNIQUE` (`사업자 번호` ASC) VISIBLE,
  CONSTRAINT `fk_점장 정보_점장 정보1`
    FOREIGN KEY (`추천 점장번호`)
    REFERENCES `mydb`.`점장 정보` (`점장번호`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`지점`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`지점` (
  `지점번호` INT NOT NULL AUTO_INCREMENT,
  `점장번호` INT NOT NULL,
  `지점이름` VARCHAR(10) NOT NULL,
  `지점주소` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`지점번호`),
  INDEX `fk_지점_점장 정보1_idx` (`점장번호` ASC) VISIBLE,
  UNIQUE INDEX `지점주소_UNIQUE` (`지점주소` ASC) VISIBLE,
  CONSTRAINT `fk_지점_점장 정보1`
    FOREIGN KEY (`점장번호`)
    REFERENCES `mydb`.`점장 정보` (`점장번호`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`직급`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`직급` (
  `직급` VARCHAR(10) NOT NULL,
  `승급기준` VARCHAR(45) NOT NULL,
  `보상지급` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`직급`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`판매원 정보`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`판매원 정보` (
  `ID` VARCHAR(45) NOT NULL,
  `PW` VARCHAR(45) NOT NULL,
  `이름` VARCHAR(10) NOT NULL,
  `직급` VARCHAR(10) NOT NULL,
  `전화번호` VARCHAR(11) NOT NULL,
  `이메일` VARCHAR(45) NOT NULL,
  `주소` VARCHAR(45) NOT NULL,
  `계좌번호` VARCHAR(20) NOT NULL,
  `점장번호` INT NOT NULL,
  `추천회원 ID` VARCHAR(45) NOT NULL,
  `가입일` DATE NOT NULL CHECK (`가입일`>='1900-01-01'),
  `해지일` DATE NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_판매원 정보_점장 정보1_idx` (`점장번호` ASC) VISIBLE,
  INDEX `fk_판매원 정보_직급1_idx` (`직급` ASC) VISIBLE,
  UNIQUE INDEX `전화번호_UNIQUE` (`전화번호` ASC) VISIBLE,
  INDEX `fk_판매원 정보_판매원 정보1_idx` (`추천회원 ID` ASC) VISIBLE,
  UNIQUE INDEX `이메일_UNIQUE` (`이메일` ASC) VISIBLE,
  UNIQUE INDEX `계좌번호_UNIQUE` (`계좌번호` ASC) VISIBLE,
  CONSTRAINT `fk_판매원 정보_점장 정보1`
    FOREIGN KEY (`점장번호`)
    REFERENCES `mydb`.`점장 정보` (`점장번호`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_판매원 정보_직급1`
    FOREIGN KEY (`직급`)
    REFERENCES `mydb`.`직급` (`직급`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_판매원 정보_판매원 정보1`
    FOREIGN KEY (`추천회원 ID`)
    REFERENCES `mydb`.`판매원 정보` (`ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`판매 정보`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`판매 정보` (
  `판매번호` INT NOT NULL AUTO_INCREMENT,
  `판매원ID` VARCHAR(20) NOT NULL,
  `판매일자` DATETIME NOT NULL,
  `구매방법` VARCHAR(45) NOT NULL,
  INDEX `fk_판매 정보_ID_idx` (`판매원ID` ASC) VISIBLE,
  PRIMARY KEY (`판매번호`),
  CONSTRAINT `fk_판매 정보_ID`
    FOREIGN KEY (`판매원ID`)
    REFERENCES `mydb`.`판매원 정보` (`ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`장바구니`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`장바구니` (
  `ID` VARCHAR(45) NOT NULL,
  `제품이름` VARCHAR(20) NOT NULL,
  `수량` INT NOT NULL CHECK (`수량`>0 AND `수량`<=50),
  PRIMARY KEY (`ID`, `제품이름`),
  INDEX `fk_장바구니_제품 정보1_idx` (`제품이름` ASC) VISIBLE,
  CONSTRAINT `fk_장바구니_판매원 정보1`
    FOREIGN KEY (`ID`)
    REFERENCES `mydb`.`판매원 정보` (`ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_장바구니_제품 정보1`
    FOREIGN KEY (`제품이름`)
    REFERENCES `mydb`.`제품 정보` (`제품 이름`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`물류창고`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`물류창고` (
  `창고번호` INT NOT NULL AUTO_INCREMENT, #창고번호 자동으로 1부터 증가
  `창고 주소` VARCHAR(45) NOT NULL,
  `창고 전화번호` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`창고번호`),
  UNIQUE INDEX `창고 주소_UNIQUE` (`창고 주소` ASC) VISIBLE,
  UNIQUE INDEX `창고 전화번호_UNIQUE` (`창고 전화번호` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`판매 제품 정보`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`판매 제품 정보` (
  `판매제품코드` VARCHAR(45) NOT NULL,
  `판매번호` INT NOT NULL AUTO_INCREMENT,
  `제품이름` VARCHAR(20) NOT NULL,
  `수량` INT NOT NULL CHECK (`수량`>0 AND `수량`<=50), # 수량 1~50으로 제한
  `창고번호` INT NOT NULL,
  PRIMARY KEY (`판매제품코드`),
  INDEX `fk_판매 제품 정보_판매 정보1_idx` (`판매번호` ASC) VISIBLE,
  INDEX `fk_판매 제품 정보_제품 정보1_idx` (`제품이름` ASC) VISIBLE,
  INDEX `fk_판매 제품 정보_물류창고1_idx` (`창고번호` ASC) VISIBLE,
  CONSTRAINT `fk_판매 제품 정보_판매 정보1`
    FOREIGN KEY (`판매번호`)
    REFERENCES `mydb`.`판매 정보` (`판매번호`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_판매 제품 정보_제품 정보1`
    FOREIGN KEY (`제품이름`)
    REFERENCES `mydb`.`제품 정보` (`제품 이름`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_판매 제품 정보_물류창고1`
    FOREIGN KEY (`창고번호`)
    REFERENCES `mydb`.`물류창고` (`창고번호`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`반품 정보`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`반품 정보` (
  `반품제품코드` VARCHAR(45) NOT NULL,
  `판매제품코드` VARCHAR(45) NOT NULL,
  `제품이름` VARCHAR(20) NOT NULL,
  `수량` INT NOT NULL CHECK (`수량`>0 AND `수량`<=50),
  `반품일자` DATETIME NOT NULL,
  PRIMARY KEY (`반품제품코드`),
  INDEX `fk_반품 정보_판매 제품 정보1_idx` (`판매제품코드` ASC) VISIBLE,
  INDEX `fk_반품 정보_제품 정보1_idx` (`제품이름` ASC) VISIBLE,
  CONSTRAINT `fk_반품 정보_판매 제품 정보1`
    FOREIGN KEY (`판매제품코드`)
    REFERENCES `mydb`.`판매 제품 정보` (`판매제품코드`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_반품 정보_제품 정보1`
    FOREIGN KEY (`제품이름`)
    REFERENCES `mydb`.`제품 정보` (`제품 이름`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `mydb`.`창고내 제품 목록`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`창고내 제품 목록` (
  `물류창고_창고번호` INT NOT NULL,
  `제품 정보_제품 이름` VARCHAR(20) NOT NULL,
  `수량` INT NOT NULL CHECK (`수량`>=0 AND `수량`<=50),
  INDEX `fk_제품 정보_has_물류창고_물류창고1_idx` (`물류창고_창고번호` ASC) VISIBLE,
  INDEX `fk_제품 정보_has_물류창고_제품 정보1_idx` (`제품 정보_제품 이름` ASC) VISIBLE,
  PRIMARY KEY (`물류창고_창고번호`, `제품 정보_제품 이름`),
  CONSTRAINT `fk_제품 정보_has_물류창고_제품 정보1`
    FOREIGN KEY (`제품 정보_제품 이름`)
    REFERENCES `mydb`.`제품 정보` (`제품 이름`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_제품 정보_has_물류창고_물류창고1`
    FOREIGN KEY (`물류창고_창고번호`)
    REFERENCES `mydb`.`물류창고` (`창고번호`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
