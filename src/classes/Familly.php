<?php

class Familly {
    private $name;
    private $children;
    private $password;
    private $parentMode;
    
    public function __construct($name, $password) {
        $this->name = $name;
        $this->children = array();
        $this->password = $password;
        $this->parentMode = false;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getNbrChildren() {
        return count($this->children);
    }
    
    public function addChild($child) {
        $this->children[] = $child;
    }
    
    public function getChildByIndex($index) {
        if ($index >= count($this->children)) {
            throw new OutOfRangeException("Invalid index of child");
        }
        return $this->children[$index];
    }
    
    public function isParentModeActive() {
        return $this->parentMode;
    }
    
    public function setParentMode($parentMode) {
        $this->parentMode = $parentMode;
    }

    public function validatePassword($password) {
        if ($this->password == "") {
            return false;
        }
        if ($this->password == $password) {
            $this->parentMode = true;
            return true;
        }
        $this->parentMode = false;
        return false;
    }
    
    public static function loadFromJson($path) {
        //$cheminFichier = $this->cheminJson . DIRECTORY_SEPARATOR . 'famille-' . $idFamille . '.json';

        if (!is_readable($path)) {
            throw new InvalidArgumentException("Aucun fichier : " . $cheminFichier);
        }
        $fp = fopen($path, "r");
        $str = fread($fp, filesize($path));
        fclose($fp);

        $json = json_decode($str);
        
        $familly = new Familly($json->name, $json->password);
        if (isset($json->children)) {
            $max = count($json->children);
            for ($i = 0; $i < $max; $i++) {
                $familly->addChild(Child::loadFromJson($json->children[$i]));
            }
        }        
        
        return $familly;
    }
    
    public function toStdClass() {
        $famillyStdObj = new StdClass();
        $famillyStdObj->name = $this->name;
        $famillyStdObj->password = $this->password;

        $famillyStdObj->children =  array();
        $max = count($this->children);
        for ($i = 0; $i < $max; $i++) {
            $famillyStdObj->children[] = $this->children[$i]->toStdClass();
        }

        return $famillyStdObj;        
    }
    public function toJson() {
        $famillyStdObj = new StdClass();
        $famillyStdObj->name = $this->name;
        $famillyStdObj->password = $this->password;

        $famillyStdObj->children =  array();
        $max = count($this->children);
        for ($i = 0; $i < $max; $i++) {
            $famillyStdObj->children[] = $this->children[$i]->toStdClass();
        }

        return json_encode($famillyStdObj);
    }
    
    public function saveToJson($path, $filename) {
        $completepath = $path . "/" . $filename;
                
        if (!is_writable($path)) {
            throw new InvalidArgumentException("Incapable d'ecrire : " . $path);
        }
        $fp = fopen($completepath, "w+");
        fwrite($fp, $this->toJson());
        fclose($fp);       
    }
    
    public function getChildByFirstName($firstname) {
        $max = count($this->children);
        for ($i = 0; $i < $max; $i++) {
            if ($this->children[$i]->getFirstName() == $firstname) {
                return $this->children[$i];
            }
        }
        return false;
    }
}
