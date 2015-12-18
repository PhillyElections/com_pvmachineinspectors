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

require_once __DIR__ . DS . "pvmodel.php";

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
     * @param  array    $data
     * @return bool
     */
    public function create($data = array()) {
        $a = $this->getTable('Address', 'PVTable');
        $ax = $this->getTable('AddressXref', 'PVTable');
        $t = $this->getTable('Table', 'PVTable');

        if (!$a->save($data)) {
            return false;
        }
        $a->publish();
        $aid = $a->get('id');

        $ax->save(
            array_merge(
                $data,
                array(
                    'address_id' => $aid,
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
     * Update an address. FINISH ME
     * @param  array    $data
     * @return bool
     */
    public function update($data = array()) {
        $updated = date('Y-m-d h:i:s');
        foreach ($data as $table => $array) {
            $activeTable = $this->getTable($table, 'PVTable');
        }

        return true;
    }

    /**
     * Delete an address.
     * @param  int  $id
     * @return bool
     */
    public function delete($id = null) {
        // todo
        return true;
    }
}
