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


/**
 * This object is used to build a GAME object.
 */
use Exception;
use Presto\framework\core\ObjectBuilder;

class DivisionBuilder extends ObjectBuilder {
   
    /**
     * The fieldMap defines the table column name and the objects SETTER method
     * @var array
     */
    
    /*
     *            

          
          
     */
    var $fieldMap = array(
        "id" => "setId",
        "name" => "setName",
        "season" => "setSeasonId",
        "league_id" => "setLeagueId",
        "parent_indicator" => "setParentIndicator",
        "parent_divid" => "setParentDivisionId",
        "sort_order" => "setOrder",
        "leagueplaydivisions" => "setDivisionIdsInConferencePlay",
        "published" => "setPublished",
        "agegroup" => "setAgeGroup",
        "primarycontactid" => "setPrimaryContactId",
        "secondarycontactid" => "setSecondaryContactId",
        "properties" => "parseDatabaseObjectProperties",
        "notes" => "setNotes",
        "games" => "setNumberOfGames"
    );
    
    /**
     * This function will map an array and return a Game object.
     * {@inheritDoc}
     * @return Division;
     */
    public function build($result) {
        
        $reg = new Division();
        
        try {
            $this->map($result, $this->fieldMap,$reg);
        } catch (Exception $e) {
            throw $e;
        }
        
        return $reg;
        
    }

}

?>