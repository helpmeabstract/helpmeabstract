<?php

use Phinx\Migration\AbstractMigration;

class CreateAbstractTable extends AbstractMigration
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
        $table = $this->table('abstracts');
        $table->addColumn('email', 'string', array('limit' => 100))
            ->addColumn('fullname', 'string', array('limit' => 100))
            ->addColumn('link', 'string', array('limit' => 100))
            ->addColumn('is_responded_to', 'integer')
            ->addColumn('max_chars', 'integer')
            ->create();
    }

    /**
     * Migrate Up.
     */
    public function up()
    {

    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
