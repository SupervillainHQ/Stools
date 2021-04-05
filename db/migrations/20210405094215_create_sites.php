<?php

use Phinx\Migration\AbstractMigration;

class CreateSites extends AbstractMigration{
    public function change(){
        if(!$this->hasTable('sites')){
            $table = $this->table('sites');

            $table->addColumn('domain', 'string', ['null' => false, 'limit' => 128]);
            $table->addColumn('installPath', 'string', ['null' => true, 'limit' => 256]);
            $table->addColumn('publicPath', 'string', ['null' => true, 'limit' => 256]);
            $table->addColumn('createdAt', 'string', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'limit' => 24]);
            $table->addColumn('modifiedAt', 'string', ['null' => true, 'limit' => 24]);

            $table->create();
        }
    }
}