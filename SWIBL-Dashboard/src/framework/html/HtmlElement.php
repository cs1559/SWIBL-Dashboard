<?php
namespace Presto\framework\html;

/**
 * The HtmlElement class is the base element for generating HTML elements.
 *
 */
abstract class HtmlElement {
	
	var $startTag;
	var $tagname;
	var $endTag;
	var $content;
	var $attributes = array();
	var $lineEnd = "\12";
	var $responsive = false;
	
	/**
	 * The toHtml returns the actual HTML
	 *
	 * @return String
	 */
	function toHtml() {
		$le = $this->lineEnd;
		$html = $this->getStartTag();
		$html .= $this->getContent();
		$html .= $this->getEndTag();
		return $html . $le;
	}
	
	function setAttribute($attr, $val) {
		$this->attributes[$attr] = $val;
	}
	function setId($val) {
		if ($val != null) $this->attributes["id"] = $val;
	}
	function getId() {
		return $this->attributes["id"];
	}
	function setName($val) {
		if ($val != null) $this->attributes["name"] = $val;
	}
	function getName() {
		return $this->attributes["name"];
	}
	function setClass($val) {
		if ($val != null) $this->attributes["class"] = $val;	
	}
	/**
	 * This sets any content that exists between the start/end tags of the element.
	 *
	 * @param String $val
	 */
	function setContent($val) {
		$this->content = $val;
	}
	/**
	 * Returns the tags content.
	 *
	 * @return String
	 */
	function getContent() {
		return $this->content;
	}
	/**
	 * This sets the name of the tag (e.g. A, TEXTAREA, INPUT, etc.)
	 *
	 * @param String $tagname
	 */
	function setTagName($tagname) {
		$this->tagname = $tagname;
	}
	/**
	 * This function will return the tag name.
	 *
	 * @return String
	 */
	function getTagName() {
		return $this->tagname;
	}
	/**
	 * Generates the HTML elements END TAG.  If the content is null, then the tag should be closed in the 
	 * start tag.
	 *
	 * @return String
	 */
	function getStartTag() {
		$tag = "<";
		$tag .= $this->getTagName();
		foreach( $this->attributes as $key => $value){
			$tag .= " " . $key . "=\"" . $value . "\"";
			
		}
		if ($this->content == null) {
			$tag .= "/>";
		} else {
			$tag .= ">";
		}
		return $tag;
	}

	/**
	 * Generates the HTML elements END TAG.  If the content is null, then this should return null
	 *
	 * @return String
	 */
	function getEndTag() {
		if ($this->content != null) {
			return "</" . $this->getTagName() . ">";
		}
	}
	
	function __toString() {
		return self::toHtml();
	}
	
	function setResponsive($val) {
	    if (!is_bool($var)) {
	        $this->response = false;
	    }
		$this->responsive = $val;
	}
	function isResponsive() {
		return $this->responsive;
	}
}
?>