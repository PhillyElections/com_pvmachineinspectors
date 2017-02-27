<?php
/**
 * Pvmachineinspector Controller for Pvmachineinspectors Component.
 *
 * @license        GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Pvmachineinspector Register Controller.
 */
class PvmachineinspectorsControllerRegister extends PvmachineinspectorsController
{
    public $_msg = array();

    /**
     * display - the registration form.
     */
    public function display()
    {
        JRequest::setVar('view', 'register');
        JRequest::setVar('msg', $this->_msg);

        parent::display();
    }

    /**
     * Set the message on usage of $this->display();.
     *
     * @param string $message message
     * @param bool   $append  append or new?
     */
    public function _setMessage($message, $append = true)
    {
        if (!$append) {
            $this->_msg = array($message);
        } else {
            array_push($this->_msg, $message);
        }
    }

    /**
     * thanks - thank you for registering!
     */
    public function thanks()
    {
        JRequest::setVar('view', 'thanks');
        parent::display();
    }

    /**
     * save.
     */
    public function save()
    {
        JRequest::checkToken() or jexit('Invalid Token');

        $params = &JComponentHelper::getParams( 'com_pvmachineinspectors' );

        if (!$params->get('recaptcha_show')) {
            // skip
        } elseif (!$this->recaptcha($params->get('recaptcha_secret'))) {
            $this->_setMessage('Please make another attempt at verification.');
            $this->display();

            return;
        }

        $model = $this->getModel('applicant');

        // save or fail by dumping to form
        if ($model->store()) {
            $msg = JText::_('Saved!');
        } else {
            // let's grab all those errors and make them available to the view
            foreach ($model->getErrors() as $msg) {
                $this->_setMessage($msg);
            }
            $this->display();

            return;
        }

        // hey, we have good data, and it's been saved  let's say thanks!
        return $this->thanks();
    }

    public function recaptcha($secret = null)
    {
        jimport('recaptcha.ReCaptcha');

        if (!$secret) {
            return false;
        }

        // empty response
        $response = null;

        // check secret key
        $reCaptcha = new ReCaptcha($secret);

        // if submitted check response
        if ($_POST['g-recaptcha-response']) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER['REMOTE_ADDR'],
                $_POST['g-recaptcha-response']
            );
        }
        if ($response != null && $response->success) {
            return true;
        }

        return false;
    }
}
