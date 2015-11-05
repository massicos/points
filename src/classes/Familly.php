<?php

class Familly {
    private $name;
    private $children;
    public function __construct($name) {
        $this->name = $name;
        $this->children = array();
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
    
    public static function loadFromJson($path) {
        //$cheminFichier = $this->cheminJson . DIRECTORY_SEPARATOR . 'famille-' . $idFamille . '.json';

        if (!is_readable($path)) {
            throw new InvalidArgumentException("Aucun fichier : " . $cheminFichier);
        }
        $fp = fopen($path, "r");
        $str = fread($fp, filesize($path));
        fclose($fp);

        $json = json_decode($str);
        
        $familly = new Familly($json->name);
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
