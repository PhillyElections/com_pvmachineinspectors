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
        JToolBarHelper::title(JText::_('Machine Inspectors Manager'), 'generic.png');
        JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();

        // Get data from the model

        $model = $this->getModel('Wards');
        d($model, $this);
        $wards = $model->getData();
        $this->assignRef('wards', $wards);

        // leaving division wiring in place
        if (JRequest::getVar('ward', false) && !JRequest::getVar('format', false)) {
            if (JRequest::getVar('div', false)) {
                $divlink = "&div=" . JRequest::getVar('div');
            }
            $wardlink = "&ward=" . JRequest::getVar('ward');
            $model = $this->getModel('Divisions');
            $divisions = $model->getData();
            $this->assignRef('divisions', $divisions);
        }

        $t = &JToolbar::getInstance('toolbar');
        $t->appendButton('Link', 'default', 'Export Filter', 'index.php?option=com_pvmachineinspectors&controller=applicants&format=raw' . $wardlink . $divlink);

        $items = &$this->get('Data');
        $pagination = &$this->get('Pagination');

        $this->assignRef('items', $items);
        $this->assignRef('pagination', $pagination);

        parent::display($tpl);
    }
}
