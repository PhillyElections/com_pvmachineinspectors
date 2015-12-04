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
class PvmachineinspectorsModelLink extends JModel
{
    /**
     * Registry namespace prefix
     *
     * @var  string
     */
    public $_namespace    = 'com_pvmachineinspectors.link.';

    /**
     * Create a new link.
     * 
     * @param  array
     *
     * @return bool
     */
    public function create($data = array())
    {
        d($data, $this);

        return true;
    }

    /**
     * Read an link from applicant id.
     *
     * @param  int
     *
     * @return bool
     */
    public function read($id = null)
    {
        // todo
    }

    /**
     * Update a link.
     *
     * @param  array
     *
     * @return bool
     */
    public function update($data = array())
    {
        // todo
    }

    /**
     * Delete a link.
     *
     * @param  int
     *
     * @return bool
     */
    public function delete($id = null)
    {
        // todo
    }
}