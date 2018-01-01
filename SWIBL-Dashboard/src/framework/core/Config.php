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

class Config {
    
    var $properties = null;
    
    static function getInstance() {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new self();
        }
        return $instance;
    }
    
    
    function setProperty($inname, $invalue) {
        $this->addProperty($inname, $invalue);
    }
    function addProperty($inname, $invalue) {
        $prop = new Property($inname, ltrim($invalue));
        $this->setPropertyObject($prop);
    }
    private function setPropertyObject(Property $prop) {
        $this->properties[$prop->getName()] = $prop->getValue();
    }
    
    function setProperties($inParm) {
        $this->props = $inParm;
    }
    function getProperties() {
        return $this->props;
    }
    function getPropertyValue($key) {
        if ($this->properties == null)
            return null;
            if (isset($this->properties[$key])) {
                return $this->properties[$key];
            } else {
                return null;
            }
    }
    function getProperty($key) {
        return $this->getPropertyValue($key);
    }
}

?>