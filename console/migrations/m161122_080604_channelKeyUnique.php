<?php

use yii\db\Migration;

class m161122_080604_channelKeyUnique extends Migration
{
    public function up()
    {
        $sql = <<<EOF

ALTER TABLE `channel` 
ADD UNIQUE INDEX `channel_key_UNIQUE` (`channel_key` ASC),
ADD UNIQUE INDEX `channel_name_UNIQUE` (`channel_name` ASC);

EOF;

        $this->execute($sql);
    }

    public function down()
    {
        echo "m161122_080604_channelKeyUnique cannot be reverted.\n";

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
