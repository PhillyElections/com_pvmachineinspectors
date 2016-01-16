<?php
/**
 * Pvmachineinspectors Model for Pvmachineinspectors Component
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
 * Pvmachineinspector Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class PvmachineinspectorsModelApplicants extends JModel
{
    /**
     * Pvmachineinspectors data array
     *
     * @var array
     */
    public $_data;

    /**
     * Returns the query
     * @return string The query to be used to retrieve the rows from the database
     */
    public function _buildQuery()
    {
        $query = ' SELECT ia.*, d.ward, d.division '
            . ' FROM #__pv_inspector_applicants ia left join #__divisions d on ia.division_id=d.id '
        ;

        return $query;
    }

    /**
     * Retrieves the Pvmachineinspector data
     * @return array Array of objects containing the data from the database
     */
    public function getData()
    {
        // Lets load the data if it doesn't already exist
        if (empty($this->_data)) {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query);
        }

        return $this->_data;
    }
}
