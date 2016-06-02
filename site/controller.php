<?php
/**
 * Pvmachineinspectors default controller
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Pvmachineinspectors Component Controller
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 */
class PvmachineinspectorsController extends JController
{
    /**
     * Method to display the view
     *
     * @access    public
     */
    public function display()
    {
        d($this);
        parent::display();
    }
}
