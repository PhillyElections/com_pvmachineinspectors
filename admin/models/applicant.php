<?php
/**
 * Pvmachineinspector Model for Pvmachineinspectors Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * Pvmachineinspector Pvmachineinspector Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class PvmachineinspectorsModelApplicant extends JModel {
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access    public
	 * @return    void
	 */
	public function __construct() {
		parent::__construct();

		$array = JRequest::getVar('cid', 0, '', 'array');
		$id    = JRequest::getInt('id');
		if ($id) {
			// in case we're updating and check() failed
			$this->setId((int) $id);
		} else {
			$this->setId((int) $array[0]);
		}
	}

	/**
	 * Method to set the applicant identifier
	 *
	 * @access    public
	 * @param    int applicant identifier
	 * @return    void
	 */
	public function setId($id) {
		// Set id and wipe data
		$this->_id   = $id;
		$this->_data = null;
	}

	/**
	 * Method to get an applicant
	 *
	 * @return object with data
	 */
	public function &getData() {
		// Load the data
		if (empty($this->_data)) {
			$query = ' SELECT * FROM #__pv_inspector_applicants '.
			'  WHERE id = '.$this->_db->quote($this->_id);
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data           = new stdClass();
			$this->_data->id       = 0;
			$this->_data->greeting = null;
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access    public
	 * @return    boolean    True on success
	 */
	public function store() {
		jimport('pvcombo.PVCombo');
		$row = &$this->getTable();

		$data = JRequest::get('post');

		$data['phone']    = $data['phone']?preg_replace('/^1|\D/', "", $data['phone']):'';
		$data['prefix']   = $data['prefix']?PVCombo::get('prefix', $data['prefix']):'';
		$data['suffix']   = $data['suffix']?PVCombo::get('suffix', $data['suffix']):'';
		$data['email']    = $data['email']?JString::strtolower($data['email']):'';
		$data['postcode'] = $data['postcode']?JString::substr(trim($data['postcode']), 0, 5):'';

		if (!$data['division_id']) {
			$division = $this->getTable('Division');

			$data['division_id'] = $division->getRemoteDivision($data);
		}

		// Bind the form fields to the Pvmachineinspector table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the Pvmachineinspector record is valid
		if (!$row->check()) {
			//$this->setError($this->_db->getErrorMsg());
			foreach ($row->getErrors() as $msg) {
				$this->setError($msg);
			}
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError($row->getErrorMsg());
			return false;
		}

		return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access    public
	 * @return    boolean    True on success
	 */
	public function delete() {
		$cids = JRequest::getVar('cid', array(0), 'post', 'array');

		$row = &$this->getTable();

		if (count($cids)) {
			foreach ($cids as $cid) {
				if (!$row->delete($cid)) {
					$this->setError($row->getErrorMsg());
					return false;
				}
			}
		}
		return true;
	}
}
