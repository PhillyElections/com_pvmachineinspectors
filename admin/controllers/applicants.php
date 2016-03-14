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
        JRequest::setVar('view', 'applicants');
        parent::display();
    }
}
