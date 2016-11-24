<?php

use yii\db\Migration;

class m161124_092845_operationUnique extends Migration
{
    public function up()
    {
        $sql = <<<EOF

ALTER TABLE `charge` 
ADD UNIQUE INDEX `charge_operation_id_UNIQUE` (`charge_operation_id` ASC);

ALTER TABLE `withdraw` 
ADD UNIQUE INDEX `withdraw_operation_id_UNIQUE` (`withdraw_operation_id` ASC);

ALTER TABLE `transfer` 
ADD UNIQUE INDEX `transfer_operation_id_UNIQUE` (`transfer_operation_id` ASC);

ALTER TABLE `refund` 
ADD UNIQUE INDEX `refund_operation_id_UNIQUE` (`refund_operation_id` ASC);

EOF;

        $this->execute($sql);
    }

    public function down()
    {
        echo "m161124_092845_operationUnique cannot be reverted.\n";

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
