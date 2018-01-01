<?php
namespace Presto\framework\logger;

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

abstract class Logger 
{
    
    var $level = 1;
    var $enabled = 1;
    
    /**
     * @return boolean $enabled
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param number $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int $level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param number $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    abstract function info($msg);
    abstract function warning($msg);
    abstract function error($msg);
    abstract function critcal($msg);
    abstract function write($msg);
    abstract function debug($msg);
    abstract function writeObject($obj);
    
}
