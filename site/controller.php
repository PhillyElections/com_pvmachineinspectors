<?php
/**
 * Pvmachineinspectors default controller
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 * @license        GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Pvotes Machine Inspectors Controller
 */
class PvmachineinspectorsController extends JController
{
    public $_msg = array();

    /**
     * display - the registration form
     * @return void
     */
    public function display()
    {
        JRequest::setVar('view', 'register');
        JRequest::setVar('msg', $this->_msg);

        parent::display();
    }

    /**
     * Set the message on usage of $this->display();
     * @param string  $message message
     * @param boolean $append  append or new?
     */
    public function _setMessage($message, $append = true)
    {
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
    public function thanks()
    {
        JRequest::setVar('view', 'thanks');
        parent::display();
    }

    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        JRequest::checkToken() or jexit('Invalid Token');

        $model = $this->getModel('applicant');

        // save or fail by dumping to form
        if ($model->store()) {
            $msg = JText::_('Saved!');
        } else {
            // let's grab all those errors and make them available to the view
            foreach ($model->getErrors() as $msg) {
                $this->_setMessage($msg);
            }
            $this->display();
            return;
        }

        // hey, we have good data, and it's been saved  let's say thanks!
        return $this->thanks();
    }
}
