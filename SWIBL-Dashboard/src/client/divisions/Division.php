<?php
namespace swibl\client\divisions;
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


use Presto\framework\core\BaseObject;

class Division extends BaseObject  {
    
	var $id=null;
	var $name=null;
	var $league_id=null;
	var $parent_indicator=null;
	var $parent_divisonid=null;
	var $league_division=null;
	var $season_id = null;
	var $sortorder= null;
	var $published = null;
	var $league = null;
	var $season = null;
	var $age = null;
	var $primarycontactid = null;
	var $secondarycontactid = null;
	var $primarycontact = null;
	var $secondarycontact = null;
	var $divisionsinconferenceplay_raw = null;
	var $divisionsinconferenceplay = null;
	var $notes = null;
	var $games = null;
	
	function __construct() {
		parent::__construct();
		$this->divisionsinconferenceplay = array();
	}
	
	function setId($inParm) {
		$this->id = $inParm;
	}
	function getId() {
		return $this->id;
	}

	function setName($inParm) {
		$this->name = $inParm;
	}
	function getName() {
		return $this->name;
	}

	function setLeagueId($inParm) {
		$this->league_id = $inParm;
	}
	function getLeagueId() {
		return $this->league_id;
	}
	function setSeasonId($inParm) {
		$this->season_id = $inParm;
	}
	function getSeasonId() {
		return $this->season_id;
	}

	function setOrder($inParm) {
		$this->sortorder=$inParm;
	}
	function getOrder() {
		return $this->sortorder;
	}

	/**
	 * This will set the published indicator
	 *
	 * @param boolean $inParm
	 */
	function setPublished($inParm) {
		$this->published = $inParm;
	}
	
	/**
	 * This will return a boolean indicating whether or not the league is published
	 *
	 * @return boolean
	 */
	function getPublished() {
		return $this->published;
	}
	
	function setLeague( $league) {
		$this->league = $league;
	}
	function getLeague() {
		return $this->league;
	}
	
	function setSeason( $season) {
		$this->season = $season;
	}
	function getSeason() {
		return $this->season;
	}
	function setAgeGroup($age) {
		$this->age = $age;
	}
	function getAgeGroup() {
		return $this->age . "U";
	}
	function setNumberOfGames($games) {
		$this->games = $games;
	}
	/**
	 * Returns the number of games targeted to be played by each team within a 
	 * specific division.
	 *
	 * @return int
	 */
	function getNumberOfGames() {
		return $this->games;
	}
	function setPrimaryContactId($id) {
		$this->primarycontactid = $id;
	}
	function getPrimaryContactId() {
		return $this->primarycontactid;
	}
	function setSecondaryContactId($id) {
		$this->secondarycontactid = $id;
	}
	function getSecondaryContactId() {
		return $this->secondarycontactid;
	}	
// 	function setPrimaryContact(JLContact $contact) {
// 		$this->primarycontact = $contact;
// 	}
// 	function getPrimaryContact() {
// 		return $this->primarycontact;
// 	}
// 	function setSecondaryContact(JLContact $contact) {
// 		$this->secondarycontact = $contact;
// 	}
// 	function getSecondaryContact() {
// 		return $this->secondarycontact;
// 	}
	/**
	 * The value here should be a comma delimited list of divisions within conference play
	 *
	 */
	function setDivisionIdsInConferencePlay($divids) {
		$this->divisionsinconferenceplay_raw = $divids;
	}
	function getDivisionIdsInConferencePlay() {
		return $this->divisionsinconferenceplay_raw;
	}
	/**
	 * This function will add a division object to the array of divisions that fall into this divisions 
	 * conference play.
	 *
	 * @param Division $div
	 */
	function addDivisionInConferencePlay(Division $div) {
		$this->divisionsinconferenceplay[] = $div;
	}
	/**
	 * Returns an array of Division objects that are to be counted in conference play.
	 *
	 * @return array
	 */
	function getOtherDivisionsInConferencePlay() {
		return $this->divisionsinconferenceplay;
	}
	
	/**
	 * This is a helper functino that will test a particular division id to see if any secondary
	 * divisions should be included in this particular divisions "league" play.
	 *
	 * @param int $odiv
	 * @return boolean
	 */
	function includeInConferencePlay($odiv) {
		$otherdivkeys = explode(",",$this->divisionsinconferenceplay_raw);
		foreach ($otherdivkeys as $div) {
			if ($div == $odiv) {
				return true;
			}
		}
		return false;
	}

	function setNotes($inParm) {
		$this->notes = $inParm;
	}
	function getNotes() {
		return $this->notes;
	}
	
	function setParentIndicator($ind) {
		$this->parent_indicator = $ind;
	}
	function isParent(){
		return $this->parent_indicator;
	}
	function setParentDivisionId($id) {
		$this->parent_divisonid = $id;
	}
	function getParentDivisionId() {
		return $this->parent_divisonid;
	}
	
}
 
?>
