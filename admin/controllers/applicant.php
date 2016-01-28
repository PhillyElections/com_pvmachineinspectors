<?php
/**
 * Pvmachineinspector Controller for Pvmachineinspectors Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Pvmachineinspector Pvmachineinspector Controller
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class PvmachineinspectorsControllerApplicant extends PvmachineinspectorsController
{
    /**
     * constructor (registers additional tasks to methods)
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Register Extra tasks
        $this->registerTask('add', 'edit');
        $this->registerTask('register', 'save');
        $this->registerTask('update', 'save');
    }

    /**
     * display the edit form
     * @return void
     */
    public function edit()
    {
        JRequest::setVar('view', 'applicant');

        parent::display();
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    public function save()
    {
        JRequest::checkToken() or jexit('Invalid Token');

        $model = $this->getModel('applicant');

        if ($this->validate_save($msg)) {
            if ($model->store($post)) {
                $msg = JText::_('Saved!');
            } else {
                $msg = JText::_('Error - not saved.');
            }
        }

        // Check the table in so it can be edited.... we are done with it anyway
        $link = 'index.php?option=com_pvmachineinspectors';
        $this->setRedirect($link, $msg);
    }

    /**
     * validate_save - very basic check.  very.  basic.
     * @return boolean
     */
    public function validate_save($msg)
    {
        // initialize
        $invalid = 1;
        $application = &JFactory::getApplication();
        $msg = "";

        // we need a first_name
        if (!JRequest::getVar('first_name', null, 'post', 'word')) {
            $invalid *= 2;
            $msg .= 'First name is required.';
        }

        // we need a last_name
        if (!JRequest::getVar('last_name', null, 'post', 'word')) {
            $invalid *= 3;
            $msg .= 'Last name is required.';
        }

        // we need an address1
        if (!JRequest::getVar('address1', null, 'post')) {
            $invalid *= 5;
            $msg .= 'A street address is required.';
        }

        // we need a city
        if (!JRequest::getVar('city', null, 'post', 'word')) {
            $invalid *= 7;
            $msg .= 'A city is required.';
        }

        // we need a 2-digit region
        if (!(JString::strlen(JRequest::getVar('region', null, 'post', 'word')) === 2)) {
            $invalid *= 11;
            $msg .= 'A state is required.';
        }

        // we need a 5 numeric digits starting from the left in out postcode
        if (!(filter_var(JRequest::getVar('postcode', null, 'post'), FILTER_SANITIZE_NUMBER_INT) === JRequest::getVar('postcode', null, 'post'))) {
            $invalid *= 13;
            $msg .= 'A valid zipcode is required.';
        }

        // if we have an email, we need a valid email
        if (JRequest::getVar('email', null, 'post') && !filter_var(JRequest::getVar('email', null, 'post'), FILTER_VALIDATE_EMAIL)) {
            $invalid *= 17;
            $msg .= JRequest::getVar('email', null, 'post') . ' is not a valid email.';
        }

        // if we have a phone we need a valid phone
        if (JRequest::getVar('phone', null, 'post')) {
            // reject phone numbers with letters in them
            if (JString::strlen(JRequest::getVar('phone', null, 'post', 'word'))) {
                $invalid *= 19;
                $msg .= 'Please supply a phone using numbers only.';
            }
            // Phone numbers may be given with the leading '1' or not
            if (JString::strlen(preg_replace('/^1|\D/', "", JRequest::getVar('phone', null, 'post'))) !== 10) {
                $invalid *= 23;
                $msg .= 'Your phone number doesn\'t seem to be the normal length (10 digits). Please reenter.';
            }
        }

        return !($invalid - 1);
    }

    /**
     * remove record(s)
     * @return void
     */
    public function remove()
    {
        JRequest::checkToken() or jexit('Invalid Token');

        $model = $this->getModel('applicant');
        if (!$model->delete()) {
            $msg = JText::_('Error: One or More Greetings Could not be Deleted');
        } else {
            $msg = JText::_('Greeting(s) Deleted');
        }

        $this->setRedirect('index.php?option=com_pvmachineinspectors', $msg);
    }

    /**
     * cancel editing a record
     * @return void
     */
    public function cancel()
    {

        $msg = JText::_('Operation Cancelled');
        $this->setRedirect('index.php?option=com_pvmachineinspectors', $msg);
    }
}
