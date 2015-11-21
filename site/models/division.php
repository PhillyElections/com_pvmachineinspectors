<?php
/**
 * $Id: site/models/division.php $
 * $LastChangedDate: 2015-07-31 $
 * $LastChangedBy: Matt Murphy $
 * Election Officials - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * User Component Remind Model
 *
 * @package         Joomla
 * @subpackage  User
 * @since       1.5
 */
class PvmachineinspectorsModelDivision extends JModel
{
    /**
     * Registry namespace prefix
     *
     * @var     string
     */
    var $_namespace = 'com_pvmachineinspectors.division.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the list of divisions
     *
     * @since   1.5
     * @param   string  E-mail address
     * @return  bool    True on success/false on failure
     */
    function getDivisions()
    {

        $db = &JFactory::getDBO();
        $db->setQuery('SELECT * FROM `#__divisions` ORDER BY `division_id` ASC');

        // Get the username
        if (!($divisions = $db->loadResult())) {
            $this->setError(JText::_('Divisions query failed'));
            return false;
        }

        return $divisions;
    }
}
