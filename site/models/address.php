<?php
/**
 * $Id: site/models/address.php $
 * $LastChangedBy: Matt Murphy $
 * Election Officials - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com.
 *
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * User Component Remind Model.
 *
 * @since        1.5
 */
class PvmachineinspectorsModelAddress extends JModel {
    /**
     * Registry namespace prefix.
     *
     * @var string
     */
    public $_namespace = 'com_pvmachineinspectors.address.';

    /**
     * Create a new applicant.
     *
     * @param  array    $data
     *
     * @return bool
     */
    public function create($data = array()) {
        $a = $this->getTable('Address', 'PVTable');
        $ax = $this->getTable('AddressXref', 'PVTable');
        $d = $this->getTable('Division', 'PVTable');
        $t = $this->getTable('Table', 'PVTable');

        $tableName = JString::str_ireplace('#__', $a->_db->getPrefix(), $a->getTableName());

        $t->loadFromKeyValuePairs(array('name' => $tableName));
        $tid = $t->get('id');
        $a->save($data);
        $aid = $a->get('id');

        $ax->save(
            array_merge(
                $data,
                array(
                    'address_id' => $aid,
                    'right_id' => $data['person_id'],
                    'right_table_id' => $tid,
                )
            )
        );

        return true;
    }

    /**
     * Read an address
     * @param  int  $id
     * @return bool
     */
    public function read($id = null) {
        // todo
        return true;
    }

    /**
     * Update an applicant.
     * @param  array    $data
     * @return bool
     */
    public function update($data = array()) {
        // todo
        return true;
    }

    /**
     * Delete an applicant.
     * @param  int  $id
     * @return bool
     */
    public function delete($id = null) {
        // todo
        return true;
    }
}
