<?php
require_once('../classes/Familly.php');
require_once('../classes/Child.php');

class ChildTest extends PHPUnit_Framework_TestCase {
    protected $familly;

    protected function tearDown() {
        shell_exec("rm -f jsonSave/*.json");
    }
    public function test_construct() {
        $this->familly =  new Familly("Vallé");
        
        $this->assertEquals("Vallé", $this->familly->getName());
    }
    
    public function test_construct2() {
        $this->familly =  new Familly("Massicotte");
        
        $this->assertEquals("Massicotte", $this->familly->getName());
    }
    
    public function test_child() {
        $this->familly =  new Familly("Massicotte");
        
        $this->assertEquals(0, $this->familly->getNbrChildren());
        
        $this->familly->addChild(new Child("Charles", 5));        
        $this->assertEquals(1, $this->familly->getNbrChildren());
        $child = $this->familly->getChildByIndex(0);
        $this->assertEquals("Charles", $child->getFirstName());
        
        $this->familly->addChild(new Child("Léanne", 10));        
        $this->assertEquals(2, $this->familly->getNbrChildren());        
        $child = $this->familly->getChildByIndex(1);
        $this->assertEquals("Léanne", $child->getFirstName());        
        
    }
    
    /**
     * @expectedException OutOfRangeException
     */
    public function test_childInvalidIndex() {
        $this->familly =  new Familly("Massicotte");
        
        $child = $this->familly->getChildByIndex(0);
    }
    
    /**
     * @expectedException OutOfRangeException
     */
    public function test_childInvalidIndex2() {
        $this->familly =  new Familly("Massicotte");

        $this->familly->addChild(new Child("Charles", 5));
        $child = $this->familly->getChildByIndex(1);
    }
    
    public function test_load1() {
        $this->familly = Familly::loadFromJson('json/familly1.json');
        $this->assertEquals("Vallé", $this->familly->getName());
        $this->assertEquals(0, $this->familly->getNbrChildren());        
    }
    
    public function test_load2() {
        $this->familly = Familly::loadFromJson('json/familly2.json');
        $this->assertEquals("Massicotte", $this->familly->getName());
        $this->assertEquals(2, $this->familly->getNbrChildren());        
    }
    
    public function test_saveToJson() {
        $this->familly =  new Familly("Vallé");        
        $this->familly->saveToJson("jsonSave", "familly1.json");
        
        $this->assertEquals(true, is_readable("jsonSave/familly1.json"));
        $this->assertJsonFileEqualsJsonFile("json/familly1.json", "jsonSave/familly1.json");
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_saveToJsonException() {
        $this->familly =  new Familly("Vallé");        
        $this->familly->saveToJson("jsonSaveTemp", "famille1.json");        
    }
    
    public function test_saveToJson2() {
        $this->familly =  new Familly("Massicotte");
        $this->familly->addChild(new Child("Léanne", 50));
        $this->familly->addChild(new Child("Charles", 60));
        
        $this->familly->saveToJson("jsonSave", "familly2.json");
        
        $this->assertEquals(true, is_readable("jsonSave/familly2.json"));
        $this->assertJsonFileEqualsJsonFile("json/familly2.json", "jsonSave/familly2.json");
    }    
}
