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
class PvmachineinspectorsController extends JController {
	public $_msg = array();

	/**
	 * display - the registration form
	 * @return void
	 */
	public function display() {
		JRequest::setVar('view', 'register');
		JRequest::setVar('msg', $this->_msg);

		parent::display();
	}

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

	/**
	 * thanks - thank you for registering!
	 * @return void
	 */
	public function thanks() {
		JRequest::setVar('view', 'thanks');
		parent::display();
	}

	/**
	 * register_save - actual form-action method
	 * @return void
	 */
	public function register_save() {
		JRequest::checkToken() or jexit('Invalid Token');

		$model = $this->getModel('applicant');

		// save or fail by dumping to form
		if ($model->store()) {
			$msg = JText::_('Saved!');
		} else {
			// let's grab all those errors and make them available to the view
			$this->display();
			return;
		}

		// hey, we have good data, and it's been saved  let's say thanks!
		return $this->thanks();
	}
}
