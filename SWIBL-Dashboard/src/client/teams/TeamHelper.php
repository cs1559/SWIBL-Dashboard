<?php
namespace swibl\client\teams;

/**
 * 
 * @author Admin
 *
 */
class TeamHelper {
    
    /**
     * This method will map/bind an individual item returned by the REST API to the Team object.
     * 
     * @param array $result
     * @return 
     */
    public static function bind($result) {
        $builder = new TeamBuilder();
        return $builder->build($result);
    }
    
       
    /**
     * This method will take an array of JSON objects returned from a query and binds each JSON record to a Team object.  The method
     * will return an array of Team objects.
     * 
     * @param array $inArray
     * @return array[]
     */
    public static function bindArray($inArray) {
        if (!is_array($inArray)) {
            throw new \Exception("Input value is not an array");
        }
        $returnArray = array();
        
        foreach ($inArray as $item) {
            $game = TeamHelper::bind($item);
            $returnArray[] = $game;
        }
        return $returnArray;
    }


}