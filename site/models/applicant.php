<?php
/**
 * $Id: site/models/person.php $
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
 * @since       1.5
 */
class PvmachineinspectorsModelApplicant extends JModel {
    /**
     * Registry namespace prefix.
     * @var string
     */
    public $_namespace = 'com_pvmachineinspectors.applicant.';

    /**
     * Create a new applicant.
     * @param  array
     * @return integer $id of created person for link and address binding
     */
    public function create($data = array()) {

        $ia = $this->getTable('InspectorApplicant', 'PVTable');
        $p = $this->getTable('Person', 'PVTable');
        $d = $this->getTable('Division', 'PVTable');
        $remote_array = $d->remoteLookup($data['address1']);
        $d->loadFromKeyValuePairs(array('division_id' => $remote_array['division']));
        $did = $d->get('id');

        $p->save($data);
        $ia->save(
            array_merge(
                $data,
                array(
                    'person_id' => $p->get('id'),
                    'division_id' => $remote_array,
                )
            )
        );

        return array('person' => $p->get('id'), 'applicant' => $ia->get('id'));
    }

    /**
     * Update an appliant.
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

            d("one", $activeTable->load($array['id']), $activeTable, $array);

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