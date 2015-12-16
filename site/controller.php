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
        parent::display();
    }

    /**
     * thanks - thank you
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
        $db = &JFactory::getDBO();

        // call to validate save, and ditch out to form on failure
        if (!$this->validate_save()) {
            // load the form and a message
            $this->setRedirect('index.php?option=com_pvmachineinspectors', $this->message);
            // load the form again
            return $this->redirect();
        }

        // save or fail by dumping to form
        if (!$this->save()) {
            $this->setError("Unable to save this form.");
            return $this->display();
        }

        // hey, we have good data, and it's been saved  let's say thanks!
        $this->setRedirect('index.php?option=com_pvmachineinspectors&task=thanks');
        $this->redirect();
    }

    /**
     * validate_save - very basic check.  very.  basic.
     * @return boolean
     */
    public function validate_save() {
        //
        $invalid = 0;
        $application = &JFactory::getApplication();

        // we need a fname
        if (!JRequest::getVar('fname', null, 'post', 'word')) {
            $invalid++;
            $application->enqueueMessage('First name is required.');
        }

        // we need a lname
        if (!JRequest::getVar('lname', null, 'post', 'word')) {
            $invalid++;
            $application->enqueueMessage('Last name is required.');
        }

        // we need an address1
        if (!JRequest::getVar('address1', null, 'post')) {
            $invalid++;
            $application->enqueueMessage('A street address is required.');
        }

        // we need a city
        if (!JRequest::getVar('city', null, 'post', 'word')) {
            $invalid++;
            $application->enqueueMessage('A city is required.');
        }

        // we need a 2-digit region
        if (!(JString::strlen(JRequest::getVar('region', null, 'post', 'word')) === 2)) {
            $invalid++;
            $application->enqueueMessage('A state is required.');
        }

        // we need a 5 numeric digits starting from the left in out postcode
        if (!filter_var(JRequest::getVar('postcode', null, 'post'), FILTER_VALIDATE_INT)) {
            $invalid++;
            $application->enqueueMessage('A valid zipcode is required.');
        }

        // if we have an email, we need a valid email
        if (JRequest::getVar('email', null, 'post') && !filter_var(JRequest::getVar('email', null, 'post'), FILTER_VALIDATE_EMAIL)) {
            $invalid++;
            $application->enqueueMessage(JRequest::getVar('email', null, 'post') . ' is not a valid email.');
        }

        // if we have a phone we need a valid phone
        if (JRequest::getVar('phone', null, 'post')) {
            // reject phone numbers with letters in them
            if (JString::strlen(JRequest::getVar('phone', null, 'post', 'word'))) {
                $invalid++;
                $application->enqueueMessage('Please write your phone number using numbers only.');
            }
            // Phone numbers may be given with the leading '1' or not
            if (in_array(JString::strlen(filter_var(JRequest::getVar('phone', null, 'post', 'int'), FILTER_VALIDATE_INT)), array(10, 11))) {
                $invalid++;
                $application->enqueueMessage('Your phone number doesn\'t seem to be the normal length (10 numbers). Please reenter.');
            }
        }

        // we must have either phone or email for ease of contact
        if (!JRequest::getVar('phone', null, 'post') && !JRequest::getVar('email', null, 'post')) {
            d('no ');
            $invalid++;
            $application->enqueueMessage('Either email or phone would help us to contact you more easily.  Please supply one or both.');
        }
        dd(
            'phone default',
            JRequest::getVar('phone', null, 'post'),
            'phone word',
            JRequest::getVar('phone', null, 'post', 'word'),
            'phone integer',
            JRequest::getVar('phone', null, 'post', 'int'),
            'phone sanitize integer',
            filter_var(filter_var(JRequest::getVar('phone', null, 'post'), FILTER_SANITIZE_NUMBER_FLOAT), FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW),
            'phone preg_replace',
            preg_replace("/[^0-9,.]/", "", JRequest::getVar('phone', null, 'post')), 
            filter_var(JRequest::getVar('postcode', null, 'post'), FILTER_VALIDATE_INT)
        );
        return !$invalid;
    }

    /**
     * save - Save our form data
     * @return boolean
     */
    public function save() {
        jimport("pvcombo.PVCombo");

        $created = date('Y-m-d h:i:s');
        $region = $suffix = $prefix = $marital = $gender = '';

        // lets get values to replace references
        if (JRequest::getVar('prefix', null, 'post', 'string')) {
            $prefix = PVCombo::get('prefix', JRequest::getVar('prefix', null, 'post', 'string')) ? PVCombo::get('prefix', JRequest::getVar('prefix', null, 'post', 'string')) : '';
            $gender = PVCombo::get('gender', $prefix);
            $marital = PVCombo::get('marital', $prefix);
        }
        if (JRequest::getVar('suffix', null, 'post', 'string')) {
            $suffix = PVCombo::get('suffix', JRequest::getVar('suffix', null, 'post', 'string')) ? PVCombo::get('suffix', JRequest::getVar('suffix', null, 'post', 'string')) : '';
        }
        if (JRequest::getVar('region', null, 'post', 'string')) {
            $region = PVCombo::get('state ', JRequest::getVar('region', null, 'post', 'string')) ? PVCombo::get('state ', JRequest::getVar('region', null, 'post', 'string')) : '';
        }
        if (JRequest::getVar('email', null, 'post', 'string')) {
            $email = filter_var(JRequest::getVar('email', null, 'post', 'string');
        }
        if (JRequest::getVar('phone', null, 'post')) {
            $phone = preg_replace("/[^0-9,.]/", "", JRequest::getVar('phone', null, 'post'));
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
            if ($email) {
                $l->create(
                    array(
                        'person_id' => $pid['person'],
                        'type' => 'email',
                        'value' => $email,
                        'created' => $created,
                    )
                );
            }

            // link phone to person
            if ($phone) {
                $l->create(
                    array(
                        'person_id' => $pid['person'],
                        'type' => 'phone',
                        'value' => $phone,
                        'created' => $created,
                    )
                );
            }

        } else {
            // No pid, no write...
            return false;
        }

        return true;
    }
}
