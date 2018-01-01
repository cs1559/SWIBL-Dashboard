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

abstract class ObjectBuilder {
  
    /**
     * The build method is an abstract function that all subclasses must implement. 
     * 
     * @param unknown $result
     */
    abstract function build($result);   
  
     /**
       * The map function will accept three (3) arguments and build the object with values from the array based on the map.
       * 
       * @param unknown $array - This represents the query results 
       * @param unknown $map - This is an array of table column names (in an array) and the corresponding method used to set the objects value
       * @param unknown $object - a reference to the object being populated.
       * @throws Exception
       */
      protected function map($array, $map, &$object) {
          
          try {
              // Convert result object to an array
              $objVars = get_object_vars($array);
              
              foreach ($map as $field => $method) {
                  if (isset($objVars[$field]))
                      $object->$method($objVars[$field]);
              }
              $object->setObjectState(true);
          } catch (\Exception $e) {
              throw $e;
          }
      }
}