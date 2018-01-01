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


class FileLogger extends Logger 
{
    
    private $filename = null;
    
    private function __construct() {  }
    
    static function getInstance($filename) {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new self();
            $instance->setFilename($filename);
        }
        return $instance;
    }
    
    private function setFilename($fn) {
        $this->filename = $fn;
    }
    private function getFilename() {
        return $this->filename;
    }
    public function warning($msg)
    {
        $this->write("[WARNING] " . $msg);
    }

    public function critcal($msg)
    {
        $this->write($msg);
    }

    public function error($msg)
    {
        $this->write("[ERROR] " . $msg);
    }

    public function write($msg)
    {
        if (!$this->isEnabled()) {
            return;
        }
        $time = @date('[d/M/Y:H:i:s]');
        
        // open file
        $fd = fopen($this->getFilename(), 'a');
        
        // write string
        fwrite($fd, $time . " " . $msg . PHP_EOL);
        
        // close file
        fclose($fd);
    }
    
    public function debug($msg) {
        if ($this->getLevel() > 2) {
            $this->write("[DEBUG] " . $msg);
        }
        return;
    }

    public function writeObject($obj) {
        if (!$this->isEnabled()) {
            return;
        }
        
        ob_start ();
        print_r($obj);
        $content = ob_get_contents ();
        ob_end_clean ();
               
        $time = @date('[d/M/Y:H:i:s]');
        
        // open file
        $fd = fopen($this->getFilename(), 'a');
        
        fwrite($fd, $time . " [OBJECT]  " . get_class($obj) . " " . PHP_EOL);
        fwrite($fd, "Object: " . $content);
        fclose($fd);
    }
    
    public function info($msg)
    {
        $this->write("[INFO] " . $msg);
    }

}
