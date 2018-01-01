<?php
namespace Presto\framework\core;
/*
 MIT License
 
 Copyright (c) 2017 Chris Strieter
 
 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:
 
 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 SOFTWARE.
 */

class BaseObject implements \JsonSerializable 
{
    
    const VALID = 1;
    const INVALID = 0;
    
    var $objectstate = null;
    var $properties = null;
    
    function __construct() {
        $this->properties = array();
    }
    
    
    public function getObjectState() {
        if (is_null($this->objectstate)) {
            return cjs\lib\BaseObject\VALID;
        } else {
            return $this->objectstate;
        }
    }
    public function setObjectState($value) {
        $this->objectstate = $value;
    }
    
    /**
     * This function will format all of the name/value properties so that they can be persisted
     * within a TEXT column within the database.
     *
     * @return string
     */
    function getFormattedProperties() {
        $props = '';
        foreach ($this->properties as $key => $val) {
            //$props .= $pro->getName() . "=" . $pro->getValue . "\n";
            $newval = str_ireplace("=","&#61;",$val);    // Clean the value to replace any EQUAL signs with the HTML code
            $props .= $key . "=" . $val . "\n";
        }
        return $props;
    }
    
    /**
     * This function will parse the properties stored within the database and populates
     * the data name/value pairs into an array.
     *
     * @param string $props
     */
    function parseDatabaseObjectProperties($props) {
        //$proparray = split("\n",$props);
        $proparray = preg_split("/[\n]+/",$props);
        for ($y=0; $y<(sizeof($proparray)); $y++) {
            //$prop = split("=",$proparray[$y]);
            $prop = preg_split("/[=]+/",$proparray[$y]);
            //TODO:  Revisit this.  This is a quick work around.  need to investigate origin of
            // why this $prop[1] would generate an undefined offset on the $prop array
            if (key_exists(1,$prop)) {
                $bad_characters = array("\n", "\r");
                $newprop = str_ireplace($bad_characters, "", $prop[1]); // remove bad characters
                $this->addProperty($prop[0],$newprop);
            }
        }
    }
    
    function addProperty($inname, $invalue) {
        $newval = str_ireplace("=","&#61;",$invalue);
        $prop = new Property($inname, ltrim($newval));
        $this->setPropertyObject($prop);
    }
  
    private function setPropertyObject(Property $prop) {
        $this->properties[$prop->getName()] = $prop->getValue();
    }
    
    public function jsonSerialize()
    {
        $class_vars = get_class_vars(get_class($this));
        $jsonArray = array();
        foreach ($class_vars as $name => $value) {
            $jsonArray[$name] = $this->$name;
        }
        return $jsonArray;
    }
    
}