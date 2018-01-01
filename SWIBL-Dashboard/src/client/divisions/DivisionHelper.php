<?php
namespace swibl\client\divisions;

use swibl\client\divisions\DivisionBuilder;
use swibl\client\divisions\Division;
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

/**
 * 
 * @author Admin
 *
 */
class DivisionHelper {
    
    /**
     * This method will map/bind an individual item returned by the REST API to the Team object.
     * 
     * @param array $result
     * @return Division
     */
    public static function bind($result) {
        $builder = new DivisionBuilder();
        return $builder->build($result);
    }
    
       
    /**
     * This method will take an array of JSON objects returned from a query and binds each JSON record to a Team object.  The method
     * will return an array of Team objects.
     * 
     * @param array $inArray
     * @return array[]
     */
    public static function bindArray($inArray) {
        if (!is_array($inArray)) {
            throw new \Exception("Input value is not an array");
        }
        $returnArray = array();
        
        foreach ($inArray as $item) {
            $game = DivisionHelper::bind($item);
            $returnArray[] = $game;
        }
        return $returnArray;
    }


}