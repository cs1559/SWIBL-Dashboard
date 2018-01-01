<?php
namespace Presto\framework\html;

class Link extends HtmlElement {
	
	public function __construct($value, $text=null, $name = null) {
		$this->setTagName("a");
		$this->setId($name);
		$this->setName($name);
		if ($text == null) {
			$text = $value;
		}
		$this->setContent($text);
		$this->setAttribute("href",$value);
	}

}

?>