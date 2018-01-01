<?php
namespace Presto\framework\html;

class TextArea extends HtmlElement {
	
	/**
	 * Textarea Input Contructor.
	 *
	 * @param String $name
	 * @param int $rows
	 * @param int $cols
	 */
	public function __construct($name, $value, $rows=5, $cols=40) {
		$this->setTagName("textarea");
		$this->setId($name);
		$this->setName($name);
		$this->setContent($value);
		$this->setRows($rows);
		$this->setCols($cols);
	}
	
	/**
	 * This function sets the ROWS attribute for the textarea element.
	 *
	 * @param int $rows
	 */
	function setRows($rows) {
		$this->setAttribute("rows",$rows);
	}

	/**
	 * This function sets the COLS attribute for the textarea element.
	 *
	 * @param int $rows
	 */
	function setCols($cols) {
		$this->setAttribute("cols", $cols);
	}
	
}

?>