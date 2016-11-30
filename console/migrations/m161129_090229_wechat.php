<?php

use yii\db\Migration;

class m161129_090229_wechat extends Migration
{
    public function up()
    {
        $sql = <<<EOF

ALTER TABLE `channel` 
ADD COLUMN `channel_wechat_appid` VARCHAR(255) NULL AFTER `channel_alipay_rsaPublicKey`,
ADD COLUMN `channel_wechat_mchid` VARCHAR(255) NULL AFTER `channel_wechat_appid`,
ADD COLUMN `channel_wechat_key` VARCHAR(255) NULL AFTER `channel_wechat_mchid`,
ADD COLUMN `channel_wechat_sslcert` TEXT NULL AFTER `channel_wechat_key`,
ADD COLUMN `channel_wechat_sslkey` TEXT NULL AFTER `channel_wechat_sslcert`;

ALTER TABLE `charge` 
ADD COLUMN `charge_spbill_ip` VARCHAR(16) NOT NULL DEFAULT '0.0.0.0' AFTER `charge_express_time`;

-- -----------------------------------------------------
-- Table `wechat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wechat` (
  `wechat_id` INT NOT NULL AUTO_INCREMENT,
  `wechat_charge_id` INT NOT NULL,
  `wechat_out_trade_no` VARCHAR(32) NOT NULL,
  `wechat_body` VARCHAR(128) NOT NULL,
  `wechat_detail` TEXT NULL,
  `wechat_total_fee` INT NOT NULL,
  `wechat_spbill_create_ip` VARCHAR(16) NOT NULL,
  `wechat_time_start` VARCHAR(16) NULL,
  `wechat_time_expire` VARCHAR(16) NULL,
  `wechat_trade_type` VARCHAR(16) NOT NULL,
  `wechat_transaction_id` VARCHAR(64) NULL,
  `wechat_trade_state` VARCHAR(32) NULL,
  `wechat_openid` VARCHAR(128) NULL,
  `wechat_bank_type` VARCHAR(16) NULL,
  `wechat_cash_fee` INT NULL,
  `wechat_time_end` VARCHAR(16) NULL,
  `wechat_response` TEXT NULL,
  `wechat_updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wechat_id`),
  INDEX `fk_wechat_charge1_idx` (`wechat_charge_id` ASC),
  UNIQUE INDEX `wechat_charge_id_UNIQUE` (`wechat_charge_id` ASC),
  UNIQUE INDEX `wechat_out_trade_no_UNIQUE` (`wechat_out_trade_no` ASC),
  CONSTRAINT `fk_wechat_charge1`
    FOREIGN KEY (`wechat_charge_id`)
    REFERENCES `charge` (`charge_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

EOF;

        $this->execute($sql);

    }

    public function down()
    {
        echo "m161129_090229_wechat cannot be reverted.\n";

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
