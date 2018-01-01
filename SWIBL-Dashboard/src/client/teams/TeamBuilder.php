<?php 
namespace swibl\client\teams;

/**
 * This object is used to build a GAME object.
 */
use Exception;
use Presto\framework\core\ObjectBuilder;

class TeamBuilder extends ObjectBuilder {
   
    /**
     * The fieldMap defines the table column name and the objects SETTER method
     * @var array
     */

    var $fieldMap = array(
        "id" => "setId",
        "name" => "setName",
        "website_url" => "setWebsite",
        "logo" => "setLogo",
        "thumbnail" => "setThumbnail",
        "active" => "setActive",
//         "homefield" => "setHomeField",
//         "field_address" => "setFieldAddress",
//         "field_directions" => "setFieldDirections",
//         "field_latitude" => "setFieldLatitude",
//         "field_longitude" => "setFieldLongitude",
        "city" => "setCity",
        "state" => "setState",
        "coachname" => "setCoachName",
        "coachemail" => "setCoachEmail",
        "coachphone" => "setCoachPhone",
        "hits" => "setHits",
        "dateupdated" => "setLastUpdated",
        "updatedby" => "setLastUpdatedBy"
    );
    
    /**
     * This function will map an array and return a Game object.
     * {@inheritDoc}
     * 
     * @return Team;
     */
    public function build($result) {
        $reg = new Team();
        
        try {
            $this->map($result, $this->fieldMap,$reg);
        } catch (Exception $e) {
            throw $e;
        }
        return $reg;
        
    }

}

?>