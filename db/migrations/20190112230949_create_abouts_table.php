<?php


use Phinx\Migration\AbstractMigration;

class CreateAboutsTable extends AbstractMigration
{
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
			$table = $this->table('abouts');
			$table
				->addColumn('name', 'string', ['limit' => 80])
				->addColumn('degree', 'string', ['limit' => 100])
				->addColumn('birth', 'date')
				->addColumn('phone_ext', 'string', ['limit' => 2])
				->addColumn('phone_number', 'string', ['limit' => 12])
				->addColumn('email', 'string', ['limit' => 50])
				->addColumn('state', 'string', ['limit' => 30])
				->addColumn('city', 'string', ['limit' => 30])
				->addColumn('description', 'text', ['null' => true])
				->addColumn('github_link', 'string', ['limit' => 100, 'null' => true])
				->addColumn('twitter_link', 'string', ['limit' => 100, 'null' => true])
				->addColumn('linkedin_link', 'string', ['limit' => 100, 'null' => true])
				->addColumn('facebook_link', 'string', ['limit' => 100, 'null' => true])
				->addColumn('created_at', 'datetime')
				->addColumn('updated_at', 'datetime')
				->save();
    }
}
