<?php

namespace Nishchay\Test\Data\DBManager;

use PHPUnit\Framework\TestCase;
use Nishchay\Data\DatabaseManager;
use Nishchay\Data\Query;
use Nishchay\Data\Meta\MetaTable;

/**
 * Description of MSSQLTest
 *
 * @author Bhavik Patel
 */
class PostgreSQLTest extends TestCase
{

    /**
     * Main table name
     * 
     * @var string
     */
    private static $mainTable = 'TestDBManagerMain';

    /**
     * Child table name to be used for foreign key.
     * 
     * @var string
     */
    private static $childTable = 'TestDBManagerChild';

    /**
     * Database connection name.
     * 
     * @var string
     */
    private static $connectionName = 'postgre';

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Returns instance of query.
     * 
     * @return Query
     */
    private static function getQuery()
    {
        return new Query(self::$connectionName);
    }

    /**
     * Returns instance of DatabaseManager.
     * 
     * @return DatabaseManager
     */
    private function getDBManager()
    {
        return new DatabaseManager(self::$connectionName);
    }

    /**
     * Returns instance of MetaTable.
     * 
     * @param type $table
     * @return MetaTable
     */
    private function getMetaTable($table)
    {
        return new MetaTable($table, self::$connectionName);
    }

    /**
     * Changes key to column name.
     * 
     * @param string $tableName
     * @return array
     */
    private function getColumns($tableName = null)
    {
        $table = $this->getMetaTable($tableName ? $tableName : self::$mainTable);
        $columns = $table->getColumns();
        foreach ($columns as $key => $row) {
            unset($columns[$key]);
            $columns[$row->name] = $row;
        }
        return $columns;
    }

    /**
     * Tests creation for table
     */
    public function testCreateTable()
    {
        $this->getDBManager()
                ->setTableName(self::$mainTable)
                ->setColumn('id', 'BIGINT', false)
                ->setColumn('cVChar', ['VARCHAR' => 200])
                ->setColumn('cDouble', 'NUMERIC')
                ->setColumn('cDoublePreceision', ['NUMERIC' => [10, 2]])
                ->setPrimaryKey('id')
                ->execute();

        $columns = $this->getColumns();

        # For id
        $this->assertTrue(isset($columns['id']));
        $this->assertEquals('bigint', $columns['id']->dataType);
        $this->assertEquals('NO', $columns['id']->nullable);
        $this->assertTrue($columns['id']->primaryKey);

        # For cVChar
        $this->assertTrue(isset($columns['cVChar']));
        $this->assertEquals('character varying', $columns['cVChar']->dataType);
        $this->assertEquals(200, $columns['cVChar']->maxLength);
        $this->assertEquals('YES', $columns['cVChar']->nullable);

        # For cDouble
        $this->assertTrue(isset($columns['cDouble']));
        $this->assertEquals('numeric', $columns['cDouble']->dataType);
        $this->assertEquals(null, $columns['cDouble']->maxLength);
        $this->assertEquals('YES', $columns['cDouble']->nullable);
        $this->assertEquals(0, $columns['cDouble']->scale);

        # For cDoublePreceision
        $this->assertTrue(isset($columns['cDoublePreceision']));
        $this->assertEquals('numeric', $columns['cDoublePreceision']->dataType);
        $this->assertEquals(null, $columns['cDoublePreceision']->maxLength);
        $this->assertEquals('YES', $columns['cDoublePreceision']->nullable);
        $this->assertEquals(2, $columns['cDoublePreceision']->scale);
    }

    /**
     * @depends testCreateTable
     */
    public function testAlterTable()
    {
        $this->getDBManager()
                ->setTableName(self::$mainTable)
                ->setColumn(['cVChar' => 'cVChar'], ['VARCHAR' => 100])
                ->setColumn(['cDouble' => 'cDoubleChanged'], 'NUMERIC')
                ->setColumn('cVCharNew', 'VARCHAR(250)', false)
                ->execute();

        $columns = $this->getColumns();

        # Just to ensure column not removed
        $this->assertTrue(isset($columns['cVChar']));

        # Column type not changed
        $this->assertEquals('character varying', $columns['cVChar']->dataType);

        # Max length should be changed
        $this->assertEquals(100, $columns['cVChar']->maxLength);

        # This should not exists
        $this->assertFalse(isset($columns['cDouble']));

        # Our new column shoule be in table
        $this->assertTrue(isset($columns['cDoubleChanged']));

        # Its column type should be same
        $this->assertEquals('numeric', $columns['cDoubleChanged']->dataType);

        # Scale should be same
        $this->assertEquals(null, $columns['cDoubleChanged']->scale);

        # New should exists
        $this->assertTrue(isset($columns['cVCharNew']));
        $this->assertEquals('character varying', $columns['cVCharNew']->dataType);
        $this->assertEquals(250, $columns['cVCharNew']->maxLength);
        $this->assertEquals('NO', $columns['cVCharNew']->nullable);
    }

    /**
     * Tests removal of column.
     * 
     * @depends testAlterTable
     */
    public function testRemoveColumn()
    {
        $this->getDBManager()
                ->setTableName(self::$mainTable)
                ->removeColumn('cDoubleChanged')
                ->execute();

        $columns = $this->getColumns();

        $this->assertFalse(isset($columns['cDoubleChanged']));
    }

    /**
     * Tests foreign key.
     * 
     * @depends testRemoveColumn
     */
    public function testForeignKeyWhileCreation()
    {
        $this->getDBManager()
                ->setTableName(self::$childTable)
                ->setColumn('id', 'BIGINT', false)
                ->setColumn('foreignKey', 'bigint', false)
                ->addForeignKey('foreignKey', ['table' => self::$mainTable, 'column' => 'id'])
                ->setPrimaryKey('id')
                ->execute();

        $table = $this->getMetaTable(self::$childTable);

        $foreignKey = current($table->getForeignKeys());

        $this->assertEquals('foreignKey', $foreignKey->columnName);
        $this->assertEquals(self::$mainTable, $foreignKey->targetTable);
        $this->assertEquals('id', $foreignKey->targetColumn);
    }

    /**
     * Tests removal of foreign key.
     * 
     * @depends testForeignKeyWhileCreation
     */
    public function testRemoveForeignKeyAlone()
    {
        $this->getDBManager()
                ->setTableName(self::$childTable)
                ->removeConstraint('foreignKey', 'FOREIGN')
                ->execute();

        $table = $this->getMetaTable(self::$childTable);

        $foreignKey = current($table->getForeignKeys());

        $this->assertFalse($foreignKey);
    }

    /**
     * Tests foreign key to be added along with change column.
     * 
     * @depends testRemoveForeignKeyAlone
     */
    public function testAddForeignKeyWithChangeColumn()
    {
        $this->getDBManager()
                ->setTableName(self::$childTable)
                ->setColumn(['foreignKey' => 'foreignKeyChanged'], 'bigint', false)
                ->addForeignKey('foreignKeyChanged', ['table' => self::$mainTable, 'column' => 'id'])
                ->execute();


        $table = $this->getMetaTable(self::$childTable);

        $foreignKey = current($table->getForeignKeys());

        $this->assertEquals('foreignKeyChanged', $foreignKey->columnName);
        $this->assertEquals(self::$mainTable, $foreignKey->targetTable);
        $this->assertEquals('id', $foreignKey->targetColumn);
    }

    /**
     * Tests foreign key to be removed along with adding new column.
     * 
     * @depends testAddForeignKeyWithChangeColumn
     */
    public function testRemoveForeignKeyWIthNewColumn()
    {

        $this->getDBManager()
                ->setTableName(self::$childTable)
                ->setColumn('newColumn', ['VARCHAR' => 150])
                ->removeConstraint('foreignKeyChanged', 'FOREIGN')
                ->execute();

        $table = $this->getMetaTable(self::$childTable);

        $foreignKey = current($table->getForeignKeys());

        $this->assertFalse($foreignKey);

        $columns = $this->getColumns(self::$childTable);

        $this->assertTrue(isset($columns['newColumn']));
        $this->assertEquals('character varying', $columns['newColumn']->dataType);
        $this->assertEquals(150, $columns['newColumn']->maxLength);
    }

    /**
     * Tests removal of primary key.
     * 
     * @depends testRemoveForeignKeyWIthNewColumn
     */
    public function testRemovePrimaryKey()
    {
        $this->getDBManager()
                ->setTableName(self::$childTable)
                ->removeConstraint('id', 'PRIMARY')
                ->execute();

        $columns = $this->getColumns(self::$childTable);

        $this->assertFalse($columns['id']->primaryKey);
    }

    /**
     * Tests adding new primary key.
     * 
     * @depends testRemovePrimaryKey
     */
    public function testAddPrimaryKey()
    {
        $this->getDBManager()
                ->setTableName(self::$childTable)
                ->setPrimaryKey('id')
                ->execute();

        $columns = $this->getColumns(self::$childTable);

        $this->assertTrue($columns['id']->primaryKey);
    }

    /**
     * Tests adding new index key to table.
     * 
     * @depends testAddPrimaryKey
     */
    public function testAddIndexKey()
    {
        $this->getDBManager()
                ->setTableName(self::$mainTable)
                ->addIndexKey('cVChar')
                ->execute();

        $table = $this->getMetaTable(self::$mainTable);
        $index = $table->getIndexes('cVChar');

        $this->assertTrue(isset($index->columnName));
        $this->assertEquals('cVChar', $index->columnName);
    }

    /**
     * Tests removal of index key.
     * 
     * @depends testAddIndexKey
     */
    public function testRemoveIndex()
    {
        $this->getDBManager()
                ->setTableName(self::$mainTable)
                ->removeConstraint('cVChar', 'INDEX')
                ->execute();

        $table = $this->getMetaTable(self::$mainTable);
        $index = $table->getIndexes('cVChar');

        $this->assertFalse($index);
    }

    /**
     * Removing all tests tables.
     */
    public static function tearDownAfterClass()
    {
        $query = self::getQuery();
        $query->execute('DROP TABLE IF EXISTS ' . $query->quote(self::$childTable));
        $query->execute('DROP TABLE IF EXISTS ' . $query->quote(self::$mainTable));
    }

}
