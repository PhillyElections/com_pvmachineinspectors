<?php

/**
 * @version         $Id: user.php 14401 2010-01-26 14:10:00Z louis $
 *
 * @copyright   Copyright (C) 2015 City of Philadelphia Elections Commission
 * @license         GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * User Component User Model.
 *
 * @since 1.5
 */
class PvmachineinspectorsModelPerson extends JModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Method to set the weblink identifier.
     *
     * @param   int Weblink identifier
     */
    public function setId($id)
    {
        // Set weblink id and wipe data
        $this->_id = $id;
        $this->_data = null;
    }

    /**
     * Method to get a user.
     *
     * @since 1.5
     */
    public function &getData()
    {
        // Load the weblink data
        if ($this->_loadData()) {
            //do nothing
        }

        return $this->_data;
    }

    /**
     * Method to store the user data.
     *
     * @return bool True on success
     *
     * @since   1.5
     */
    public function store($data)
    {
        $user = JFactory::getUser();
        $username = $user->get('username');

        // Bind the form fields to the user table
        if (!$user->bind($data)) {
            $this->setError($this->_db->getErrorMsg());

            return false;
        }

        // Store the web link table to the database
        if (!$user->save()) {
            $this->setError($user->getError());

            return false;
        }

        $session = &JFactory::getSession();
        $session->set('user', $user);

        // check if username has been changed
        if ($username != $user->get('username')) {
            $table = $this->getTable('session', 'JTable');
            $table->load($session->getId());
            $table->username = $user->get('username');
            $table->store();
        }

        return true;
    }

    /**
     * Method to load user data.
     *
     * @return bool True on success
     *
     * @since   1.5
     */
    public function _loadData()
    {
        // Lets load the content if it doesn't already exist
        if (empty($this->_data)) {
            $this->_data = &JFactory::getUser();

            return (boolean) $this->_data;
        }

        return true;
    }
}
