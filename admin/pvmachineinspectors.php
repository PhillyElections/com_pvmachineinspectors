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
if (file_exists(JPATH_COMPONENT . DS . 'controllers' . DS . $task . '.php')) {
    require_once JPATH_COMPONENT . DS . 'controllers' . DS . $task . '.php';
} else {
    require_once JPATH_COMPONENT . DS . 'controllers' . DS . 'manage.php';
}
$task = JRequest::getCmd('task', 'manage');

// Create the controller
$controllerName = 'PvmachineinspectorsController' . ucfirst($task);
$controller = new $controllerName();

//$controller->registerTask('manage', 'manage');
$view = 'display';
if (in_array(JRequest::getWord('view', null), $controller->_methods)) {
    $task = JRequest::getWord('view', null);
}
//d($controller, $task, $controller->$task());
// Perform the Request task
//
d($controller, $task);
//$controller->execute($task);
// Redirect if set by the controller
$controller->redirect();
