<?php
/**
 * $Id: admin/tables/inspector_applicant.php $
 * $LastChangedBy: Matt Murphy $
 * Campaign Finance Reports - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

defined('_JEXEC') or die('Restricted access');

/**
 * @package Philadelphia.Votes
 */

class TableApplicant extends JTable {
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

	public function __construct(&$_db) {
		parent::__construct('#__pv_inspector_applicants', 'id', $_db);
	}

	/**
	 * override parent::check
	 *
	 * @return boolean
	 */
	public function check() {
		// we need a first_name
		if (!JString::trim($this->first_name)) {
			$this->setError('First name is required.');
		}

		// we need a last_name
		if (!JString::trim($this->last_name)) {
			$this->setError('Last name is required.');
		}

		// we need an address1
		if (!JString::trim($this->address1)) {
			$this->setError('A street address is required.');
		}

		// we need a city
		if (!JString::trim($this->city)) {
			$this->setError('A city is required.');
		}

		// we need a 2-digit region
		if (JString::strlen(trim($this->region)) !== 2) {
			$this->setError('A state is required.');
		}

		// we need a 5 numeric digits starting from the left in out postcode
		if (!is_numeric(JString::trim($this->postcode))) {
			$this->setError('A valid zipcode is required.');
		}

		// if we have an email, we need a valid email
		if (JString::trim($this->email) && !filter_var(JString::trim($this->email), FILTER_VALIDATE_EMAIL)) {
			$this->setError(JString::trim($this->email).' is not a valid email.');
		}

		// if we have a phone we need a valid phone
		// reject phone numbers with letters in them
		if (!is_numeric(JString::trim($this->phone))) {
			$this->setError('Please supply a phone using numbers only.');
		}
		// Phone numbers may be given with the leading '1' or not
		if (JString::strlen(preg_replace('/^1|\D/', "", JString::trim($this->phone))) !== 10) {
			$this->setError('Your phone number doesn\'t seem to be the normal length (10 digits). Please reenter.');
		}

		if (count($this->getErrors())) {
			return false;
		}
		return true;
	}
}
