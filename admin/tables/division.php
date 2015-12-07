<?php
/**
 * $Id: site/tables/division.php $
 * $LastChangedBy: Matt Murphy $
 * Campaign Finance Reports - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

defined('_JEXEC') or die('Restricted access');

/**
 * @package Philadelphia.Votes
 */

class PVTableDivision extends JTable {
    public $id;
    public $division_id;
    public $ward;
    public $division;
    public $congressional_district;
    public $state_senate_district;
    public $state_representative_district;
    public $council_district;
    public $coordinates;
    public $published;

    public function __construct(&$_db) {
        parent::__construct('#__division', 'id', $_db);
    }

    public function remoteLookup($address1) {
        //get division data

        $url = "http://gis.phila.gov/arcgis/rest/services/ElectionGeocoder/GeocodeServer/findAddressCandidates";
        // shape,score,match_addr,house,side,predir,pretype,streetname,suftype,sufdir,city,state,zip,ref_id,blockid,division,match,addr_type
        $fields = "division";
        $params = "Street=" . urlencode($address1) . "&outFields=" . urlencode($fields) . "&f=pjson";
        try {
            $curl = curl_init($url . "?" . $params);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            $json = json_decode($response);
            d($json);
            $division = $lon = $lat = '';
            switch (sizeof($json->candidates)) {
            case 0:
                // do nothing
                break;
            case 1:
                $division = (string) $json->candidates[0]->attributes->division;
                $lon = (string) $json->candidates[0]->location->x;
                $lat = (string) $json->candidates[0]->location->y;
                break;
            default:
                // sort our candidates by score -- we want the highest score result
                uasort($json->candidates, function ($a, $b) {
                    if ($a->score == $b->score) {
                        return 0;
                    }
                    return ($a->score > $b->score) ? -1 : 1;
                });
                $division = (string) $json->candidates[0]->attributes->division;
                $lon = (string) $json->candidates[0]->location->x;
                $lat = (string) $json->candidates[0]->location->y;
                break;
            }
        } catch (Exception $e) {
            return false;
        }
        return array('division' => $division, 'lon' => $lon, 'lat' => $lat);
    }
}
