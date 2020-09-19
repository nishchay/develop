<?php

namespace Nishchay\Test;

use DateTime;
use Application\Entities\TestEntity;
use Application\Entities\TestRelativeEntity;
use Application\Entities\TestRelativeExtendedEntity;
use Application\Entities\TestRelativeEntityCustomJoin;
use Application\Entities\TestEntityStaticProperty;
use PHPUnit\Framework\TestCase;
use Nishchay\Data\EntityManager;
use Nishchay\Data\Query;
use Nishchay\Utility\DateUtility;
use Nishchay\Data\Reflection\ExtraProperty;
use Nishchay\Data\Reflection\DataClass;
use Nishchay\Data\Annotation\Entity;

/**
 * Description of EntityTest
 *
 * @author Bhavik Patel
 */
class EntityTest extends TestCase
{

    /**
     *
     * @var \Nishchay\Data\EntityManager
     */
    private $entityManager;

    /**
     * Test data.
     * 
     * @var array
     */
    private static $data = [
        'userId' => null,
        'firstName' => 'First Name',
        'birthDate' => null,
        'createdAt' => null,
        'intType' => 123,
        'floatType' => 123.22,
        'doubleType' => 123.22,
        'booleanType' => true
    ];

    /**
     *
     * @var int 
     */
    private static $relativeId;

    /**
     *
     * @var array
     */
    private static $relativeExtendedIds = [];

    /**
     * 
     * @param string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        self::$data['birthDate'] = self::$data['createdAt'] = new DateTime();
        $this->entityManager = new EntityManager(TestEntity::class);
    }

    /**
     * 
     * @return EntityManager
     */
    public function getRelativeEntityManager()
    {
        return new EntityManager(TestRelativeEntity::class);
    }

    /**
     * Testing saving new.
     * This will insert record into table and it also tests all data type for
     * insert.
     */
    public static function setUpBeforeClass(): void
    {

        for ($i = 1; $i <= 5; $i++) {
            $entity = new EntityManager(TestRelativeExtendedEntity::class);
            $entity->name = 'Extended Name ' . $i;
            self::$relativeExtendedIds[] = $entity->save();
        }

        $entityManager = new EntityManager(TestEntity::class);
        $entityManager->firstName = self::$data['firstName'];
        $entityManager->birthDate = self::$data['birthDate'];
        $entityManager->createdAt = self::$data['createdAt'];
        $entityManager->intType = self::$data['intType'];
        $entityManager->floatType = self::$data['floatType'];
        $entityManager->doubleType = self::$data['doubleType'];
        $entityManager->booleanType = self::$data['booleanType'];
        $entityManager->relativeExtendedId = current(self::$relativeExtendedIds);

        $userId = $entityManager->save();

        self::$data['userId'] = $userId;

        for ($i = 1; $i <= 10; $i++) {
            $entity = new EntityManager(TestRelativeEntity::class);
            $entity->userId = $userId;
            $entity->relativeName = 'Relative Name ' . $i;
            $relativeId = $entity->save();
            if (self::$relativeId === null) {
                self::$relativeId = $relativeId;
            }
        }
    }

    /**
     * Tests get method of EntityManager.
     * Checking already insert record with their data type and value are
     * returning correctly.
     * 
     */
    public function testGetMethod()
    {
        $record = $this->entityManager->get(self::$data['userId']);

        $this->assertIsInt($record->userId);
        $this->assertEquals(self::$data['userId'], $record->userId);

        $this->assertIsString($record->firstName);
        $this->assertEquals(self::$data['firstName'], $record->firstName);

        $this->assertTrue($record->birthDate instanceof DateTime);
        $this->assertEquals(self::$data['birthDate']->format(DateUtility::MYSQL_DATE_FORMAT), $record->birthDate->format(DateUtility::MYSQL_DATE_FORMAT));

        $this->assertTrue($record->createdAt instanceof DateTime);
        $this->assertEquals(self::$data['createdAt']->format(DateUtility::MYSQL_DATETIME_FORMAT), $record->createdAt->format(DateUtility::MYSQL_DATETIME_FORMAT));

        $this->assertIsInt($record->intType);
        $this->assertEquals(self::$data['intType'], $record->intType);

        $this->assertIsFloat($record->floatType);
        $this->assertEquals(self::$data['floatType'], $record->floatType);

        $this->assertIsFloat($record->floatType);
        $this->assertEquals(self::$data['doubleType'], $record->doubleType);

        $this->assertIsBool($record->booleanType);
        $this->assertEquals(self::$data['booleanType'], $record->booleanType);

        return $record;
    }

    /**
     * Test get method for no record found.
     */
    public function testGetMethodNoRecord()
    {
        $record = $this->entityManager->get(0);
        $this->assertFalse($record);
    }

    /**
     * Checking string data type updating properly.
     * 
     * @depends testGetMethod
     */
    public function testUpdateStringType($record)
    {
        self::$data['firstName'] = $record->firstName = 'New name';
        $success = $record->save();

        $this->assertIsInt($success);
        $this->assertEquals(1, $success);

        $afterUpdate = $this->entityManager->get(self::$data['userId']);

        $this->assertEquals($record->firstName, $afterUpdate->firstName);

        return $record;
    }

    /**
     * Checking Date data type updating properly.
     * 
     * @depends testGetMethod
     */
    public function testUpdateDateType($record)
    {
        self::$data['birthDate'] = $record->birthDate->modify('+1 day');
        $success = $record->save();

        $this->assertIsInt($success);
        $this->assertEquals(1, $success);

        $afterUpdate = $this->entityManager->get(self::$data['userId']);

        $this->assertEquals($record->birthDate->format(DateUtility::MYSQL_DATE_FORMAT), $afterUpdate->birthDate->format(DateUtility::MYSQL_DATE_FORMAT));

        return $record;
    }

    /**
     * Checking datetime data type saving properly.
     * 
     * @depends testGetMethod
     */
    public function testUpdateDatetimeType($record)
    {
        self::$data['createdAt'] = $record->createdAt->modify('+1 day');
        $success = $record->save();

        $this->assertIsInt($success);
        $this->assertEquals(1, $success);

        $afterUpdate = $this->entityManager->get(self::$data['userId']);

        $this->assertEquals($record->createdAt->format(DateUtility::MYSQL_DATETIME_FORMAT), $afterUpdate->createdAt->format(DateUtility::MYSQL_DATETIME_FORMAT));

        return $record;
    }

    /**
     * Testing readonly property.
     * 
     * @depends testGetMethod
     */
    public function testReadonly($record)
    {
        $this->expectExceptionCode(911006);
        $record->userId = 1;
    }

    /**
     * Testing required property
     * 
     * @depends testGetMethod
     */
    public function testRequired($record)
    {
        $this->expectExceptionCode(911005);
        $record->firstName = null;
    }

    /**
     * Testing string data type.
     * 
     * @depends testGetMethod
     */
    public function testStringDataType($record)
    {
        $this->expectExceptionCode(911008);
        $record->firstName = [null];
    }

    /**
     * Testing value length.
     * 
     * @depends testGetMethod
     */
    public function testValueLength($record)
    {
        $this->expectExceptionCode(911010);
        $record->firstName = str_pad('A', 251, 'A');
    }

    /**
     * Testing integer data type.
     * 
     * @depends testGetMethod
     */
    public function testDateDataType($record)
    {
        $this->expectExceptionCode(911008);
        $record->birthDate = '1';
    }

    /**
     * Testing integer data type.
     * 
     * @depends testGetMethod
     */
    public function testDatetimeDataType($record)
    {
        $this->expectExceptionCode(911008);
        $record->createdAt = '1';
    }

    /**
     * Testing integer data type.
     * 
     * @depends testGetMethod
     */
    public function testIntegerDataType($record)
    {
        $this->expectExceptionCode(911008);
        $record->intType = '1';
    }

    /**
     * Testing integer data type.
     * 
     * @depends testGetMethod
     */
    public function testFloatDataType($record)
    {
        $this->expectExceptionCode(911008);
        $record->floatType = '1';
    }

    /**
     * Testing integer data type.
     * 
     * @depends testGetMethod
     */
    public function testDoubleDataType($record)
    {
        $this->expectExceptionCode(911008);
        $record->doubleType = '1';
    }

    /**
     * Tests relative property.
     * 
     */
    public function testRelativeProperty()
    {
        $this->expectExceptionCode(911043);
        $record = $this->getRelativeEntityManager()
                ->get(self::$relativeId);

        $record->userId = 123;
        $record->save();
    }

    /**
     * Tests Derived property which has derived single or multiple properties.
     */
    public function testDerivedFromPropertyDerivingProperty()
    {
        $record = $this->getRelativeEntityManager()
                ->enableDerived(true)
                ->get(self::$relativeId);
        $this->assertEquals($record->firstName, self::$data['firstName']);

        $derived = $record->derivedMultiple;
        $this->assertEquals($derived->firstName, self::$data['firstName']);
        $this->assertEquals($derived->birthDate->format(DateUtility::MYSQL_DATE_FORMAT), self::$data['birthDate']->format(DateUtility::MYSQL_DATE_FORMAT));
        $this->assertEquals($derived->createdAt->format(DateUtility::MYSQL_DATETIME_FORMAT), self::$data['createdAt']->format(DateUtility::MYSQL_DATETIME_FORMAT));
    }

    /**
     * Tests derived property which has derived whole entity using entity class
     * name in 'from' parameter of @Derived annotation.
     */
    public function testDerivedFromClassWholeEntity()
    {
        $record = $this->entityManager->enableLazy(true)
                ->enableDerived(true)
                ->get(self::$data['userId']);

        $this->assertIsArray($record->relatives);
        foreach ($record->relatives as $index => $relative) {
            $this->assertTrue($relative instanceof EntityManager);
            $this->assertEquals($relative->userId, self::$data['userId']);
            $this->assertEquals($relative->relativeName, 'Relative Name ' . ($index + 1));
        }
    }

    /**
     * Tests derived property with custom join.
     * 
     * @depends testDerivedFromClassWholeEntity
     */
    public function testDerivedPropertyCustomJoin()
    {
        $entity = new EntityManager(TestRelativeEntityCustomJoin::class);
        $records = $entity->enableDerived(true)->enableLazy(true)->getAll();
        foreach ($records as $row) {
            $this->assertEquals($row->extendedName, 'Extended Name 1');
            $this->assertTrue($row->extendedEntity instanceof EntityManager);
        }
    }

    /**
     * Tests derived properties with perfect relation.
     * 
     * @depends testDerivedPropertyCustomJoin
     */
    public function testDerivedPropertyPerfectRelation()
    {
        $query = new Query();

        # This is because postgre have random() funciton
        # instead of rand() in musql & mssql
        if ($query->getConnectionName() === 'postgre') {
            $random = 'RANDOM()';
        } else {
            $random = 'RAND()';
        }

        $relativeIds = $query->setTable(TestRelativeEntity::TABLE)
                ->setColumn('relativeId')
                ->setOrderBy(Query::AS_IT_IS . $random)
                ->setLimit(3)
                ->get(\PDO::FETCH_ASSOC);

        $query->setTable(TestRelativeEntity::TABLE)
                ->setColumnWithValue('userId', null)
                ->setCondition('relativeId[+]', array_column($relativeIds, 'relativeId'))
                ->update();

        $record = $this->getRelativeEntityManager()->enableLazy(true)
                ->enableDerived(true)
                ->getAll();
        $found = false;
        foreach ($record as $row) {
            if (is_null($row->userId)) {
                $found = true;
                break;
            }
        }

        $this->assertFalse($found);
    }

    /**
     * Test setUnFetchable method of EntityManager class.
     * 
     */
    public function testSetUnfetchableMethod()
    {
        $record = $this->getRelativeEntityManager()
                ->setUnFetchable(['userId'])
                ->enableLazy(true)
                ->get(self::$relativeId);

        $this->assertNull($record->userId);

        # Value of firstName is derived using userId property, If its added in
        # unfetchable than firstName should not be available.
        $this->assertNull($record->firstName);
    }

    /**
     * Tests extra property added and retrieving.
     */
    public function testExtraProperty()
    {
        $record = $this->entityManager
                ->get(self::$data['userId']);

        $extra = new ExtraProperty('extra');
        $extra->setDataType('int')
                ->bindTo($record);

        $reflection = new DataClass(TestRelativeEntity::class);
        $reflection->addExtraProperty($extra);

        $record->extra = 123;
        $record->save();

        $updated = $this->entityManager
                ->get(self::$data['userId']);

        $this->assertTrue($updated->isExtraPropertyExists('extra'));

        $this->assertIsInt($updated->extra);
        $this->assertEquals(123, $updated->extra);

        return $updated;
    }

    /**
     * Tests extra property is being updated properly.
     * 
     * @depends testExtraProperty
     */
    public function testUpdateExtraProperty($record)
    {
        $record->extra = 251;
        $record->save();

        $updated = $this->entityManager
                ->get(self::$data['userId']);
        $this->assertTrue($updated->isExtraPropertyExists('extra'));

        $this->assertIsInt($updated->extra);
        $this->assertEquals(251, $updated->extra);

        return $updated;
    }

    /**
     * Tests data type of extra property.
     * 
     * @depends testUpdateExtraProperty
     */
    public function testExtraPropertyDataType($record)
    {
        $this->expectExceptionCode(911008);
        $record->extra = '123';
    }

    /**
     * @depends testUpdateExtraProperty
     */
    public function testExtraPropertyAlreadyExists($record)
    {
        $this->expectExceptionCode(911060);
        $extra = new ExtraProperty('extra');
        $extra->setDataType('int')
                ->bindTo($record);

        $reflection = new DataClass(TestRelativeEntity::class);
        $reflection->addExtraProperty($extra);
    }

    /**
     * @depends testUpdateExtraProperty
     */
    public function testExtraPropertyIsEntityProperty($record)
    {
        $this->expectExceptionCode(911060);
        $extra = new ExtraProperty('userId');
        $extra->setDataType('int')
                ->bindTo($record);

        $reflection = new DataClass(TestRelativeEntity::class);
        $reflection->addExtraProperty($extra);
    }

    /**
     * Tests remove extra property.
     * 
     * @depends testUpdateExtraProperty
     */
    public function testRemoveExtraProperty($record)
    {
        $record->removeExtraProperty('extra');

        $this->assertFalse($record->isExtraPropertyExists('extra'));

        $record->save();

        $updated = $this->entityManager
                ->get(self::$data['userId']);

        $this->assertFalse($updated->isExtraPropertyExists('extra'));
    }

    /**
     * Tests static property properly loading or not.
     */
    public function testStaticProperty()
    {
        (new Query())->setTable(Entity::STATIC_TABLE_NAME)
                ->setColumnWithValue([
                    'entityClass' => TestEntityStaticProperty::class,
                    'propertyName' => 'staticProperty',
                    'data' => 123
                ])->insert();

        new EntityManager(TestEntityStaticProperty::class);

        $this->assertIsInt(TestEntityStaticProperty::$staticProperty);

        $this->assertEquals(123, TestEntityStaticProperty::$staticProperty);
    }

    /**
     * @depends testStaticProperty
     */
    public function testUpdateStaticProperty()
    {
        TestEntityStaticProperty::$staticProperty = 231;
        (new EntityManager(TestEntityStaticProperty::class))
                ->saveStatic();

        $record = (new Query())
                        ->setTable(Entity::STATIC_TABLE_NAME)
                        ->setColumn('data')
                        ->setCondition([
                            'entityClass' => TestEntityStaticProperty::class,
                            'propertyName' => 'staticProperty'
                        ])->getOne();

        $this->assertEquals($record->data, TestEntityStaticProperty::$staticProperty);
    }

    /**
     * Tests data type of static property.
     * 
     */
    public function testStaticPropertyDataType()
    {
        $this->expectExceptionCode(911008);
        TestEntityStaticProperty::$staticProperty = '123';
        (new EntityManager(TestEntityStaticProperty::class))
                ->saveStatic();
    }

    /**
     * Truncating all tests tables.
     */
    public static function tearDownAfterClass(): void
    {
        $query = new Query();
        (new Query)->execute('TRUNCATE TABLE ' . $query->quote(TestRelativeExtendedEntity::TABLE));
        (new Query)->execute('TRUNCATE TABLE ' . $query->quote(TestRelativeEntity::TABLE));
        (new Query)->execute('TRUNCATE TABLE ' . $query->quote(TestEntity::TABLE));
        (new Query)->setTable(Entity::STATIC_TABLE_NAME)
                ->setCondition([
                    'entityClass' => TestEntityStaticProperty::class,
                    'propertyName' => 'staticProperty'
                ])->remove();
    }

}
