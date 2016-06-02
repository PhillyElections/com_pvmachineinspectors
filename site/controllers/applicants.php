<?php
/**
 * Pvmachineinspector Controller for Pvmachineinspectors Component
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Pvmachineinspector Pvmachineinspector Controller
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 */
class PvmachineinspectorsControllerApplicants extends PvmachineinspectorsController
{
    public function display()
    {
        // if format isn't 'raw', explicitly set to 'html'
        $view = $this->getView('applicants', JRequest::getWord('format', 'html'));
        $view->setModel($this->getModel('Applicants'), true);
        $view->setModel($this->getModel('Wards'), false);

        if (JRequest::getVar('ward', false)) {
            $view->setModel($this->getModel('Divisions'), false);
        }
        d('in display', $this);

        $view->display();
    }

    public function edit()
    {
        $mainframe = JFactory::getApplication();
        $cid       = JRequest::getVar('cid');
        $mainframe->redirect('index.php?option=com_pvmachineinspectors&view=applicant&task=edit&cid=' . $cid[0] .'&ItemId='.JRequest::getVar('ItemId', '', 'int'));
    }

    public function add()
    {
        $mainframe = JFactory::getApplication();
        $mainframe->redirect('index.php?option=com_pvmachineinspectors&view=applicant&task=add&&cid=&ItemId='.JRequest::getVar('ItemId', '', 'int');
    }
}
