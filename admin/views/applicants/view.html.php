<?php
/**
 * Pvmachineinspectors View for Pvmachineinspectors Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * Pvmachineinspectors View
 *
 * @package    Joomla.Tutorials
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
        JToolBarHelper::title(JText::_('Pvmachineinspector Manager'), 'generic.png');
        JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();
        $t = &JToolbar::getInstance('toolbar');
        $t->appendButton('Link', 'default', 'Export Filter', 'index.php?option=com_pvmachineinspectors&controller=applicants&format=raw');
        // Get data from the model

        $items = &$this->get('Data');
        $pagination = &$this->get('Pagination');

        $this->assignRef('items', $items);
        $this->assignRef('pagination', $pagination);

        parent::display($tpl);
    }
}
