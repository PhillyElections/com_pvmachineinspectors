<?php
/**
 * Pvmachineinspectors bootstrap file
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 * @license        GNU/GPL
 */

defined('_JEXEC') or die('Restricted access');

/**
 * @package Philadelphia.Votes
 */

jimport('kint.kint');

// Require the base controller

require_once JPATH_COMPONENT . DS . 'controller.php';

// Create the controller
$classname = 'PvmachineinspectorsController';

$controller = new $classname();

// Perform the Request task
$controller->execute(JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
