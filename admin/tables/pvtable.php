<?php
/**
 * @version     $Id: PVTable.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package     K2
 * @author      JoomlaWorks http://www.joomlaworks.net
 * @copyright   Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license     GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

class PVTable extends JTable {
    public function loadFromKeyValuePairs($data) {
        $this->reset();
        $db = &$this->getDBO();
        $sql = "SELECT * from `" . $this->_tbl . "` WHERE ";
        // make criteria out of each pair
        foreach ($data as $key => $value) {
            $sql .= "`" . $key . "`=" . $db->Quote($value) . " AND ";
        }
        // drop the final " AND"
        $sql = JString::substr($sql, 0, -4);
        $db->setQuery($sql);

        if ($result = $db->loadAssoc()) {
            return $this->bind($result);
        } else {
            $this->setError($db->getErrorMsg());
            return false;
        }
    }

    public function getXrefTableId() {
        $t = &JModel::getTable('Table', 'PVTable');

        $tableName = JString::str_ireplace('#__', $this->_db->getPrefix(), $this->getTableName());

        $t->loadFromKeyValuePairs(array('name' => $tableName));
        return $t->get('id');

    }
}
