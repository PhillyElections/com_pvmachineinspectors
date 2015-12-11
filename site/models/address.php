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
    public $_tables = array();

    public function __construct() {
        $this->_tables->address = $this->getTable('Address', 'PVTable');
        $this->_tables->address_xref = $this->getTable('AddressXref', 'PVTable');
        $this->_tables->division = $this->getTable('Division', 'PVTable');
        $this->_tables->table = $this->getTable('Table', 'PVTable');
        parent::__construct();
    }
    /**
     * Create a new applicant.
     *
     * @param  array    $data
     *
     * @return bool
     */
    public function create($data = array()) {

        $tableName = JString::str_ireplace('#__', $a->_db->getPrefix(), $a->getTableName());

        $t->loadFromKeyValuePairs(array('name' => $tableName));
        $tid = $t->get('id');

        $remote_array = $d->remoteLookup($data['address1']);
        $d->loadFromKeyValuePairs(array('division_id' => $remote_array['division']));
        $did = $d->get('id');
        d($remote_array, $did, $d, $data, array_merge(
            $data,
            array(
                'division_id' => $did,
                'lon' => $remote_array['lon'],
                'lat' => $remote_array['lat'],
            )
        ));
        if ($did) {
            $a->save(
                array_merge(
                    $data,
                    array(
                        'division_id' => $did,
                        'lon' => $remote_array['lon'],
                        'lat' => $remote_array['lat'],
                    )
                )
            );
        }
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

        return $did;
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
     * Update an address.
     * @param  array    $data
     * @return bool
     */
    public function update($data = array()) {
        if (!gettype($data) === 'array') {
            //set error error
            return false;
        } elseif (!sizeof($data)) {
            //set error
            return false;
        }
        $created = date('Y-m-d h:i:s');
        foreach ($data as $table => $array) {
            $activeTable = $this->getTable($table, 'PVTable');

            $activeTable->setProperties($array);
            $activeTable->store();
            d($activeTable, $array);

        }

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
