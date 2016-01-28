<?php
/**
 * $Id: admin/tables/division.php $
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

class TableDivision extends JTable
{
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

    public function __construct(&$_db)
    {
        parent::__construct('#__divisions', 'id', $_db);
    }

    public function loadFromKeyValuePairs($data)
    {
        $this->reset();
        $db = &$this->getDBO();
        $sql = "SELECT * from `" . $this->_tbl . "` WHERE ";
        // make criteria out of each pair
        foreach ($data as $key => $value) {
            $sql .= "`" . $key . "`=" . $db->Quote($value) . " AND ";
        }
        // drop the final " AND"
        $sql = JString::substr($sql, 0, -4);
        $db->setQuery($sql);
        if ($result = $db->loadAssoc()) {
            return $this->bind($result);
        } else {
            $this->setError($db->getErrorMsg());
            return false;
        }
    }

    public function getRemoteDivision($data)
    {
        jimport('division.Division');

        $response = Division::lookup($data['address1']);
        if ($response['status'] === 'success') {
            $this->loadFromKeyValuePairs(array('division_id' => $response['data']['division']));
            return $this->get('id');
        }
        return null;
    }
}
