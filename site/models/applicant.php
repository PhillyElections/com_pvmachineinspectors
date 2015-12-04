<?php 
/**
 * $Id: site/models/person.php $
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
 * @package     Joomla
 * @subpackage  User
 * @since       1.5
 */
class PvmachineinspectorsModelApplicant extends JModel
{
    /**
     * Registry namespace prefix
     *
     * @var string
     */
    public $_namespace = 'com_pvmachineinspectors.applicant.';

    public function create($data = null) {
        d($data, $this);
        //save pv_person data and return a person_id
        // applicant loads ia and person

    }

    public function read() {

    }

    public function update() {

    }

    public function delete() {

    }
}