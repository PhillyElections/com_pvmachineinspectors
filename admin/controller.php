<?php
/**
 * $Id: site/controller.php $
 * $LastChangedDate: 2015-07-31 $
 * $LastChangedBy: Matt Murphy $
 * Election Officials - Philadelphiavotes.com
 * a component for Joomla! 1.5 CMS (http://www.joomla.org)
 * Author Website: http://www.philadelphiavotes.com
 * @copyright Copyright (C) 2015 City of Philadelphia
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @package Philadelphia.Votes
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Pvotes Machine Inspectors Controller
 */
class PvmachineinspectorsController extends JController {
    public $_msg = array();

    /**
     * display - the registration form
     * @return void
     */
    public function display() {
        JRequest::setVar('view', 'manage');
        JRequest::setVar('msg', $this->_msg);

        parent::display();
    }

    /**
     * display - the registration form
     * @return void
     */
    public function manage() {
        JRequest::setVar('view', 'manage');
        JRequest::setVar('msg', $this->_msg);

        parent::display();
    }

    /**
     * display - the registration form
     * @return void
     */
    public function edit() {
        JRequest::setVar('view', 'edit');
        JRequest::setVar('msg', $this->_msg);

        parent::display();
    }

    /**
     * Set the message on usage of $this->display();
     * @param string  $message message
     * @param boolean $append  append or new?
     */
    public function _setMessage($message, $append = true) {
        if (!$append) {
            $this->_msg = array($message);
        } else {
            array_push($this->_msg, $message);
        }
    }

    /**
     * register_save - actual form-action method
     * @return void
     */
    public function edit_save() {
        JRequest::checkToken() or jexit('Invalid Token');
        $db = &JFactory::getDBO();

        // call to validate save, and ditch out to form on failure
        if (!$this->validate_save()) {
            // load the form and a message
            //            $this->setRedirect('index.php?option=com_pvmachineinspectors', $this->message);
            // load the form again
            return $this->display();
        }

        // save or fail by dumping to form
        if (!$this->save()) {
            $this->setError("Unable to save this form.");
            return $this->display();
        }

        // hey, we have good data, and it's been saved  let's say thanks!
        $this->setRedirect('index.php?option=com_pvmachineinspectors');
        $this->redirect();
    }

    /**
     * validate_save - very basic check.  very.  basic.
     * @return boolean
     */
    public function validate_save() {
        //
        $invalid = 1;
        $application = &JFactory::getApplication();

        // we need a fname
        if (!JRequest::getVar('fname', null, 'post', 'word')) {
            $invalid *= 2;
            $this->_setMessage('First name is required.');
        }

        // we need a lname
        if (!JRequest::getVar('lname', null, 'post', 'word')) {
            $invalid *= 3;
            $this->_setMessage('Last name is required.');
        }

        // we need an address1
        if (!JRequest::getVar('address1', null, 'post')) {
            $invalid *= 5;
            $this->_setMessage('A street address is required.');
        }

        // we need a city
        if (!JRequest::getVar('city', null, 'post', 'word')) {
            $invalid *= 7;
            $this->_setMessage('A city is required.');
        }

        // we need a 2-digit region
        if (!(JString::strlen(JRequest::getVar('region', null, 'post', 'word')) === 2)) {
            $invalid *= 11;
            $this->_setMessage('A state is required.');
        }

        // we need a 5 numeric digits starting from the left in out postcode
        if (!(filter_var(JRequest::getVar('postcode', null, 'post'), FILTER_SANITIZE_NUMBER_INT) === JRequest::getVar('postcode', null, 'post'))) {
            $invalid *= 13;
            $this->_setMessage('A valid zipcode is required.');
        }

        // if we have an email, we need a valid email
        if (JRequest::getVar('email', null, 'post') && !filter_var(JRequest::getVar('email', null, 'post'), FILTER_VALIDATE_EMAIL)) {
            $invalid *= 17;
            $this->_setMessage(JRequest::getVar('email', null, 'post') . ' is not a valid email.');
        }

        // if we have a phone we need a valid phone
        if (JRequest::getVar('phone', null, 'post')) {
            // reject phone numbers with letters in them
            if (JString::strlen(JRequest::getVar('phone', null, 'post', 'word'))) {
                $invalid *= 19;
                $this->_setMessage('Please supply a phone using numbers only.');
            }
            // Phone numbers may be given with the leading '1' or not
            if (JString::strlen(preg_replace('/^1|\D/', "", JRequest::getVar('phone', null, 'post'))) !== 10) {
                $invalid *= 23;
                $this->_setMessage('Your phone number doesn\'t seem to be the normal length (10 digits). Please reenter.');
            }
        }

        // we must have either phone or email for ease of contact
        if (!JRequest::getVar('phone', null, 'post') && !JRequest::getVar('email', null, 'post')) {
            $invalid *= 29;
            $this->_setMessage('Either email or phone would help us to contact you more easily.  Please supply one or both.');
        }

        if (JRequest::getVar('task') === 'edit_save' && !is_numeric(JRequest::getVar('id', null, 'post', 'int'))) {
            $invalid *= 31;
            $this->_setMessage('No id for this record -- no record to update to...');
        }
        return !($invalid - 1);
    }

    /**
     * save - Save our form data
     * @return boolean
     */
    public function save() {
        JRequest::checkToken() or jexit('Invalid Token');

        jimport("pvcombo.PVCombo");

        $created = date('Y-m-d h:i:s');
        $region = $suffix = $prefix = $marital = $gender = $email = $phone = '';
        d($_POST);
        // lets get values to replace references
        if (JRequest::getVar('prefix', null, 'post', 'string')) {
            $prefix = PVCombo::get('prefix')[JRequest::getVar('prefix', null, 'post', 'string')] ? PVCombo::get('prefix')[JRequest::getVar('prefix', null, 'post', 'string')] : '';
        }
        if (JRequest::getVar('suffix', null, 'post', 'string')) {
            $suffix = PVCombo::get('suffix')[JRequest::getVar('suffix', null, 'post', 'string')] ? PVCombo::get('suffix')[JRequest::getVar('suffix', null, 'post', 'string')] : '';
        }
        if (JRequest::getVar('region', null, 'post', 'string')) {
            $region = PVCombo::get('state')[JRequest::getVar('region', null, 'post', 'string')] ? PVCombo::get('state')[JRequest::getVar('region', null, 'post', 'string')] : '';
        }
        if (JRequest::getVar('email', null, 'post', 'string')) {
            $email = filter_var(JRequest::getVar('email', null, 'post', 'string'));
        }
        if (JRequest::getVar('phone', null, 'post')) {
            $phone = preg_replace('/^1|\D/', "", JRequest::getVar('phone', null, 'post'));
        }

        // load our models
        $ia = $this->getModel('applicant');

        // create applicant record and get person id (applicant = person + inspector_applicant)
        $linkData = $ia->update(
            array(
                'id' => JRequest::getVar('fname', null, 'post', 'int'),
                'prefix' => $prefix,
                'first_name' => JRequest::getVar('fname', null, 'post', 'string'),
                'middle_name' => JRequest::getVar('mname', null, 'post', 'string'),
                'last_name' => JRequest::getVar('lname', null, 'post', 'string'),
                'suffix' => $suffix,
                'address1' => JRequest::getVar('address1', null, 'post', 'string'),
                'address2' => JRequest::getVar('address2', null, 'post', 'string'),
                'city' => JRequest::getVar('city', null, 'post', 'string'),
                'region' => $region,
                'postcode' => JRequest::getVar('postcode', null, 'post', 'string'),
                'email' => $email,
                'phone' => $phone,
                'created' => $created,
            )
        );

        return true;
    }

    public function getListData() {
        $mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $view = JRequest::getCmd('view');
        $db = JFactory::getDBO();
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = $mainframe->getUserStateFromRequest($option . $view . '.limitstart', 'limitstart', 0, 'int');
        $search = JString::strtolower($mainframe->getUserStateFromRequest($option . $view . 'search', 'search', '', 'string'));
        $filter_order = $mainframe->getUserStateFromRequest($option . $view . 'filter_order', 'filter_order', 'c.ordering', 'cmd');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . $view . 'filter_order_Dir', 'filter_order_Dir', '', 'word');
//        $filter_trash = $mainframe->getUserStateFromRequest($option.$view.'filter_trash', 'filter_trash', 0, 'int');
        $filter_state = $mainframe->getUserStateFromRequest($option . $view . 'filter_state', 'filter_state', -1, 'int');
//        $language = $mainframe->getUserStateFromRequest($option.$view.'language', 'language', '', 'string');
        //        $filter_category = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', 0, 'int');

        $query = "SELECT * FROM #__pv_inspector_applicants WHERE id>0";

        if ($search) {
            $escaped = K2_JVERSION == '15' ? $db->getEscaped($search, true) : $db->escape($search, true);
            $query .= " AND LOWER( c.name ) LIKE " . $db->Quote('%' . $escaped . '%', false);
        }

        if ($filter_state > -1) {
            $query .= " AND c.published={$filter_state}";
        }

        $query .= " ORDER BY {$filter_order} {$filter_order_Dir}";

        $db->setQuery($query);
        $rows = $db->loadObjectList();

        $categories = array();

        if ($search) {
            foreach ($rows as $row) {
                $row->treename = $row->name;
                $categories[] = $row;
            }

        }

        if (isset($categories)) {
            $total = count($categories);
        } else {
            $total = 0;
        }

        jimport('joomla.html.pagination');
        $pageNav = new JPagination($total, $limitstart, $limit);
        $categories = @array_slice($categories, $pageNav->limitstart, $pageNav->limit);

        return $categories;
    }
}
