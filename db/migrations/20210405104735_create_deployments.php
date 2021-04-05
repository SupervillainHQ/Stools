<?php

use Phinx\Migration\AbstractMigration;

class CreateDeployments extends AbstractMigration{

    public function change(){
        if(!$this->hasTable('deployments')){
            $table = $this->table('deployments');

            $table->addColumn('siteId', 'integer', ['null' => false]);
            $table->addColumn('repositoryId', 'integer', ['null' => false]);
            $table->addColumn('commit', 'string', ['null' => false, 'limit' => 128]);
            $table->addColumn('createdAt', 'string', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'limit' => 24]);

            $table->addForeignKey('siteId', 'sites', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
            $table->addForeignKey('repositoryId', 'repositories', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);

            $table->create();
        }
    }
}
