<?php
/**
 * $Id: site/models/ward.php $
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
class PvmachineinspectorsModelWard extends JModel
{
    /**
     * Registry namespace prefix
     *
     * @var     string
     */
    var $_namespace = 'com_pvmachineinspectors.ward.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the list of wards
     *
     * @since   1.5
     * @param   string  E-mail address
     * @return  bool    True on success/false on failure
     */
    public function getWards()
    {

        $db = &JFactory::getDBO();
        $db->setQuery('SELECT DISTINCT `ward` FROM `#__divisions` ORDER BY left(`division_id`, 2) ASC');

        // Get the username
        if (!($wards = $db->loadObjectList())) {
            $this->setError(JText::_('Wards query failed'));
            return false;
        }

        return $wards;
    }
}
