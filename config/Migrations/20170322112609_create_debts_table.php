<?php

use Phinx\Migration\AbstractMigration;

class CreateDebtsTable extends AbstractMigration
{
    /**
     * Table name
     * @var string
     */
    protected $tableName = 'debts';

    /**
     * Create Table with columns
     */
    public function up()
    {
        $table = $this->table($this->tableName);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'Full Name'
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => true,
            'comment' => 'Comment',
        ]);
        $table->addColumn('balance', 'decimal', [
            'default' => 0,
            'null' => false,
            'comment' => 'Balance',
        ]);
        $table->addColumn('interest', 'decimal', [
            'default' => 0,
            'null' => false,
            'comment' => 'Interest',
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
            'comment' => 'Created',
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
            'comment' => 'Modified',
        ]);
        $table->create();
    }

    /**
     * Drop current Table
     */
    public function down()
    {
        $table = $this->table($this->table);
        $table->drop();
    }
}
