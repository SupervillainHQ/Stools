<?php

use Phinx\Migration\AbstractMigration;

class CreateRepositories extends AbstractMigration{
    public function change(){
        if(!$this->hasTable('repositories')){
            $table = $this->table('repositories');

            $table->addColumn('url', 'string', ['null' => false, 'limit' => 256]);
            $table->addColumn('type', 'string', ['null' => false, 'limit' => 64]);

            $table->create();
        }
    }
}
