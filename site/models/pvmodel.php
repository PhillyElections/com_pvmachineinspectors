<?php
/**
 * $Id: site/models/address.php $
 * $LastChangedBy: Matt Murphy $
 * Election Officials - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com.
 *
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * User Component Remind Model.
 *
 * @since        1.5
 */
class PVModel extends JModel {

    public function getXrefTableId(&$x2) {

        $t = $this->getTable('Table', 'PVTable');

        $tableName = JString::str_ireplace('#__', $x2->_db->getPrefix(), $x2->getTableName());

        $t->loadFromKeyValuePairs(array('name' => $tableName));
        return $t->get('id');
    }
}