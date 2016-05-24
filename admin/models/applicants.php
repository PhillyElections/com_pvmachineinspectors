<?php
/**
 * Pvmachineinspectors Model for Pvmachineinspectors Component
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * Pvmachineinspector Model
 *
 * @package    Philadelphia.Votes
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
     * Items total
     * @var integer
     */
    public $_total;

    /**
     * Pagination object
     * @var object
     */
    public $_pagination;

    public function __construct()
    {
        parent::__construct();

        $mainframe = JFactory::getApplication();

        // Get pagination request variables
        $limit      = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    /**
     * Returns the query
     * @return string The query to be used to retrieve the rows from the database
     */
    public function _buildQuery()
    {
        $where = '';
        $tmp   = array();
        $query = ' SELECT ia.*, d.ward, d.division '
            . ' FROM #__pv_inspector_applicants ia left join #__divisions d on ia.division_id=d.id '
        ;
        $wards_list = $divisions_list = array();

        $wards     = JRequest::getVar('ward', false);
        $divisions = JRequest::getVar('div', false);

        if ($divisions) {
            $where = ' where ';
            foreach ($divisions as $division) {
                $div_elem = (string) JString::substr(trim($division), 0, 2);
                if (!isset($divisions_list[$div_elem])) {
                    $divisions_list[$div_elem] = array();
                }
                array_push($divisions_list[$div_elem], $this->_db->quote(JString::substr($division, 2, 2)));
            }
            foreach ($divisions_list as $ward => $divs) {
                $tmp[] = '(d.ward=' . $this->_db->quote($ward) . ' and d.division in (' . implode(', ', $divs) . '))';

            }
            $where .= implode(' or ', $tmp);

        } elseif ($wards) {
            foreach ($wards as $ward) {
                $wards_list[] = $this->_db->quote((int) $ward);
            }
            $where = ' where ';
            $where = ' where TRIM(LEADING \'0\' FROM ward) in (' . implode(", ", $wards_list) . ') ';
        }

        return $query . $where;
    }

    /**
     * Retrieves the Pvmachineinspector data
     * @return array Array of objects containing the data from the database
     */
    public function getData()
    {
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) {
            $query       = $this->_buildQuery();
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_data;
    }

    public function getTotal()
    {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query        = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);
        }
        return $this->_total;
    }

    public function getPagination()
    {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_pagination;
    }
}
