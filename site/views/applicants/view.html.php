<?php
/**
 * Pvmachineinspectors View for Pvmachineinspectors Component
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * Pvmachineinspectors View
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 */
class PvmachineinspectorsViewApplicants extends JView
{
    /**
     * Pvmachineinspectors view display method
     * @return void
     **/
    public function display($tpl = null)
    {
        $divlink = $wardlink = '';

        // Get data from the model
        $model = $this->getModel('Wards');
        $wards = $model->getData();
        $this->assignRef('wards', $wards);

        // leaving division wiring in place
        if (JRequest::getVar('ward', false) && !JRequest::getVar('format', false)) {
            if (JRequest::getVar('div', false)) {
                $divlink = "&div[]=" . implode("&div[]=", JRequest::getVar('div'));
            }
            $wardlink  = "&ward[]=" . implode("&ward[]=", JRequest::getVar('ward'));
            $model     = $this->getModel('Divisions');
            $divisions = $model->getData();
            $this->assignRef('divisions', $divisions);
        }

        $export_link = 'index.php?option=com_pvmachineinspectors&view=applicants&format=raw' . $wardlink . $divlink . '&ItemId=' . JRequest::getVar('ItemId', '', 'int');

        $items      = &$this->get('Data');
        $pagination = &$this->get('Pagination');

        $this->assignRef('items', $items);
        $this->assignRef('pagination', $pagination);
        $this->assignRef('export_link', $export_link);

        parent::display($tpl);
    }
}
