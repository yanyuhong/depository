<?php

use yii\db\Migration;

class m161207_092534_card extends Migration
{
    public function up()
    {
        $sql = <<<EOF

ALTER TABLE `card` 
CHANGE COLUMN `card_id_num` `card_id_num` VARCHAR(32) NULL ,
CHANGE COLUMN `card_mobile` `card_mobile` VARCHAR(16) NULL ;

INSERT INTO `bank` (`bank_id`, `bank_num`, `bank_name`)
VALUES
	(1,'CCB','中国建设银行'),
	(2,'ABC','中国农业银行'),
	(3,'ICBC','中国工商银行'),
	(4,'BC','中国银行'),
	(5,'CMBC','中国民生银行'),
	(6,'CMB','招商银行'),
	(7,'CIB','兴业银行'),
	(8,'BCM','交通银行'),
	(9,'CEB','中国光大银行'),
	(10,'PSBC','中国邮政储蓄银行');

EOF;

        $this->execute($sql);

    }

    public function down()
    {
        echo "m161207_092534_card cannot be reverted.\n";

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
