<?php
/**
 * $Id: admin/tables/link_type.php $
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

class PVTableLinkType extends JTable {
    public $id;
    public $limit;
    public $name;
    public $created;
    public $updated;

    public function __construct(&$_db) {
        parent::__construct('#__pv_link_types', 'id', $_db);
    }
}
