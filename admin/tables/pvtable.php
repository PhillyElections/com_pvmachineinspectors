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
    public function getByKeyValuePairs($data) {
        $i = 0;
        d($i++, 'reset');
        $this->reset();
        d($i++, "db");
        $db = &$this->getDBO();
        d($i++, "sql");
        $sql = "SELECT * from `" . $this->_tbl . "` WHERE ";
        d($i++, "foreach");
        foreach ($data as $key => $value) {
            d($i++, ".sql");
            $sql .= "`" . $key . "`=" . $db->Quote($value) . " AND ";
        }
        d($i++, "substr ...-4", $sql);
        $sql = JString::substr($sql, 0, -4);
        d($i++, "db-sq", $sql);
        $db->setQuery($sql);

        d($i++, "if, load");
        if ($result = $db->loadAssoc()) {
            d($i++, "return", $result, $this);
            return $this->bind($result);
        } else {
            $this->setError($db->getErrorMsg());
            return false;
        }
    }
}
