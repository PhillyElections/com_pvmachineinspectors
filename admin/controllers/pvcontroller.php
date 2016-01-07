<?php
/**
 * $Id: site/controller.php $
 * $LastChangedDate: 2015-07-31 $
 * $LastChangedBy: Matt Murphy $
 * Election Officials - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Pvotes Machine Inspectors Controller
 */
class PVController extends JController {
    public $_msg = array();

    /**
     * Set the message on usage of $this->display();
     * @param string  $message message
     * @param boolean $append  append or new?
     */
    public function _setMessage($message, $append = true) {
        if (!$append) {
            $this->_msg = array($message);
        } else {
            array_push($this->_msg, $message);
        }
    }
}
