<?php

use yii\db\Migration;

class m161202_104309_refund extends Migration
{
    public function up()
    {
        $sql = <<<EOF

CREATE TABLE IF NOT EXISTS `alipay_refund` (
  `alipay_refund_id` INT NOT NULL AUTO_INCREMENT,
  `alipay_refund_refund_id` INT NOT NULL,
  `alipay_refund_alipay_id` INT NOT NULL,
  `alipay_refund_out_request_no` VARCHAR(64) NOT NULL,
  `alipay_refund_amount` DECIMAL(18,2) NOT NULL,
  `alipay_refund_sub_code` VARCHAR(64) NULL,
  `alipay_refund_pay_time` DATETIME NULL,
  `alipay_refund_send_back_fee` DECIMAL(18,2) NULL,
  `alipay_refund_response` TEXT NULL,
  PRIMARY KEY (`alipay_refund_id`),
  INDEX `fk_alipay_refund_alipay1_idx` (`alipay_refund_alipay_id` ASC),
  INDEX `fk_alipay_refund_refund1_idx` (`alipay_refund_refund_id` ASC),
  UNIQUE INDEX `alipay_refund_out_request_no_UNIQUE` (`alipay_refund_out_request_no` ASC),
  UNIQUE INDEX `alipay_refund_refund_id_UNIQUE` (`alipay_refund_refund_id` ASC),
  CONSTRAINT `fk_alipay_refund_alipay1`
    FOREIGN KEY (`alipay_refund_alipay_id`)
    REFERENCES `alipay` (`alipay_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alipay_refund_refund1`
    FOREIGN KEY (`alipay_refund_refund_id`)
    REFERENCES `refund` (`refund_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `wechat_refund` (
  `wechat_refund_id` INT NOT NULL AUTO_INCREMENT,
  `wechat_refund_refund_id` INT NOT NULL,
  `wechat_refund_wechat_id` INT NOT NULL,
  `wechat_refund_out_refund_no` VARCHAR(32) NOT NULL,
  `wechat_refund_refund_fee` INT NOT NULL,
  `wechat_refund_out_refund_id` VARCHAR(32) NULL,
  `wechat_refund_status` VARCHAR(16) NULL,
  `wechat_refund_response` TEXT NULL,
  PRIMARY KEY (`wechat_refund_id`),
  INDEX `fk_wechat_refund_refund1_idx` (`wechat_refund_refund_id` ASC),
  INDEX `fk_wechat_refund_wechat1_idx` (`wechat_refund_wechat_id` ASC),
  UNIQUE INDEX `refund_refund_id_UNIQUE` (`wechat_refund_refund_id` ASC),
  UNIQUE INDEX `wechat_refund_out_refund_no_UNIQUE` (`wechat_refund_out_refund_no` ASC),
  CONSTRAINT `fk_wechat_refund_refund1`
    FOREIGN KEY (`wechat_refund_refund_id`)
    REFERENCES `refund` (`refund_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_wechat_refund_wechat1`
    FOREIGN KEY (`wechat_refund_wechat_id`)
    REFERENCES `wechat` (`wechat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

EOF;

        $this->execute($sql);
    }

    public function down()
    {
        echo "m161202_104309_refund cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
