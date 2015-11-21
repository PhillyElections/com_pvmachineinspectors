<?php
/**
 * $Id: admin/pvmachineinspectors.php $
 * $LastChangedDate: 2015-07-31 $
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

JToolBarHelper::title(JText::_('Machine Inspector Signups'), 'generic.png');
JToolBarHelper::publishList();
JToolBarHelper::unpublishList();
JToolBarHelper::editList();
JToolBarHelper::deleteList();
JToolBarHelper::addNew();
