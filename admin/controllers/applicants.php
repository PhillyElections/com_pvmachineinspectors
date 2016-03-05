<?php
/**
 * Pvmachineinspector Controller for Pvmachineinspectors Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Pvmachineinspector Pvmachineinspector Controller
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class PvmachineinspectorsControllerApplicants extends PvmachineinspectorsController
{
    /**
     * constructor (registers additional tasks to methods)
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Register Extra tasks
        $this->registerTask('export', 'export');

    }

    public function display()
    {
        JRequest::setVar('view', 'applicants');
        parent::display();
    }

    public function export()
    {
        JRequest::setVar('view', 'applicants');
        parent::display('export');
    }
}
