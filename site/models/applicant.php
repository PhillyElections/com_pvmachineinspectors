<?php
/**
 * Pvmachineinspectors applicant model
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Applicant Model.
 *
 * @since       1.5
 */
class PvmachineinspectorsModelApplicant extends JModel
{

    /**
     * Method to store a record
     *
     * @access    public
     * @return    boolean    True on success
     */
    public function store()
    {
        jimport('pvcombo.PVCombo');
        $row = &$this->getTable();

        $dateNow = JFactory::getDate();

        $data = JRequest::get('post');

        foreach ($data as $key => $value) {
            $data[$key] = JString::trim($value);
        }

        $data['phone']    = $data['phone'] ? preg_replace('/^1|\D/', "", $data['phone']) : '';
        $data['prefix']   = $data['prefix'] ? PVCombo::get('prefix', $data['prefix']) : '';
        $data['suffix']   = $data['suffix'] ? PVCombo::get('suffix', $data['suffix']) : '';
        $data['email']    = $data['email'] ? JString::strtolower($data['email']) : '';
        $data['postcode'] = $data['postcode'] ? JString::substr($data['postcode'], 0, 5) : '';
        $data['created']  = $dateNow->toMySQL();

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
        dd($row, $data);
        // Store the web link table to the database
        if (!$row->store()) {
            $this->setError($row->getErrorMsg());
            return false;
        }

        return true;
    }
}
