<?php

use Phinx\Migration\AbstractMigration;

class CreateVolunteerTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
     */
    public function change()
    {

        // create the table
        $table = $this->table('volunteers');
        $table->addColumn('email', 'string', array('limit' => 100))
            ->addColumn('fullname', 'string', array('limit' => 100))
            ->addColumn('github_id', 'string', array('limit' => 100))
            ->addColumn('github_username', 'string', array('limit' => 100))
            ->addColumn('profile_image', 'string', array('limit' => 100))
            ->addColumn('profile_url', 'string', array('limit' => 100))
            ->create();
    }
}