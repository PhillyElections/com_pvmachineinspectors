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
}
