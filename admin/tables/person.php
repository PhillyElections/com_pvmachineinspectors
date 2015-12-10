<?php
/**
 * $Id: admin/tables/person.php $
 * $LastChangedBy: Matt Murphy $
 * Campaign Finance Reports - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

defined('_JEXEC') or die('Restricted access');
require_once __DIR__ . DS . "pvtable.php";

/**
 * @package Philadelphia.Votes
 */

class TablePerson extends Table {
    public $id;
    public $current_party_id;
    public $image;
    public $prefix;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix;
    public $gender;
    public $marital_status;
    public $bio;
    public $published;
    public $checked_out;
    public $checked_out_time;
    public $created;
    public $updated;

    public function __construct(&$_db) {
        parent::__construct('#__pv_persons', 'id', $_db);
    }
}
