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
 * Applicant Controller.
 *
 * @since 1.5
 */
class PvmachineinspectorsController extends JController {
    /**
     * Display signup form.
     *
     * @since   1.5
     */
    public function display() {
        JRequest::setVar('view', 'register');
        parent::display();
    }

    /**
     * Display signup acknowledgement.
     *
     * @since   1.5
     */
    public function thanks() {
        JRequest::setVar('view', 'thanks');

        parent::display();
    }

    /**
     * Save registration and notify users and admins if required.
     */
    public function register_save() {
        $db = &JFactory::getDBO();
        d('processing the save', $_POST);

        // call to validate save, and ditch out to form on failure
        if (!$this->validate_save()) {
            // load the form and a message
            $message = 'Form invalidated, sucka!';
            // load the form again
            return $this->display();
        }

        if (!$this->save()) {
            $message = 'Could not save. -- replace with a JError call';
            return $this->display();
        }

        // hey, we have good data!  let's set a message for the redirect
        $message = "Thank you for registering to be a Machine Inspector.";

        //
        $email = JRequest::getVar('email', null, 'post', 'string');
        if ($email) {
            $message .= "<br>...And thank you for providing an email address.  <br>At your convenience please check your email for a confirmation email and click the link within to <b>verify</b> your email.";
        }
        dd('stopping before we redirect');
        $this->setRedirect('index.php', $message);
    }

    /**
     * Validation tests for length only on fname, lname, address1, city, province, postcode, email
     *
     */
    public function validate_save() {
        return (JRequest::getVar('fname', null, 'post', 'word') &&
            JRequest::getVar('lname', null, 'post', 'string') &&
            JRequest::getVar('address1', null, 'post', 'string') &&
            JRequest::getVar('city', null, 'post', 'string') &&
            JRequest::getVar('province', null, 'post', 'string') &&
            JRequest::getVar('postcode', null, 'post', 'string') &&
            JRequest::getVar('email', null, 'post', 'string')
        );
    }

    /**
     * Save the form data in the various proper locations
     */
    public function save() {
        //
        $ia = $this->getModel('applicant');
        $a = $this->getModel('address');
        $l = $this->getModel('link');
        // create applicant record and get applicant id
        $ia->create(
            array(
                'prefix' => JRequest::getVar('prefix', null, 'post', 'string'),
                'fname' => JRequest::getVar('fname', null, 'post', 'string'),
                'mname' => JRequest::getVar('mname', null, 'post', 'string'),
                'lname' => JRequest::getVar('lname', null, 'post', 'string'),
                'suffix' => JRequest::getVar('suffix', null, 'post', 'string'),
            )
        );
        // save applicant links

        // save the address
        $a->create(
            array(
                'address1' => JRequest::getVar('address1', null, 'post', 'string'),
                'address2' => JRequest::getVar('address2', null, 'post', 'string'),
                'city' => JRequest::getVar('city', null, 'post', 'string'),
                'province' => JRequest::getVar('province', null, 'post', 'string'),
                'postcode' => JRequest::getVar('postcode', null, 'post', 'string'),
            )
        );
        // bind the address to the applicant (person)

        $l->create(
            array(
                'email' => JRequest::getVar('email', null, 'post', 'string'),
            )
        );

        d($ia, $a, $l);
        return true;
    }
}
