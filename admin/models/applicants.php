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
class PvmachineinspectorsModelApplicants extends JModel {
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
	public function _buildQuery() {

		$query = ' SELECT ia.*, d.ward, d.division '
		.' FROM #__pv_inspector_applicants ia left join #__divisions d on ia.division_id=d.id ';

		return $query;
	}

	/**
	 * Retrieves the Pvmachineinspector data
	 * @return array Array of objects containing the data from the database
	 */
	public function getData() {
		// get the application object
		$app = &JFactory::getApplication();
		// define the state context
		// get the limit
		$limit = $app->getUserStateFromRequest('limit', 'limit', 0, 'int');
		// get the limitstart (backend)
		$limitstart = $app->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$limitstart = ($limit != 0?(floor($limitstart/$limit)*$limit):0);

		// Lets load the data if it doesn't already exist
		if (empty($this->_data)) {
			$query = $this->_buildQuery();

			// set naked query to get total
			$this->_db->query($query);
			$total = $this->_db->getNumRows();

			// import JPagination class
			jimport('joomla.html.pagination');

			// create JPagination object
			$paginmtion        = new JPagination($total, $limitstart, $limit);
			$this->_pagination = $pagination;
			$this->_data       = $this->_getList($query, $limitstart, $limit);
		}

		return $this->_data;
	}

	public function getPagination() {
		return $this->_pagination;
	}
}
