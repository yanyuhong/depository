<?php

use yii\db\Migration;

class m170110_092511_transferOutNull extends Migration
{
    public function up()
    {

        $sql = <<<EOF

ALTER TABLE `transfer` 
DROP FOREIGN KEY `fk_transfer_account1`;
ALTER TABLE `transfer` 
CHANGE COLUMN `transfer_out_account_id` `transfer_out_account_id` INT(11) NULL ;
ALTER TABLE `transfer` 
ADD CONSTRAINT `fk_transfer_account1`
  FOREIGN KEY (`transfer_out_account_id`)
  REFERENCES `account` (`account_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
EOF;

        $this->execute($sql);
    }

    public function down()
    {
        echo "m170110_092511_transferOutNull cannot be reverted.\n";

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
