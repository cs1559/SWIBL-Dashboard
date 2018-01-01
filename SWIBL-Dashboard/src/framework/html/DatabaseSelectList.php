<?php
namespace Presto\framework\html;

class DatabaseSelectList extends SelectList {
	
	var $_valcol = null;	// name of the column to use in the value of the select option
	var $_textcol = null; 	// name of the column to use in the text of the select option
	var $_dbconn = null;	// database connection
	var $_sql = null;		// SQL statement
	var $_loaded = false;
	
	/**
	 * This is the constructor.
	 *
	 * @param String $name
	 */
	public function __construct($db, $sql, $valcol, $textcol, $name, $default_value = null) {
		$this->_valcol = $valcol;
		$this->_textcol = $textcol;
		$this->_dbconn = $db;
		$this->_sql = $sql;
		parent::__construct($name, $default_value);
	}
	
	/**
	 * Executes the SQL and build the select lists options.
	 */
	private function execute() {
		/* Test the loaded attribute to see if this object was in cache */
		if (!$this->_loaded) {
			$val = $this->_valcol;
			$txt = $this->_textcol;
			$db = $this->_dbconn;
			$db->setQuery($this->_sql);
			$rows = $db->loadObjectList();
			foreach ($rows as $row) {
				$this->addOption($row->$val, $row->$txt);
			}
			$this->_loaded = true;
		}
	}
	
	/**
	 * Override the base class toHtml function.   this function will execute the SQL and build the options before
	 * returning the HTML.
	 * 
	 * @see fsSelectList::toHtml()
	 */
	public function toHtml() {
		$this->execute();
		return parent::toHtml();
	}
	
}

?>