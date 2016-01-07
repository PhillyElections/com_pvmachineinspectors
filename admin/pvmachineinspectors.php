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

// Make sure the user is authorized to view this page
$user = &JFactory::getUser();
dd($user);
if (!$user->authorize('com_pvmachineinspectors', 'manage')) {
    $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));
}
exit;
// Require the base controller
require_once JPATH_COMPONENT . DS . 'controller.php';

// Create the controller
$controller = new PvmachineinspectorsController();

$controller->registerTask('manage', 'manage');
$task = 'display';
if (in_array(JRequest::getWord('view', null), $controller->_methods)) {
    $task = JRequest::getWord('view', null);
}
d($controller, $task, $controller->$task());
// Perform the Request task
$controller->$task(); //execute('display');

// Redirect if set by the controller
$controller->redirect();
