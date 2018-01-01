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

use Exception;
use Presto\framework\database\Database;
use Presto\framework\database\BaseDAO;
use Presto\framework\exception\InvalidArgumentException;
use swibl\client\exception\ClientException;


class DivisionAPI extends BaseDAO {
	
	static function getInstance(Database $db) {
		static $instance;
		if (!is_object( $instance )) {
			$instance = new DivisionAPI();
		}
		$instance->setDatabase($db);
		$instance->setTableName("swibl_v1.joom_jleague_division");
		return $instance;
	}		
	

	function getDivision($id) {
	    try {
	        $div = self::findById($id);
	        return $div;
	    }
	    catch (Exception $e) {
	        echo $e->getMessage();
	       throw new ClientException($e);
	    }
	}
	    
	/**
	 * This function returns an array of DIVISION Objects based on the season.  The return array excludes 
	 * any PARENT division.
	 * 
	 * @param int $season
	 * @throws InvalidArgumentException
	 * @throws Exception
	 * @return array
	 */
	function getDivisionsForSeason($season) {
	    if (!is_numeric($season)) {
	        throw new InvalidArgumentException("Invalid Season ID - getDivisionsForSeason");
	    }
	    $query = "select * from " . $this->getTableName() . " where season  = " . $season . " and parent_indicator <> 1 ORDER BY season, sort_order ";
	    $db = $this->getDatabase();
	    $db->setQuery($query);
	    try {
	        $results = $db->loadObjectList();
	        $object = DivisionHelper::bindArray($results);
	    } catch (\Exception $e) {
	        throw $e;
	    }
	    return $object;
	}
	
	/**
	 * 
	 * This function will insert a row into the DIVISION table.
	 *
	 * @param JLDivision
	 * @return boolean
	 */
   	function insert(Division $obj) {
		$otherdivs = $this->reformatOtherDivisions($obj);
		$query = 'INSERT INTO " . $this->getTableName() . " (id, name, season, league_id,parent_indicator, parent_divid, sort_order, properties,agegroup,primarycontactid,secondarycontactid,notes,games,published) '
			. ' VALUES (0,'
			. '"' . $obj->getName() . '",' 
			. '"' . $obj->getSeasonId() . '",'
			. '"' . $obj->getLeagueId(). '",'
			. '"' . $obj->isParent(). '",'
			. '"' . $obj->getParentDivisionId(). '",'
			. '"' . $obj->getOrder() . '",'
			. '"' . $obj->getFormattedProperties() . '",'									
			. '"' . $obj->getAgeGroup() . '",'
			. '"' . $obj->getPrimaryContactId() . '",'									
			. '"' . $obj->getSecondaryContactId() . '",'
			. '"' . $obj->getNotes() . '",'
			. '"' . $obj->getNumberOfGames() . '",'															
			. $obj->getPublished() . ')';
		return $this->_insertRow($query);			
    }
    
    /**
     * This function will enable someone to update row in the Division table.
     *
     * @param Division $obj
     * @return boolean
     */
    function update(Division $obj) {

		$otherdivs = $this->reformatOtherDivisions($obj);

		$query = 'update " . $this->getTableName() . " set '
			. ' name = "' . $obj->getName(). '", '
			. ' season = "' . $obj->getSeasonId(). '", '
			. ' league_id = "' . $obj->getLeagueId(). '", '
			. ' parent_indicator = "' . $obj->isParent(). '", '
			. ' parent_divid = "' . $obj->getParentDivisionId(). '", '										
			. ' sort_order = "' . $obj->getOrder(). '", '			
			. ' properties = "' . $obj->getFormattedProperties(). '", '
			. ' agegroup = "' . $obj->getAgeGroup(). '", '			
			. ' primarycontactid = "' . $obj->getPrimaryContactId(). '", '			
			. ' secondarycontactid = "' . $obj->getSecondaryContactId(). '", '	
			. ' leagueplaydivisions = "' . $otherdivs . '", '		
			. ' notes = "' . $obj->getNotes() . '", '
			. ' games = "' . $obj->getNumberOfGames() . '", '							
			. ' published = ' . $obj->getPublished()
			. ' where id = ' . $obj->getId();
		return $this->_updateRow($query);		
    }

    /**
     * This function will reformat the array of other divisions into a comma seperated
     * list.  The value is stored in a 1,3,5 type format.
     *
     * @param array $obj
     * @return string
     */
    private function reformatOtherDivisions($obj) {
    	$otherdivs = $obj->getOtherDivisionsInConferencePlay();
    	$temparray = array();
    	foreach ($otherdivs as $div) {
    		$temparray[] = $div->getId();
    	}
		$otherdivs = implode(",",$temparray);
		return $otherdivs;    	
    }
    /*
	
    function getTotalGamesForSeason($id) {
    	$iid = (int) $id;
    	$query = 'SELECT count(*) as total_games FROM #__jleague_scores WHERE gamestatus = 'C' and season = ' . $iid;
    	$rows = $this->_execute($query);
    	if (is_array($rows)) {
    		return $rows[0]->total_games;
    	}
    	return 0;
    }
        
    function getTotalLeagueGamesForSeason($id) {
    	$iid = (int) $id;
    	$query = 'SELECT count(*) as total_games FROM #__jleague_scores WHERE conference_game = "Y" and gamestatus = 'C' and season = ' . $iid;
    	$rows = $this->_execute($query);
    	if (is_array($rows)) {
    		return $rows[0]->total_games;
    	}
    	return 0;
    }
        
    function getTotalTeamsForSeason($id) {
    	$iid = (int) $id;
    	$query = 'SELECT distinct team_id FROM #__jleague_divmap WHERE season = ' . $iid;
    	$rows = $this->_execute($query); 
    	if (is_array($rows)) {
    		return count($rows);
    	}
    	return 0;
    }    
*/

    /**
     * This function will return an array of Division objects for the current season excluding
     * the division that is passed as an argument.
     *
     * @param int $season
     * @param int $div
     * @return array
     */
    function getOtherDivisions($season,$div) {
		$sid = (int) $season;
		$did = (int) $div;
		$query = "select * from " . $this->getTableName() . " where season = " . $season . " and id <> " . $div . " order by sort_order, agegroup, name";
// 		return parent::_getRows($query);    	
    }
    
    /**
     * This function will return an array of division objects that are within a given age group (or groups).
     *
     * @param int $season
     * @param array $agegroups
     * @return array
     */
    function getDivisionsWithinAgeGroup($season, array $agegroups = null) {
    	if ($agegroups == null) {
    		$query = "select * from " . $this->getTableName() . " where season = " . $season . " order by sort_order, agegroup, name";
    	} else {
    		$groups = implode(",", $agegroups);
    	   	$query = "select * from " . $this->getTableName() . " where season = " . $season . " and agegroup in (" . $groups . ")  order by sort_order, agegroup, name";
    	}
// 		return parent::_getRows($query);    	
    	
    }
    
    /**
     * This function will return a list of contact information for teams. 
     *
     * @param int $divid
     * @return array
     */
    function getTeamConactsWithinDivision($divid) {
    	$query = "select sort_order,teamname, division_id, divname, teamid, name, email, phone, role, primarycontact, src
				from
				(
					SELECT teamid as teamid, t.name as teamname, dm.division_id, d.name as divname, d.sort_order, tc.name, tc.email, tc.phone, role, primarycontact, 'contacts' as src  
						from #__jleague_teamcontacts as tc, #__jleague_divmap as dm, #__jleague_division as d, #__jleague_teams t
					where tc.teamid = dm.team_id
    					and tc.role <> 'All-Star Contact'
						and dm.division_id = " . $divid . "
						and dm.division_id = d.id
						and dm.team_id = t.id
						and dm.published = 1
					UNION
					SELECT t.id as teamid, t.name as teamname, dm.division_id,  d.name as divname, d.sort_order, coachname as name, coachemail as email, coachphone as phone, 'coach' as role, 0 as primarycontact, 'teams' as src 
						from #__jleague_teams as t, #__jleague_divmap as dm, #__jleague_division as d
					where  dm.division_id = d.id
					    and dm.team_id = t.id
						and dm.published = 1
						and dm.division_id = " . $divid . "
						  and concat_ws('-',t.id,coachemail) not in (
							select concat_ws('-',teamid,email) from #__jleague_teamcontacts
						)				
				) as tmp1
				where length(email)>0
				and LOCATE(';', email) <= 0
				and LOCATE('@', email) > 0
				and LOCATE(' or ', email) <= 0
				and LOCATE('/', email) <= 0
				order by sort_order, divname, teamname, primarycontact desc";
//     	return parent::_execute($query);
    }
    
	/**
	 * This will map the the database row to the Division Object
	 *
	 * @param array $row
	 * @return Division
	 */	
	function loadObject($row) {
	
		$obj = new Division();
		$obj->setId($row->id);
		$obj->setName($row->name);
		$obj->setSeasonId($row->season);
		$obj->setLeagueId($row->league_id);
		$obj->setParentIndicator($row->parent_indicator);
		$obj->setParentDivisionId($row->parent_divid);
		$obj->setOrder($row->sort_order);
		$obj->setPublished($row->published);
		$obj->setAgeGroup($row->agegroup);
		$obj->setPrimaryContactId($row->primarycontactid);
		$obj->setSecondaryContactId($row->secondarycontactid);
		$obj->setNotes($row->notes);		
		$obj->setNumberOfGames($row->games);
		
		/*
		 *   need to revisit this. 
		 * 
		 * 
		
		$ldao = &JLLeagueDAO::getInstance();
		$sdao = &JLSeasonDAO::getInstance();


		try {
			if ($row->season > 0) {
				$season = $sdao->findById($row->season);
				$obj->setSeason($season);
			}
			if ($row->league_id > 0) {
				$league = $ldao->findById($row->league_id);
				$obj->setLeague($league);
			}
		} catch (Exception $e) {
			throw $e;
		}
*/


		$obj->parseDatabaseObjectProperties($row->properties);
				
// 		$proparray = split("\n",$row->properties);
// 		for ($y=0; $y<(sizeof($proparray)); $y++) {
// 			$prop = split("=",$proparray[$y]);
// 			//TODO:  Revisit this.  This is a quick work around.  need to investigate origin of
// 			// why this $prop[1] would generate an undefined offset on the $prop array
// 			if (key_exists(1,$prop)) {
// 				$obj->addProperty($prop[0],$prop[1]);
// 			}
// 		}
		
		/*
		$totaldivs = $this->getTotalDivisionsForSeason($row->id);
		$totalteams = $this->getTotalTeamsForSeason($row->id);
		$totalgames = $this->getTotalGamesForSeason($row->id);
		$totalleaguegames = $this->getTotalLeagueGamesForSeason($row->id);
		
		$obj->setTotalDivisions($totaldivs);
		$obj->setTotalTeams($totalteams);
		$obj->setTotalGames($totalgames);
		$obj->setTotalLeagueGames($totalleaguegames);
		*/
		

		$obj->setDivisionIdsInConferencePlay($row->leagueplaydivisions);
//		if (!empty($row->leagueplaydivisions)) {
//			$otherdivkeys = explode(",",$row->leagueplaydivisions);
//			foreach ($otherdivkeys as $key => $value) {
//				$division = $ddao->findById($value);
//				$obj->addDivisionInConferencePlay($division);	
//			}
//		}		
		return $obj;
	}
	

}
