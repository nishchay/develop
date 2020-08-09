<?php

namespace Application\Entities;

/**
 * TestEntityStaticProperty
 *
 * @Entity(name='this.base')
 */
class TestEntityStaticProperty
{

    /**
     *
     * @DataType(type=int)
     */
    public static $staticProperty;

}
