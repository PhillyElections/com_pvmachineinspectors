<?php
/**
 * $Id: site/views/register/view.html.php $
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

jimport('joomla.application.component.view');

/**
 * HTML View class for the Registration component.
 *
 * @since 1.0
 */
class PvmachineinspectorsViewRegister extends JView
{
    public function display()
    {
        global $mainframe;
        $pathway  = &$mainframe->getPathway();
        $document = &JFactory::getDocument();
        $params   = &$mainframe->getParams();

        // Page Title
        $menus = &JSite::getMenu();
        $menu  = $menus->getActive();

        // fallback title
        $title = 'Machine Inspector Application';

        if (is_object($menu)) {
            $menu_params = new JParameter($menu->params);
            if (!$menu_params->get('page_title')) {
                $params->set('page_title', JText::_($title));
            }
        } else {
            $params->set('page_title', JText::_($title));
        }

        // data for select elements
        $db = &JFactory::getDBO();
        $db->setQuery('SELECT DISTINCT `ward` FROM `#__divisions` ORDER BY left(`division_id`, 2) ASC');
        if (!($wards = $db->loadObjectList())) {
            $this->setError(JText::_('Wards query failed'));
        }
        $db->setQuery('SELECT `id`, `division_id`, `ward`, `division` FROM `#__divisions` ORDER BY `division_id` ASC');
        if (!($divisions = $db->loadObjectList())) {
            $this->setError(JText::_('Divisions query failed'));
        }

        //
        $document->setTitle($params->get('page_title'));
        $this->assignRef('params', $params);
        $this->assignRef('wards', $wards);
        $this->assignRef('divisions', $divisions);

        // Load the form validation behavior
        JHTML::_('behavior.formvalidation');

        parent::display();
    }

    public function setComboData($arr)
    {
        foreach ($arr as $idx => $value) {
            $return[] = (object) array('idx' => $idx, 'value' => $value);
        }
        return $return;
    }

    public function getPrefixes()
    {
        $arr = array(
            '1' => '',
            '2' => 'Mr.',
            '3' => 'Mrs.',
            '4' => 'Ms.',
            '5' => 'Dr.',
        );

        return $this->setComboData($arr);
    }

    public function getSuffixes()
    {
        $arr = array(
            '1' => '',
            '2' => 'Jr.',
            '3' => 'Sr.',
            '4' => 'II',
            '5' => 'III',
        );

        return $this->setComboData($arr);
    }

    public function getUSStates()
    {
        $arr = array(
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AS' => 'American',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'Dist. of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'GU' => 'Guam',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MH' => 'Marshall',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'FM' => 'Micronesia',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'MP' => 'Northern',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PW' => 'Palau',
            'PA' => 'Pennsylvania',
            'PR' => 'Puerto Rico',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'VI' => 'Virgin Islands',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming');

        return $this->setComboData($arr);
    }
}
