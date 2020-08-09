<?php

namespace Application\Entities;

/**
 * Description of TestEntity
 *
 * @Entity(name='this.base')
 */
class TestEntity
{

    const TABLE = 'TestEntity';

    /**
     *
     * @Identity
     * @DataType(type=int,readonly=true)
     */
    public $userId;

    /**
     *
     * @DataType(type=string,length=50,required=true,encrypt=true)
     */
    public $firstName;

    /**
     *
     * @DataType(type=int)
     * Relative(to="\Application\Entities\TestRelativeExtendedEntity")
     */
    public $relativeExtendedId;

    /**
     *
     * @DataType(type=date)
     */
    public $birthDate;

    /**
     *
     * @DataType(type=datetime) 
     */
    public $createdAt;

    /**
     *
     * @DataType(type=int) 
     */
    public $intType;

    /**
     *
     * @DataType(type=float,length=5.2) 
     */
    public $floatType;

    /**
     *
     * @DataType(type=double) 
     */
    public $doubleType;

    /**
     *
     * @DataType(type=boolean)
     */
    public $booleanType;

    /**
     *
     * @Derived(from="Application\Entities\TestRelativeEntity", hold=multiple)
     */
    public $relatives;
}
