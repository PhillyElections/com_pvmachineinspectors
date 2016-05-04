<?php
/**
 * inspector_applicant table for Pvmachineinspectors Component
 *
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

defined('_JEXEC') or die('Restricted access');

/**
 * @package Philadelphia.Votes
 */

class TableApplicant extends JTable
{
    public $id;
    public $division_id;
    public $prefix;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix;
    public $address1;
    public $address2;
    public $address3;
    public $city;
    public $region;
    public $postcode;
    public $email;
    public $phone;
    public $published;
    public $checked_out;
    public $checked_out_time;
    public $created;
    public $updated;

    public function __construct(&$_db)
    {
        parent::__construct('#__pv_inspector_applicants', 'id', $_db);
    }

    /**
     * override parent::check
     *
     * @return boolean
     */
    public function check()
    {
        $error = array();
        // we need a first_name
        if (!JString::trim($this->first_name)) {
            $error[] = JText::_('VALIDATION FIRSTNAME REQUIRED');
            //$this->setError(JText::_('VALIDATION FIRSTNAME REQUIRED'));

        }

        // we need a last_name
        if (!JString::trim($this->last_name)) {
            $error[] = JText::_('VALIDATION LASTNAME REQUIRED');
            // $this->setError(JText::_('VALIDATION LASTNAME REQUIRED'));
        }

        // we need an address1
        if (!JString::trim($this->address1)) {
            $error[] = JText::_('VALIDATION STREET ADDRESS REQUIRED');
            // $this->setError(JText::_('VALIDATION STREET ADDRESS REQUIRED'));
        }

        // we need a city
        if (!JString::trim($this->city)) {
            $error[] = JText::_('VALIDATION CITY REQUIRED');
            // $this->setError(JText::_('VALIDATION CITY REQUIRED'));
        }

        // we need a 2-digit region
        if (JString::strlen(trim($this->region)) !== 2) {
            $error[] = JText::_('VALIDATION STATE REQUIRED');
            // $this->setError(JText::_('VALIDATION STATE REQUIRED'));
        }

        // we need a 5 numeric digits starting from the left in out postcode
        if (!is_numeric(JString::trim($this->postcode))) {
            $error[] = JText::_('VALIDATION ZIPCODE REQUIRED');
            // $this->setError(JText::_('VALIDATION ZIPCODE REQUIRED'));
        }

        // if we have an email, we need a valid email
        if (JString::trim($this->email) && !filter_var(JString::trim($this->email), FILTER_VALIDATE_EMAIL)) {
            $error[] = JString::trim($this->email) . JText::_('VALIDATION EMAIL INVALID');
            // $this->setError(JString::trim($this->email) . JText::_('VALIDATION EMAIL INVALID'));
        }

        if (JString::strlen(JString::trim($this->phone))) {
            // reject phone numbers with letters in them
            if (!is_numeric(JString::trim($this->phone))) {
                $error[] = JText::_('VALIDATION PHONE NUMERIC');
                // $this->setError(JText::_('VALIDATION PHONE NUMERIC'));
            }
            // Phone numbers may be given with the leading '1' or not
            if (JString::strlen(preg_replace('/^1|\D/', "", JString::trim($this->phone))) !== 10) {
                $error[] = JText::_('VALIDATION PHONE LENGTH');
                // $this->setError(JText::_('VALIDATION PHONE LENGTH'));
            }
        } else {
            $error[] = JText::_('VALIDATION PHONE EMPTY');
            // $this->setError(JText::_('VALIDATION PHONE EMPTY'));
        }

        //if (count($this->getErrors())) {
        if (count($error)) {
            $this->setError(implode('<br>', $error));
            return false;
        }
        return true;
    }
}
