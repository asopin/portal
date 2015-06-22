<?php

class m150621_094237_create_company_tables extends CDbMigration
{
    public function up()
    {
        $this->createTable('companies', [
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
            'category_id' => 'int(11) NOT NULL DEFAULT 0',
            'site_url' => 'varchar(255) DEFAULT NULL',
            'phone' => 'varchar(255) NOT NULL',
            'email' => 'varchar(255) NOT NULL',
            'status' => 'int(11) NOT NULL DEFAULT 0',
            'priority' => 'int(11) NOT NULL DEFAULT 0',
            'created_at' => 'datetime NOT NULL',
            'updated_at' => 'datetime NOT NULL'

        ], 'Engine=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        $this->dropTable('companies');
    }

}