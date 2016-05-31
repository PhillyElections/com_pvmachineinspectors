<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
jimport("pvcombo.PVCombo");
if (count(JRequest::getVar('msg', null, 'post'))) {
    foreach (JRequest::getVar('msg', null, 'post') as $msg) {
        JError::raiseWarning(1, $msg);
    }
}

// lets go through the post array and extract any existing values for display
$data = JRequest::get('post');

$document->addCustomTag('<script src="/components/com_pvmachineinspectors/assets/js/machineinspectors.js" async defer></script>');

?>
<form action="<?php echo JRoute::_('index.php?option=com_pvmachineinspectors'); ?>" method="post" id="adminForm" name="adminForm" class="form-validate">
    <table cellpadding="0" cellspacing="0" border="0" class="adminform">
        <tbody>
            <tr>
                <td width="200" height="30">
                    <label id="namemsg" for="first_name"><?php echo JText::_('NAME'); ?>:</label>
                </td>
                <td>
                    <?php echo JHTML::_('select.genericlist', PVCombo::gets('prefix'), 'prefix', 'class="input_box required"', 'idx', 'value', $data['prefix'], 'prefix'); ?>
                    <input type="text" name="first_name" id="first_name" size="18" value="<?php echo $data['first_name']; ?>" class="input_box required" maxlength="50" placeholder="<?php echo JText::_('FNAME PLACEHOLDER'); ?>" />
                    <input type="text" name="middle_name" id="middle_name" size="1" value="<?php echo $data['middle_name']; ?>" class="input_box optional" maxlength="25" />
                    <input type="text" name="last_name" id="last_name" size="18" value="<?php echo $data['last_name']; ?>" class="input_box required" maxlength="50" placeholder="<?php echo JText::_('LNAME PLACEHOLDER'); ?>" />
                    <?php echo JHTML::_('select.genericlist', PVCombo::gets('suffix'), 'suffix', 'class="input_box required"', 'idx', 'value', $data['suffix'], 'suffix'); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" border="0" class="adminform">
        <tbody>
            <tr>
                <td width="200" height="30">
                    <label id="address1msg" for="address1"><?php echo JText::_('STREET ADDRESS'); ?>:</label>
                </td>
                <td>
                    <input type="text" id="address1" name="address1" size="62" value="<?php echo $data['address1']; ?>" class="input_box required" maxlength="60" placeholder="<?php echo JText::_('STREET PLACEHOLDER'); ?>" />
                </td>
            </tr>
            <tr>
                <td height="30">
                    <label id="address2msg" for="address2"><?php echo JText::_('APT_UNIT_SUITE'); ?>:</label>
                </td>
                <td>
                    <input type="text" id="address2" name="address2" size="62" value="<?php echo $data['address2']; ?>" class="input_box optional" maxlength="60" />
                </td>
            </tr>
            <tr>
                <td height="30">
                    <label id="citymsg" for="city"><?php echo JText::_('CITY'); ?>:</label>
                </td>
                <td>
                    <input type="text" id="city" name="city" size="62" value="<?php echo ($data['city'] ? $data['city'] : 'Philadelphia'); ?>" class="input_box required" maxlength="60" placeholder="<?php echo JText::_('CITY PLACEHOLDER'); ?>" />
                </td>
            </tr>
            <tr>
                <td height="30">
                    <label id="regionmsg" for="region">
                        <?php echo JText::_('REGION'); ?>:
                    </label>
                </td>
                <td><?php echo JHTML::_('select.genericlist', PVCombo::gets('state'), 'region', 'class="input_box required"', 'idx', 'value', ($data['region'] ? $data['region'] : 'PA'), 'region'); ?></td>
            </tr>
            <tr>
                <td height="30">
                    <label id="postcodemsg" for="postcode">
                        <?php echo JText::_('POSTCODE'); ?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="postcode" name="postcode" size="62" value="<?php echo $data['postcode']; ?>" class="input_box required" maxlength="60" placeholder="<?php echo JText::_('POSTCODE PLACEHOLDER'); ?>" />
                </td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" border="0" class="adminform">
        <tbody>
            <tr>
                <td width="200" height="30">
                    <label id="phonemsg" for="phone">
                        <?php echo JText::_('PHONE'); ?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="phone" name="phone" size="62" value="<?php echo $data['phone']; ?>" class="input_box required" maxlength="100" placeholder="<?php echo JText::_('PHONE PLACEHOLDER'); ?>" />
                </td>
            </tr>
            <tr>
                <td height="30">
                    <label id="emailmsg" for="email">
                        <?php echo JText::_('EMAIL'); ?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="email" name="email" size="62" value="<?php echo $data['email']; ?>" class="input_box" maxlength="100" />
                </td>
            </tr>
            <tr>
                <td height="30">&nbsp;</td>
                <td>
                    <button class="button validate" type="submit"><?php echo JText::_('REGISTER'); ?></button>
                    <input type="hidden" name="task" value="register" />
                    <input type="hidden" name="controller" value="applicant" />
                </td>
            </tr>
        </tbody>
    </table>
    <?php echo JHTML::_('form.token'); ?>
</form>