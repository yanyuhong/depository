<?php

use yii\db\Migration;

class m161123_113830_alipay extends Migration
{
    public function up()
    {
        $sql = <<<EOF

ALTER TABLE `channel` 
ADD COLUMN `channel_alipay_appId` VARCHAR(255) NULL AFTER `channel_name`,
ADD COLUMN `channel_alipay_rsaPrivateKey` TEXT NULL AFTER `channel_alipay_appId`,
ADD COLUMN `channel_alipay_rsaPublicKey` TEXT NULL AFTER `channel_alipay_rsaPrivateKey`;

ALTER TABLE `charge` 
ADD COLUMN `charge_title` VARCHAR(255) NOT NULL AFTER `charge_amount`,
ADD COLUMN `charge_detail` VARCHAR(255) NOT NULL AFTER `charge_title`,
ADD COLUMN `charge_goods_type` TINYINT NOT NULL AFTER `charge_detail`,
ADD COLUMN `charge_express` INT NOT NULL AFTER `charge_goods_type`,
ADD COLUMN `charge_express_time` DATETIME NOT NULL AFTER `charge_express`;


-- -----------------------------------------------------
-- Table `alipay`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `alipay` (
  `alipay_id` INT NOT NULL AUTO_INCREMENT,
  `alipay_charge_id` INT NOT NULL,
  `alipay_out_trade_no` VARCHAR(64) NOT NULL,
  `alipay_body` VARCHAR(128) NULL,
  `alipay_subject` VARCHAR(255) NOT NULL,
  `alipay_timeout_express` VARCHAR(8) NULL,
  `alipay_total_amount` DECIMAL(9,2) NOT NULL,
  `alipay_goods_type` VARCHAR(2) NULL,
  `alipay_trade_no` VARCHAR(64) NULL,
  `alipay_buyer_logon_id` VARCHAR(128) NULL,
  `alipay_trade_status` VARCHAR(32) NULL,
  `alipay_receipt_amount` DECIMAL(9,2) NULL,
  `alipay_buyer_pay_amount` DECIMAL(9,2) NULL,
  `alipay_point_amount` DECIMAL(9,2) NULL,
  `alipay_invoice_amount` DECIMAL(9,2) NULL,
  `alipay_send_pay_date` DATETIME NULL,
  `alipay_response` TEXT NULL,
  `alipay_updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`alipay_id`),
  INDEX `fk_alipay_charge1_idx` (`alipay_charge_id` ASC),
  UNIQUE INDEX `alipay_charge_id_UNIQUE` (`alipay_charge_id` ASC),
  UNIQUE INDEX `alipay_out_trade_no_UNIQUE` (`alipay_out_trade_no` ASC),
  CONSTRAINT `fk_alipay_charge1`
    FOREIGN KEY (`alipay_charge_id`)
    REFERENCES `charge` (`charge_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

EOF;

        $this->execute($sql);

    }

    public function down()
    {
        echo "m161123_113830_alipay cannot be reverted.\n";

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
