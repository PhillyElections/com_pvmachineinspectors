<?php
/**
 * Applicant View for Pvmachineinspectors Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license     GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * Applicant View
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class PvmachineinspectorsViewApplicant extends JView {
	/**
	 * display method of Applicant view
	 * @return void
	 **/
	public function display($tpl = null) {

		$applicant = &$this->get('Data');

		$isNew = ($applicant->id < 1);

		$text = $isNew?JText::_('New'):JText::_('Edit');
		JToolBarHelper::title(JText::_('Applicant').': <small><small>[ '.$text.' ]</small></small>');
		if ($isNew) {
			JToolBarHelper::save('save', 'Register');
			JToolBarHelper::cancel('cancel', 'Close');
			// We'll use a separate template for new applicants: default_add
			$tpl = 'add';
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::save('save', 'Update');
			JToolBarHelper::cancel('cancel', 'Close');
		}

		$this->assignRef('applicant', $applicant);
		$this->assignRef('isNew', $isNew);

		parent::display($tpl);
	}
}
