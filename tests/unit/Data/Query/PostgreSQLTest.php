<?php

namespace Nishchay\Test\Data\Query;

use Nishchay\Exception\ApplicationException;
use PHPUnit\Framework\TestCase;
use Nishchay\Data\Query;

/**
 * Description of PostgreSQLTest
 *
 * @author Bhavik Patel
 */
class PostgreSQLTest extends TestCase
{

    /**
     * Returns instance of query.
     * 
     * @return \Nishchay\Data\Query
     */
    private function getQuery()
    {
        return new Query('postgre');
    }

    /**
     * Removes PHP_EOL from query statement.
     * 
     * @param string $query
     * @return string
     */
    private function getTrimmed($query)
    {
        return preg_replace('#\s+#', ' ', str_replace(PHP_EOL, ' ', $query));
    }

    /**
     * Tests query with select all.
     */
    public function testSelect()
    {
        $all = $this->getQuery()
                ->setTable('user')
                ->getSql();
        $this->assertEquals('SELECT * FROM "user"', $this->getTrimmed($all));
    }

    /**
     * Tests select query with limit.
     */
    public function testSelectLimit()
    {
        $limit = $this->getQuery()
                ->setTable('user')
                ->setLimit(1)
                ->getSql();
        $this->assertEquals('SELECT * FROM "user" LIMIT 1 OFFSET 0', $this->getTrimmed($limit));

        $offsetLimit = $this->getQuery()
                ->setTable('user')
                ->setLimit(10, 100)
                ->getSql();
        $this->assertEquals('SELECT * FROM "user" LIMIT 10 OFFSET 100', $this->getTrimmed($offsetLimit));
    }

    /**
     * Tests query with specific column to select.
     */
    public function testSelectColumn()
    {
        $column = $this->getQuery()
                ->setTable('user')
                ->setColumn(['userId', 'fullName'])
                ->getSql();

        $this->assertEquals('SELECT "userId","fullName"'
                . ' FROM "user"', $this->getTrimmed($column));

        $alisColumn = $this->getQuery()
                ->setTable('user')
                ->setColumn([
                    'aliasUserId' => 'userId',
                    'aliasFullName' => 'fullName'
                ])
                ->getSql();

        $this->assertEquals('SELECT '
                . '"userId" AS "aliasUserId","fullName" AS "aliasFullName"'
                . ' FROM "user"', $this->getTrimmed($alisColumn));

        $columnAsItIs = $this->getQuery()
                ->setTable('user')
                ->setColumn([
                    'departmentId',
                    'totalDepartment' . Query::AS_IT_IS => 'COUNT(departmentId)'
                ])
                ->getSql();

        $this->assertEquals('SELECT '
                . '"departmentId",'
                . 'COUNT(departmentId) AS "totalDepartment"'
                . ' FROM "user"', $this->getTrimmed($columnAsItIs));
    }

    /**
     * Tests order by
     */
    public function testOrderBy()
    {
        $default = $this->getQuery()
                ->setTable('user')
                ->setOrderBy('createdAt')
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' ORDER BY'
                . ' "createdAt" ASC', $this->getTrimmed($default));

        $descOrder = $this->getQuery()
                ->setTable('user')
                ->setOrderBy(['createdAt' => 'DESC'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' ORDER BY'
                . ' "createdAt" DESC', $this->getTrimmed($descOrder));

        $multiple = $this->getQuery()
                ->setTable('user')
                ->setOrderBy(['createdAt', 'departmentId'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' ORDER BY'
                . ' "createdAt" ASC ,'
                . '"departmentId" ASC', $this->getTrimmed($multiple));


        $multipleDiffSort = $this->getQuery()
                ->setTable('user')
                ->setOrderBy(['createdAt' => 'DESC', 'departmentId' => 'ASC'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' ORDER BY'
                . ' "createdAt" DESC ,'
                . '"departmentId" ASC', $this->getTrimmed($multipleDiffSort));
    }

    /**
     * tests query with various conditions
     */
    public function testCondition()
    {
        # Single clause
        $where = $this->getQuery()
                ->setTable('user')
                ->setCondition(['userId' => 1])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE "userId" = 1', $this->getTrimmed($where));

        # AND clause
        $andWhere = $this->getQuery()
                ->setTable('user')
                ->setCondition([
                    'userId' => 1,
                    'active' => 1
                ])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE '
                . '"userId" = 1'
                . ' AND'
                . ' "active" = 1', $this->getTrimmed($andWhere));

        # OR clause
        $orWhere = $this->getQuery()
                ->setTable('user')
                ->setCondition([
                    'userId' => 1,
                    'active' => 1,
                    'OR'
                ])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE '
                . '"userId" = 1'
                . ' OR '
                . '"active" = 1', $this->getTrimmed($orWhere));

        # AND OR clause
        $andOrWhere = $this->getQuery()
                ->setTable('user')
                ->setCondition([
                    [
                        'userId' => 1,
                        'active' => 1,
                    ],
                    [
                        'userId' => 2,
                        'active' => 1,
                    ],
                    'OR'
                ])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE'
                . ' ("userId" = 1 AND "active" = 1)'
                . ' OR'
                . ' ("userId" = 2 AND "active" = 1)', $this->getTrimmed($andOrWhere));

        # OR AND clause
        $orAndWhere = $this->getQuery()
                ->setTable('user')
                ->setCondition([
                    [
                        'departmentId' => 1,
                        'roleId' => 2,
                        'OR',
                    ],
                    [
                        'departmentId' => 2,
                        'roleId' => 1,
                        'OR',
                    ]
                ])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE '
                . '("departmentId" = 1 OR "roleId" = 2)'
                . ' AND'
                . ' ("departmentId" = 2 OR "roleId" = 1)', $this->getTrimmed($orAndWhere));

        # Custom operator
        $singleOprator = $this->getQuery()
                ->setTable('user')
                ->setCondition('salary>', 20000)
                ->getSQL();
        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE'
                . ' "salary" > 20000', $this->getTrimmed($singleOprator));

        # More then one operator character
        $operatorGreaterEqual = $this->getQuery()
                ->setTable('user')
                ->setCondition('salary>=', 20000)
                ->getSQL();
        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE'
                . ' "salary" >= 20000', $this->getTrimmed($operatorGreaterEqual));
    }

    /**
     * Test query condition with operand sign like considering right
     * operand as column or as it is.
     */
    public function testConditionOperandSign()
    {
        # Considering right operand as column
        $bothColumn = $this->getQuery()
                ->setTable('user')
                ->setCondition('salary' . Query::AS_COLUMN, 'anotherColumn')
                ->getSQL();
        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE'
                . ' "salary" = "anotherColumn"', $this->getTrimmed($bothColumn));

        # Consdering right operand as column with custom operator
        $bothColumnWithOperator = $this->getQuery()
                ->setTable('user')
                ->setCondition('salary>=' . Query::AS_COLUMN, 'anotherColumn')
                ->getSQL();
        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE'
                . ' "salary" >= "anotherColumn"', $this->getTrimmed($bothColumnWithOperator));

        # Considering right operand as its
        $rightOprandAsItIs = $this->getQuery()
                ->setTable('user')
                ->setCondition('salary' . Query::AS_IT_IS, 'anotherColumn')
                ->getSQL();
        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE "salary" = anotherColumn', $this->getTrimmed($rightOprandAsItIs));

        # Considering left operand as it is
        $leftOprandAsItIs = $this->getQuery()
                ->setTable('user')
                ->setCondition('SUM(leaves) > ' . Query::LEFT_AS_IT_IS, 10)
                ->getSQL();
        $this->assertEquals('SELECT * FROM "user"'
                . ' WHERE SUM(leaves) > 10', $this->getTrimmed($leftOprandAsItIs));
    }

    /**
     * Test various types of join.
     */
    public function testJoinType()
    {
        $defaultJoin = $this->getQuery()->setTable('user')
                ->addJoin(['department' => 'departmentId'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' LEFT JOIN "department"'
                . ' ON "department"."departmentId" = "user"."departmentId"', $this->getTrimmed($defaultJoin));

        $leftJoin = $this->getQuery()->setTable('user')
                ->addJoin([Query::LEFT_JOIN . 'department' => 'departmentId'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' LEFT JOIN "department"'
                . ' ON "department"."departmentId" = "user"."departmentId"', $this->getTrimmed($leftJoin));

        $rightJoin = $this->getQuery()->setTable('user')
                ->addJoin([Query::RIGHT_JOIN . 'department' => 'departmentId'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' RIGHT JOIN "department"'
                . ' ON "department"."departmentId" = "user"."departmentId"', $this->getTrimmed($rightJoin));

        $innerJoin = $this->getQuery()->setTable('user')
                ->addJoin([Query::INNER_JOIN . 'department' => 'departmentId'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' INNER JOIN "department"'
                . ' ON "department"."departmentId" = "user"."departmentId"', $this->getTrimmed($innerJoin));

        $crossJoin = $this->getQuery()->setTable('user')
                ->addJoin([Query::CROSS_JOIN . 'department' => 'departmentId'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' CROSS JOIN "department"'
                . ' ON "department"."departmentId" = "user"."departmentId"', $this->getTrimmed($crossJoin));

        $fullJoin = $this->getQuery()->setTable('user')
                ->addJoin([Query::FULL_JOIN . 'department' => 'departmentId'])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' FULL JOIN "department"'
                . ' ON "department"."departmentId" = "user"."departmentId"', $this->getTrimmed($fullJoin));
    }

    /**
     * Tests join condition.
     */
    public function testJoinCondition()
    {
        $differentColumn = $this->getQuery()->setTable('user')
                ->addJoin(['address' => ['userId' => 'id']])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' LEFT JOIN "address"'
                . ' ON "address"."userId" = "user"."id"', $this->getTrimmed($differentColumn));

        $multipleCondition = $this->getQuery()->setTable('hostel')
                ->addJoin(['room' => ['hostelId', 'blockId' => 'blockId']])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "hostel"'
                . ' LEFT JOIN "room"'
                . ' ON'
                . ' "room"."hostelId" = "hostel"."hostelId"'
                . ' AND'
                . ' "room"."blockId" = "hostel"."blockId"', $this->getTrimmed($multipleCondition));

        $multipleOrCondition = $this->getQuery()->setTable('hostel')
                ->addJoin(['room' => ['hostelId', 'blockId' => 'blockId', '!OR']])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "hostel"'
                . ' LEFT JOIN "room"'
                . ' ON'
                . ' "room"."hostelId" = "hostel"."hostelId"'
                . ' OR'
                . ' "room"."blockId" = "hostel"."blockId"', $this->getTrimmed($multipleOrCondition));

        $valueCondition = $this->getQuery()->setTable('hostel')
                ->addJoin(['room' => ['hostelId', 'blockId' . Query::AS_VALUE => 2]])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "hostel"'
                . ' LEFT JOIN "room"'
                . ' ON'
                . ' "room"."hostelId" = "hostel"."hostelId"'
                . ' AND'
                . ' "room"."blockId" = 2', $this->getTrimmed($valueCondition));


        $valueInCondition = $this->getQuery()->setTable('hostel')
                ->addJoin(['room' => ['hostelId', 'blockId[+]' => [1, 2, 3]]])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "hostel"'
                . ' LEFT JOIN "room"'
                . ' ON'
                . ' "room"."hostelId" = "hostel"."hostelId"'
                . ' AND'
                . ' "room"."blockId" IN (1,2,3)', $this->getTrimmed($valueInCondition));


        $valueNotInCondition = $this->getQuery()->setTable('hostel')
                ->addJoin(['room' => ['hostelId', 'blockId[!]' => [1, 2, 3]]])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "hostel"'
                . ' LEFT JOIN "room"'
                . ' ON'
                . ' "room"."hostelId" = "hostel"."hostelId"'
                . ' AND'
                . ' "room"."blockId" NOT IN (1,2,3)', $this->getTrimmed($valueNotInCondition));

        $valueBetweenCondition = $this->getQuery()->setTable('hostel')
                ->addJoin(['room' => ['hostelId', 'blockId[><]' => [1, 2]]])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "hostel"'
                . ' LEFT JOIN "room"'
                . ' ON'
                . ' "room"."hostelId" = "hostel"."hostelId"'
                . ' AND'
                . ' "room"."blockId" BETWEEN 1 AND 2', $this->getTrimmed($valueBetweenCondition));
    }

    /**
     * Test sub query.
     */
    public function testSubQuery()
    {
        $locationQuery = $this->getQuery()
                ->setTable('location')
                ->setColumn(['name'])
                ->setCondition(['location.locationId' . Query::AS_COLUMN => 'hostel.locationId']);

        # Sub query in select column
        $inSelectColumn = $this->getQuery()
                ->setTable('hostel')
                ->setColumn(['locationName' => $locationQuery])
                ->getSQL();

        $this->assertEquals('SELECT ('
                . 'SELECT "name"'
                . ' FROM "location"'
                . ' WHERE "location"."locationId" = "hostel"."locationId"'
                . ') AS "locationName" FROM "hostel"', $this->getTrimmed($inSelectColumn));

        $blockIdQuery = ($this->getQuery())->setTable('block')
                ->setColumn('blockId')
                ->setCondition(['locationId' => 1]);

        # Sub query in where clause.
        $inCondition = $this->getQuery()
                ->setTable('hostel')
                ->setCondition(['blockId[+]' => $blockIdQuery])
                ->getSQL();
        $this->assertEquals('SELECT * FROM "hostel"'
                . ' WHERE "blockId"'
                . ' IN ('
                . 'SELECT "blockId"'
                . ' FROM "block" WHERE "locationId" = 1'
                . ')', $this->getTrimmed($inCondition));


        # Sub query in join condition. 
        $inJoinCondition = $this->getQuery()->setTable('hostel')
                ->addJoin(['room' => ['hostelId', 'blockId[+]' => $blockIdQuery]])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "hostel"'
                . ' LEFT JOIN "room"'
                . ' ON'
                . ' "room"."hostelId" = "hostel"."hostelId"'
                . ' AND "room"."blockId"'
                . ' IN ('
                . 'SELECT "blockId"'
                . ' FROM "block" WHERE "locationId" = 1'
                . ')', $this->getTrimmed($inJoinCondition));
    }

    /**
     * Tests set table throws exception.
     */
    public function testSetTableException()
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage('Alias required when subquery'
                . ' is used as from table.');
        $this->getQuery()->setTable(($this->getQuery())->setTable('foo'));
    }

    /**
     * Tests between clause throws exception.
     */
    public function testBetweenClauseException()
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage('Between clause requires array '
                . 'with exact two elements');
        $this->getQuery()->setTable('user')
                ->setCondition('age[><]', [1, 2, 3]);
    }

    /**
     * Sets table alias
     */
    public function testTableAlias()
    {
        $mainTableAlias = $this->getQuery()
                ->setTable('user', 'u')
                ->addJoin(['address' => 'userId'])
                ->getSQL();

        $this->assertEquals('SELECT *'
                . ' FROM "user" AS "u"'
                . ' LEFT JOIN "address"'
                . ' ON "address"."userId" = "u"."userId"', $this->getTrimmed($mainTableAlias));


        $multipleAlias = $this->getQuery()
                ->setTable('user', 'u')
                ->addJoin(['address(a)' => 'userId'])
                ->getSQL();

        $this->assertEquals('SELECT *'
                . ' FROM "user" AS "u"'
                . ' LEFT JOIN "address" AS "a"'
                . ' ON "a"."userId" = "u"."userId"', $this->getTrimmed($multipleAlias));
    }

    /**
     * Tests between clause throws exception while passing with multiple
     * conditions.
     */
    public function testBetweenClauseException2()
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage('Between clause requires array '
                . 'with exact two elements');
        $this->getQuery()->setTable('user')
                ->setCondition([
                    'departmentId' => 1,
                    'age[><]' => [1, 2, 3]
        ]);
    }

    /**
     * Tests having clause
     */
    public function testHaving()
    {
        $query = $this->getQuery();
        $having = $query->setTable('user')
                ->addJoin(['skills' => 'userId'])
                ->setHaving('COUNT(' . $query->quote('skills.userId') . ')>' . Query::LEFT_AS_IT_IS, 3)
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' LEFT JOIN "skills"'
                . ' ON "skills"."userId" = "user"."userId"'
                . ' HAVING COUNT("skills"."userId")>3', $this->getTrimmed($having));

        $query = $this->getQuery();
        $havingWithArray = $query->setTable('user')
                ->addJoin(['skills' => 'userId'])
                ->setHaving(['COUNT(' . $query->quote('skills.userId') . ')>' . Query::LEFT_AS_IT_IS => 3])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' LEFT JOIN "skills"'
                . ' ON "skills"."userId" = "user"."userId"'
                . ' HAVING COUNT("skills"."userId")>3', $this->getTrimmed($havingWithArray));

        $query = $this->getQuery();
        $havingMultipleCondition = $query->setTable('user')
                ->addJoin(['skills' => 'userId'])
                ->setHaving([
                    'COUNT(' . $query->quote('skills.userId') . ')>' . Query::LEFT_AS_IT_IS => 3,
                    'skills.type' => 2
                ])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' LEFT JOIN "skills"'
                . ' ON "skills"."userId" = "user"."userId"'
                . ' HAVING COUNT("skills"."userId")>3 AND "skills"."type" = 2', $this->getTrimmed($havingMultipleCondition));


        $query = $this->getQuery();
        $havingInClause = $query->setTable('user')
                ->addJoin(['skills' => 'userId'])
                ->setHaving([
                    'COUNT(' . $query->quote('skills.userId') . ')>' . Query::LEFT_AS_IT_IS => 3,
                    'skills.type[+]' => [1, 2, 3]
                ])
                ->getSQL();

        $this->assertEquals('SELECT * FROM "user"'
                . ' LEFT JOIN "skills"'
                . ' ON "skills"."userId" = "user"."userId"'
                . ' HAVING COUNT("skills"."userId")>3 AND "skills"."type" IN (1,2,3)', $this->getTrimmed($havingInClause));
    }

    /**
     * Tests update statement.
     */
    public function testUpdate()
    {
        $update = $this->getQuery()
                ->setTable('user')
                ->setColumnWithValue(['firstName' => 'New First Name'])
                ->setCondition(['userId' => 1])
                ->getSQL();

        $this->assertEquals('UPDATE "user"'
                . ' SET "firstName" = \'New First Name\''
                . ' WHERE "userId" = 1', $this->getTrimmed($update));
    }

    /**
     * Tests update with join
     */
    public function testUpdateWithJoin()
    {
        $query = $this->getQuery();
        $update = $query->setTable('hostel')
                ->addJoin(['room' => ['hostelId']])
                ->setColumnWithValue(['hostel.totalRooms' . Query::AS_IT_IS => 'COUNT(' . $query->quote('room.roomId') . ')'])
                ->setCondition(['hostel.hostelId' => 3])
                ->getSQL();

        $this->assertEquals('UPDATE "hostel"'
                . ' LEFT JOIN "room"'
                . ' ON'
                . ' "room"."hostelId" = "hostel"."hostelId"'
                . ' SET'
                . ' "hostel"."totalRooms" = COUNT("room"."roomId")'
                . ' WHERE'
                . ' "hostel"."hostelId" = 3', $this->getTrimmed($update));
    }

    /**
     * Tests insert query.
     */
    public function testQueryInsert()
    {
        $insert = $this->getQuery()
                        ->setTable('user')
                        ->setColumnWithValue([
                            'fullName' => 'Test',
                            'birthDate' => '2018-11-07'
                        ])->getSql();
        $this->assertEquals('INSERT INTO "user"("fullName","birthDate") '
                . 'VALUES(\'Test\',\'2018-11-07\')', $this->getTrimmed($insert));
    }

    /**
     * Tests delete statement.
     */
    public function testDelete()
    {
        $delete = $this->getQuery()
                ->setTable('user')
                ->setCondition(['userId' => 1])
                ->getDeleteSql();

        $this->assertEquals('DELETE FROM "user" WHERE "userId" = 1', $this->getTrimmed($delete));
    }

    /**
     * Tests delete statement with join.
     */
    public function testDeleteWithJoin()
    {
        $query = $this->getQuery();
        $delete = $query
                ->setTable('user')
                ->addJoin(['address' => 'userId'])
                ->setCondition(['COUNT(' . $query->quote('address.invalid') . ') > ' . Query::LEFT_AS_IT_IS => 5])
                ->getDeleteSql();

        $this->assertEquals('DELETE "user" FROM "user"'
                . ' LEFT JOIN "address"'
                . ' ON "address"."userId" = "user"."userId"'
                . ' WHERE COUNT("address"."invalid") > 5', $this->getTrimmed($delete));
    }

}
