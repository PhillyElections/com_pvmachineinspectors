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
 * Applicant Controller.
 *
 * @since 1.5
 */
class PvmachineinspectorsController extends JController
{
    /**
     * Display signup form.
     *
     * @since   1.5
     */
    public function display()
    {
        JRequest::setVar('view', 'register');
        parent::display();
    }

    /**
     * Display signup acknowledgement.
     *
     * @since   1.5
     */
    public function thanks()
    {
        JRequest::setVar('view', 'thanks');

        parent::display();
    }

    /**
     * Save registration and notify users and admins if required.
     */
    public function register_save()
    {
        $db = &JFactory::getDBO();
        d('processing the save', $_POST);

        // call to validate save, and ditch out to form on failure
        if (!$this->validate_save()) {
            // load the form and a message
            $message = 'Form invalidated, sucka!';
            // load the form again
            return $this->display();
        }

        if (!$this->save()) {
            $message = 'Could not save. -- replace with a JError call';
            return $this->display();
        }

        // hey, we have good data!  let's set a message for the redirect
        $message = "Thank you for registering to be a Machine Inspector.";

        //
        $email = JRequest::getVar('email', null, 'post', 'string');
        if ($email) {
            $message .= "<br>...And thank you for providing an email address.  <br>At your convenience please check your email for a confirmation email and click the link within to <b>verify</b> your email.";
        }
        dd('stopping before we redirect');
        $this->setRedirect('index.php', $message);
    }

    /**
     * Validation tests for length only on fname, lname, address1, city, province, postcode, email
     *
     */
    public function validate_save()
    {
        return (JRequest::getVar('fname', null, 'post', 'string') &&
            JRequest::getVar('lname', null, 'post', 'string') &&
            JRequest::getVar('address1', null, 'post', 'string') &&
            JRequest::getVar('city', null, 'post', 'string') &&
            JRequest::getVar('province', null, 'post', 'string') &&
            JRequest::getVar('postcode', null, 'post', 'string') &&
            JRequest::getVar('email', null, 'post', 'string')
        );
    }

    /**
     * Save the form data in the various proper locations
     */
    public function save()
    {
        //
        $ia = $this->getModel('applicant');
        // create applicant record and get applicant id
        $ia->create(
            array(
                'prefix'=>JRequest::getVar('prefix', null, 'post', 'string'),
                'fname' =>JRequest::getVar('fname', null, 'post', 'string'),
                'mname' =>JRequest::getVar('mname', null, 'post', 'string'),
                'lname' =>JRequest::getVar('lname', null, 'post', 'string'),
                'suffix'=>JRequest::getVar('suffix', null, 'post', 'string'),
            )
        );
        // save applicant links

        // 
        $a = $this->getModel('address');
        // save the address
        $a->create(
            array(
                'address1'=>JRequest::getVar('address1', null, 'post', 'string'),
                'address2'=>JRequest::getVar('address2', null, 'post', 'string'),
                'city'    =>JRequest::getVar('city', null, 'post', 'string'),
                'province'=>JRequest::getVar('province', null, 'post', 'string'),
                'postcode'=>JRequest::getVar('postcode', null, 'post', 'string'),
            )
        );
        // bind the address to the applicant (person)

        $l = $this->getModel('link');
        $l->create(
            array(
                'email'=>JRequest::getVar('email', null, 'post', 'string')
            )
        );

        d($ia, $a, $l);
        return true;
    }

    public function _sendMail(&$user, $password)
    {
        global $mainframe;

        $db = &JFactory::getDBO();

        $name     = $user->get('name');
        $email    = $user->get('email');
        $username = $user->get('username');

        $usersConfig    = &JComponentHelper::getParams('com_users');
        $sitename       = $mainframe->getCfg('sitename');
        $useractivation = $usersConfig->get('useractivation');
        $mailfrom       = $mainframe->getCfg('mailfrom');
        $fromname       = $mainframe->getCfg('fromname');
        $siteURL        = JURI::base();

        $subject = sprintf(JText::_('Account details for'), $name, $sitename);
        $subject = html_entity_decode($subject, ENT_QUOTES);

        if ($useractivation == 1) {
            $message = sprintf(JText::_('SEND_MSG_ACTIVATE'), $name, $sitename, $siteURL.'index.php?option=com_user&task=activate&activation='.$user->get('activation'), $siteURL, $username, $password);
        } else {
            $message = sprintf(JText::_('SEND_MSG'), $name, $sitename, $siteURL);
        }

        $message = html_entity_decode($message, ENT_QUOTES);

        //get all super administrator
        $query = 'SELECT name, email, sendEmail'.
        ' FROM #__users'.
        ' WHERE LOWER( usertype ) = "super administrator"';
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        // Send email to user
        if (!$mailfrom || !$fromname) {
            $fromname = $rows[0]->name;
            $mailfrom = $rows[0]->email;
        }

        JUtility::sendMail($mailfrom, $fromname, $email, $subject, $message);

        // Send notification to all administrators
        $subject2 = sprintf(JText::_('Account details for'), $name, $sitename);
        $subject2 = html_entity_decode($subject2, ENT_QUOTES);

        // get superadministrators id
        foreach ($rows as $row) {
            if ($row->sendEmail) {
                $message2 = sprintf(JText::_('SEND_MSG_ADMIN'), $row->name, $sitename, $name, $email, $username);
                $message2 = html_entity_decode($message2, ENT_QUOTES);
                JUtility::sendMail($mailfrom, $fromname, $row->email, $subject2, $message2);
            }
        }
    }
}
