<?php

namespace Nishchay\Test\Cache;

use Nishchay;
use PHPUnit\Framework\TestCase;

/**
 * Memcached test class.
 */
class MemcachedCacheTest extends TestCase
{

    /**
     * 
     * @return Nishchay\Cache\CacheHandler
     */
    public function getCache()
    {
        return Nishchay::getCache();
    }

    /**
     * Tests set method
     */
    public function testSetItem()
    {
        $this->assertTrue($this->getCache()->set('test', 1234, 30));
    }

    /**
     * Tests setMulti method
     */
    public function testSetMultiItem() {
        $this->assertEquals(3, $this->getCache()->setMulti([
            ['key1','value1', 30],
            ['key2','value2', 30],
            ['key3','value3', 30]
        ]));
    }

    /**
     * Tests add method
     * 
     * @depends testSetItem
     */
    public function testAddItem() {
        # Because we have already added `test` in cache, below should fail
        $this->assertFalse($this->getCache()->add('test', 1235, 30));

        # Adding new
        $this->assertTrue($this->getCache()->add('testNew', 1235, 1));
    }

    /**
     * Tests get method
     * 
     * @depends testSetItem
     */
    public function testGetItem() {
        $this->assertEquals(1234, $this->getCache()->get('test'));
    }

    /**
     * Tests getMulti method
     * 
     * @depends testSetMultiItem
     */
    public function testGetMultiItem() {
        $items = $this->getCache()->getMulti(['key1','key2','key3']);

        $this->assertEquals(3, count($items));

        $this->assertTrue((isset($items['key1'])));
        $this->assertTrue((isset($items['key2'])));
        $this->assertTrue((isset($items['key3'])));

        $this->assertEquals('value1', $items['key1']);
        $this->assertEquals('value2', $items['key2']);
        $this->assertEquals('value3', $items['key3']);
    }

    /**
     * Tests replace method
     * 
     * @depends testSetItem
     */
    public function testReplaceItem() {

        # This should fail
        $this->assertFalse($this->getCache()->replace('notExists', 1234, 1));

        # Replcaing already added
        $this->assertTrue($this->getCache()->replace('test', 1122, 30));

        $this->assertEquals(1122, $this->getCache()->get('test'));
    }

    /**
     * Tests remove method
     * 
     * @depends testGetItem
     */
    public function testRemoveItem() {
        $this->assertTrue($this->getCache()->remove('test'));

        $this->assertFalse($this->getCache()->get('test'));
    }

    /**
     * Tests removeMulti method
     * 
     * @depends testGetMultiItem
     */
    public function testRemoveMultiItem() {
        $this->assertEquals(3, $this->getCache()->removeMulti(['key1','key2','key3']));

        $this->assertFalse($this->getCache()->get('key1'));
        $this->assertFalse($this->getCache()->get('key2'));
        $this->assertFalse($this->getCache()->get('key3'));
    }
}
