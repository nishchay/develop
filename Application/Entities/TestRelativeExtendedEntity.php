<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entities;

/**
 * Description of TestRelativeExtended
 *
 * @Entity(name='this.base')
 */
class TestRelativeExtendedEntity
{

    const TABLE = 'TestRelativeExtendedEntity';

    /**
     *
     * @Identity
     * @DataType(type=int, readonly=true) 
     */
    private $relativeExtendedId;

    /**
     *
     * @DataType(type=string, length=50)
     */
    private $name;

}
