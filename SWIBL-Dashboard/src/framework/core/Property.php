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

class Property 
{
    
    private $name = null;
    private $value = null;
    
    
    /**
     * Constructor initializing the name and value of the property
     *
     * @param string $inName
     * @param object $inValue
     */
    function __construct($inName, $inValue) {
        $this->name = $inName;
        $this->value = $inValue;
    }
    
    /**
     * Returns the property name
     *
     * @return string
     */
    function getName() {
        return $this->name;
    }
    
    /**
     * Returns the value of the property
     *
     * @return object
     */
    function getValue() {
        return $this->value;
    }
    
    function __toString() {
        return "PROPERTY:  name= " . self::getName() . " value = " . self::getValue();
    }
    
}
?>
