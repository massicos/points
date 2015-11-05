<?php
require_once('../classes/Child.php');

class ChildTest extends PHPUnit_Framework_TestCase {
    protected $child;

    public function test_construct() {
        $this->child =  new Child("Caleb", 5);
        
        $this->assertEquals("Caleb", $this->child->getFirstName());
        $this->assertEquals(5, $this->child->getPoints());
    }
    
    public function test_construct2() {
        $this->child =  new Child("Charles", 10);
        
        $this->assertEquals("Charles", $this->child->getFirstName());
        $this->assertEquals(10, $this->child->getPoints());
    }
    
    public function test_loadFromJson() {
        $childjson = Child::loadFromJson(json_decode('{"firstName":"Caleb","points":1000}'));
        
        $this->assertEquals("Caleb", $childjson->getFirstName());
        $this->assertEquals(1000, $childjson->getPoints());        
    }
    
    public function test_toStdClass() {
        $this->child =  new Child("Caleb", 5);
        
        $this->assertJsonStringEqualsJsonString('{"firstName":"Caleb","points":5}', json_encode($this->child->toStdClass()));
    }
}
