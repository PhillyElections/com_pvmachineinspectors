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
    public $message = '';

    /**
     * display - the registration form
     * @return void
     */
    public function display() {
        JRequest::setVar('view', 'register');
        JRequest::setVar('message', $this->message);
        parent::display();
    }

    /**
     * register_save - actual form-action method
     * @return void
     */
    public function register_save() {
        $db = &JFactory::getDBO();

        // call to validate save, and ditch out to form on failure
        if (!$this->validate_save()) {
            // load the form and a message
            $this->message = 'Form invalidated, sucka!';
            // load the form again
            return $this->display();
        }

        // save or fail by dumping to form
        if (!$this->save()) {
            $this->message = 'Could not save. -- replace with a JError call';
            return $this->display();
        }
        // hey, we have good data!  let's set a message for the redirect
        $this->message = "Thank you for registering to be a Machine Inspector.";

        $this->setRedirect('index.php', $this->message);
    }

    /**
     * validate_save - very basic check.  very.  basic.
     * @return boolean
     */
    public function validate_save() {
        return (JRequest::getVar('fname', null, 'post', 'word') &&
            JRequest::getVar('lname', null, 'post', 'string') &&
            JRequest::getVar('address1', null, 'post', 'string') &&
            JRequest::getVar('city', null, 'post', 'string') &&
            JRequest::getVar('region', null, 'post', 'string') &&
            JRequest::getVar('postcode', null, 'post', 'string') &&
            JRequest::getVar('email', null, 'post', 'string')
        );
    }

    /**
     * save - Save our form data
     * @return boolean
     */
    public function save() {
        jimport("combo.Combo");

        $created = date('Y-m-d h:i:s');
        $region = $suffix = $prefix = $marital = $gender = '';

        // lets get values to replace references
        if (JRequest::getVar('prefix', null, 'post', 'string')) {
            $prefix = Combo::getPrefix(JRequest::getVar('prefix', null, 'post', 'string')) ? Combo::getPrefix(JRequest::getVar('prefix', null, 'post', 'string')) : '';
            $gender = Combo::getGender($prefix);
            $marital = Combo::getMarital($prefix);
        }
        if (JRequest::getVar('suffix', null, 'post', 'string')) {
            $suffix = Combo::getSuffix(JRequest::getVar('suffix', null, 'post', 'string')) ? Combo::getSuffix(JRequest::getVar('suffix', null, 'post', 'string')) : '';
        }
        if (JRequest::getVar('region', null, 'post', 'string')) {
            $region = Combo::getUSState(JRequest::getVar('region', null, 'post', 'string')) ? Combo::getUSState(JRequest::getVar('region', null, 'post', 'string')) : '';
        }

        // load our models
        $ia = $this->getModel('applicant');
        $a = $this->getModel('address');
        $l = $this->getModel('link');

        // create applicant record and get person id (applicant = person + inspector_applicant)
        $pid = $ia->create(
            array(
                'prefix' => $prefix,
                'first_name' => JRequest::getVar('fname', null, 'post', 'string'),
                'middle_name' => JRequest::getVar('mname', null, 'post', 'string'),
                'last_name' => JRequest::getVar('lname', null, 'post', 'string'),
                'suffix' => $suffix,
                'gender' => $gender,
                'marital_status' => $marital,
                'created' => $created,
                'address1' => JRequest::getVar('address1', null, 'post', 'string'),
                'postcode' => JRequest::getVar('postcode', null, 'post', 'string'),
            )
        );

        // a returned $pid means we wrote a person
        if ($pid) {
            // save person's address
            $a->create(
                array(
                    'person_id' => $pid,
                    'address1' => JRequest::getVar('address1', null, 'post', 'string'),
                    'address2' => JRequest::getVar('address2', null, 'post', 'string'),
                    'city' => JRequest::getVar('city', null, 'post', 'string'),
                    'region' => $region,
                    'postcode' => JRequest::getVar('postcode', null, 'post', 'string'),
                    'created' => $created,
                )
            );

            // link email to person
            $l->create(
                array(
                    'person_id' => $pid['person'],
                    'type' => 'email',
                    'value' => JRequest::getVar('email', null, 'post', 'string'),
                    'created' => $created,
                )
            );
        } else {
            return false;
        }

        return true;
    }
}
