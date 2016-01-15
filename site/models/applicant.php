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

/**
 * User Component Remind Model.
 *
 * @since       1.5
 */
class PvmachineinspectorsModelApplicant extends JModel
{
    /**
     * Create a new applicant.
     * @param  array
     * @return integer $id of created person for link and address binding
     */
    public function create($data = array())
    {
        jimport('division.Division');

        $did = '';
        $applicant = $this->getTable();
        $division = $this->getTable('Division');

        $response = Division::lookup($data['address1']);

        if ($response->status === 'success') {
            $division->loadFromKeyValuePair(array('division_id' => $response['division']));
            $did = $division->get('id');
        }

        // save form data with division data
        if (!$applicant->save(array_merge($data, array('division_id' => $did)))) {
            return false;
        }
        // if success, publish
        $applicant->publish();
    }
}
