<?php

namespace Nishchay\Test;

use Nishchay\Processor\Structure\StructureProcessor;
use PHPUnit\Framework\TestCase;

/**
 * Structure Test class.
 *
 * @author Bhavik Patel
 */
class StructureTest extends TestCase
{

    /**
     * Path to structure data.
     */
    private $structureDataPath = ROOT . 'tests' . DS . 'data' . DS . 'structure' . DS;

    /**
     * Iterates array recursively to test directory and file is valid or not
     */
    public function processApp($path, $directory, StructureProcessor $structure)
    {
        $rowPath = $path;
        foreach ($directory as $name => $subDirectory) {
            if (is_string($name) === false) {
                $this->assertInternalType('array', $structure->isValidFile($path . DS . $subDirectory));
            }

            if (is_array($subDirectory)) {
                $this->assertInternalType('string', $structure->isValidDirectory($path . DS . $name));
                $this->processApp($path . DS . $name, $subDirectory, $structure);
            }
        }
    }

    /**
     * Returns path to structure definition for given number.
     */
    private function getDefinitionPath($number)
    {
        return $this->structureDataPath . 'structure' . $number . DS . 'structure.xml';
    }

    /**
     * Returns structure data for given structure definition number.
     */
    public function getStructureData($number)
    {
        return require_once $this->structureDataPath . 'structure' . $number . DS . 'structureData.php';
    }

    /**
     * Tests structure 1
     */
    public function testStructure1()
    {
        $structure = new StructureProcessor($this->getDefinitionPath(1));
        $this->processApp(ROOT . 'Application', $this->getStructureData(1), $structure);
    }
    /**
     * Tests structure 2
     */
    public function testStructure2()
    {
        $structure = new StructureProcessor($this->getDefinitionPath(2));
        $this->processApp(ROOT . 'Application', $this->getStructureData(2), $structure);
    }
    /**
     * Tests structure 2
     */
    public function testStructure3()
    {
        $structure = new StructureProcessor($this->getDefinitionPath(3));
        $this->processApp(ROOT . 'Application', $this->getStructureData(3), $structure);
    }
}
