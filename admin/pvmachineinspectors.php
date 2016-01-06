<?php
/**
 * $Id: admin/pvmachineinspectors.php $
 * $LastChangedBy: Matt Murphy $
 * Election Officials - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

defined('_JEXEC') or die('Restricted access');

/**
 * @package Philadelphia.Votes
 */

// pull in the super-groovy debugger
jimport('kint.kint');

// Require the base controller
require_once JPATH_COMPONENT . DS . 'controller.php';

// Create the controller
$controller = new PvmachineinspectorsController();

// Perform the Request task
$controller->execute('display');

// Redirect if set by the controller
$controller->redirect();
