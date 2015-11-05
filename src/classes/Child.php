<?php

class Child {
    private $firstName;
    private $points;
    
    public function __construct($firstName, $points) {
        $this->firstName = $firstName;
        $this->points = $points;
    }
    
    public function getFirstName() {
        return $this->firstName;
    }
    
    public function getPoints() {
        return $this->points;
    }
    
    public static function loadFromJson($json) {
        return new Child($json->firstName, $json->points);
    }
    
    public function toStdClass() {
        $child = new stdClass();
        $child->firstName = $this->firstName;
        $child->points = $this->points;
        
        return $child;
    }
    
    public function addPoints($points) {
        $this->points = $this->points +  $points;
    }
}
