<?php

namespace Application\Entities;

/**
 * Description of TestRelativeEntity
 *
 * @Entity(name='this.base')
 */
class TestRelativeEntity
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
     * @DataType(type=int)
     * @Relative(to="Application\Entities\TestEntity", type=perfect)
     */
    private $userId;

    /**
     *
     * @Derived(from=userId, property=firstName)
     */
    private $firstName;

    /**
     *
     * @DataType(type=string, length=250,encrypt=true)
     */
    private $relativeName;

    /**
     *
     * @Derived(from=userId, property=['firstName','birthDate','createdAt'])
     */
    private $derivedMultiple;

}
