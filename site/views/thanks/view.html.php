<?php
/**
 * Pvmachineinspectors thanks view
 *
 * @package    Philadelphia.Votes
 * @subpackage Components
 * @license        GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the Registration component.
 *
 * @since 1.0
 */
class PvmachineinspectorsViewThanks extends JView
{
    public function display()
    {
        global $mainframe;
        $pathway = &$mainframe->getPathway();
        $document = &JFactory::getDocument();
        $params = &$mainframe->getParams();

        // Page Title
        $menus = &JSite::getMenu();
        $menu = $menus->getActive();

        // fallback title
        $title = 'Thank you.';

        if (is_object($menu)) {
            $menu_params = new JParameter($menu->params);
            if (!$menu_params->get('page_title')) {
                $params->set('page_title', JText::_($title));
            }
        } else {
            $params->set('page_title', JText::_($title));
        }

        $document->setTitle($params->get('page_title'));
        $this->assignRef('params', $params);

        parent::display();
    }
}
