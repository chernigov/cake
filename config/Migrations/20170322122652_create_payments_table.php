<?php

use Phinx\Migration\AbstractMigration;

class CreatePaymentsTable extends AbstractMigration
{
    /**
     * Table name
     * @var string
     */
    protected $tableName = 'payments';

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table($this->tableName);
        $table->addColumn('amount', 'integer', [
            'comment' => 'Amount'
        ]);
        $table->addColumn('debt_id', 'integer', [
            'comment' => 'Foreign key'
        ])->addForeignKey('debt_id', 'debts', 'id');
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
}
