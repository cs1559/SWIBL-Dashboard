<?php
namespace Presto\framework\html;

class SelectOption extends HtmlElement {
	
	var $value = null;
	var $text = null;
	var $selected = false;
	var $disabled = false;
	
	/**
	 * This is the constructor.
	 *
	 * @param String $name
	 */
	public function __construct($value, $text, $selected = false, $disabled = false) {
		$this->setTagName("option");
		$this->value = $value;
		$this->text = $text;
		$this->disabled = $disabled;
		$this->selected = $selected;
	}
	
	static function create($value, $text, $selected = false, $disabled = false) {
		return new SelectOption($value, $text, $selected, $disabled);
	}
	
	function getValue() {
		return $this->value;
	}
	function getText() {
		return $this->text;
	}
	function isSelected() {
		return $this->selected;
	}
	function isDisabled() {
		return $this->disabled;
	}
	function setSelected($bool) {
		$this->selected = $bool;
	}
	function setDisabled($bool) {
		$this->disabled = $bool;
	}
	
	public function toHtml() {
		$opt = "<option value=\"" . $this->getValue() ."\""; 
		if ($this->isSelected()) {
			$opt .= " selected=\"selected\" ";
		}
		if ($this->isDisabled()) {
			$opt .= " disabled=\"disabled\" ";
		}				
		$opt .= ">" . $this->getText() . "</option>";			
		return $opt;		
	}
	
}

?>