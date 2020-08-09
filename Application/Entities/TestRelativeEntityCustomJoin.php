<?php

namespace Application\Entities;

/**
 * Description of TestRelativeEntity
 *
 * @Entity(name='TestRelativeEntity')
 */
class TestRelativeEntityCustomJoin
{

    const TABLE = 'TestRelativeEntity';

    /**
     *
     * @Identity
     * @DataType(type=int, readonly=true)
     */
    private $relativeId;

    /**
     *
     * @DataType(type=int, required=true)
     * @Relative(to="Application\Entities\TestEntity", type=perfect)
     */
    private $userId;

    /**
     *
     * @DataType(type=string, length=50)
     */
    private $relativeName;

    /**
     *
     * @Derived(join="getJoinRule", property='TestRelativeExtendedEntity.name')
     */
    private $extendedName;

    /**
     *
     * @Derived(join="getJoinRuleEntity")
     */
    private $extendedEntity;

    public function getJoinRule()
    {
        return [
            TestEntity::class . '(TestEntity)' => 'userId',
            TestRelativeExtendedEntity::class . '(TestRelativeExtendedEntity)' => ['TestRelativeExtendedEntity.relativeExtendedId' => 'TestEntity.relativeExtendedId']
        ];
    }

    public function getJoinRuleEntity()
    {
        return [
            TestEntity::class . '(TestEntityWholeEntity)' => 'userId',
            TestRelativeExtendedEntity::class . '(TestRelativeExtendedEntityWholeEntity)' => ['TestRelativeExtendedEntityWholeEntity.relativeExtendedId' => 'TestEntityWholeEntity.relativeExtendedId']
        ];
    }

}
