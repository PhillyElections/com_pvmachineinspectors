<?php
/**
 * $Id: site/models/link.php $
 * $LastChangedDate: 2015-07-31 $
 * $LastChangedBy: Matt Murphy $
 * Election Officials - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * User Component Remind Model
 *
 * @package      Joomla
 * @subpackage   User
 * @since        1.5
 */
class PvmachineinspectorsModelLink extends JModel {
    /**
     * Registry namespace prefix
     *
     * @var  string
     */
    public $_namespace = 'com_pvmachineinspectors.link.';

    /**
     * Create a new link.
     * @param  array
     * @return bool
     */
    public function create($data = array()) {
        $l = $this->getTable('Link', 'PVTable');
        $lt = $this->getTable('LinkType', 'PVTable');
        $lx = $this->getTable('LinkXref', 'PVTable');
        $t = $this->getTable('Table', 'PVTable');
        d($data, $this, $l, $lt, $lx, $t);

        return true;
    }

    /**
     * Read a link.
     * @param  int  $id
     * @return bool
     */
    public function read($id = null) {
        // todo
        return true;
    }

    /**
     * Update a link.
     * @param  array    $data
     * @return bool
     */
    public function update($data = array()) {
        // todo
        return true;
    }

    /**
     * Delete a link.
     * @param  int  $id
     * @return bool
     */
    public function delete($id = null) {
        // todo
        return true;
    }
}