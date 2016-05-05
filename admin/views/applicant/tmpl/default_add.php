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
d('add template', $_POST, JRequest::get());
// lets go through the post array and extract any existing values for display
$fields = array('prefix', 'first_name', 'middle_name', 'last_name', 'suffix', 'division', 'address1', 'address2', 'city', 'region', 'postcode', 'phone', 'email');
foreach ($fields as $field) {
    $$field = JRequest::getVar($field, null, 'post');
}
$document->addCustomTag('<script src="/components/com_pvmachineinspectors/assets/js/machineinspectors.js" async defer></script>');
?>
<form action="<?=JRoute::_('index.php?option=com_pvmachineinspectors');?>" method="post" id="adminForm" name="adminForm" class="form-validate">
    <table cellpadding="0" cellspacing="0" border="0" class="adminform">
        <tbody>
            <tr>
                <td width="200" height="30">
                    <label id="namemsg" for="first_name"><?=JText::_('NAME');?>:</label>
                </td>
                <td>
                    <?=JHTML::_('select.genericlist', PVCombo::gets('prefix'), 'prefix', 'class="input_box required"', 'idx', 'value', $prefix, 'prefix');?>
                    <input type="text" name="first_name" id="first_name" size="18" value="<?=$first_name;?>" class="input_box required" maxlength="50" placeholder="<?=JText::_('FNAME PLACEHOLDER');?>" />
                    <input type="text" name="middle_name" id="middle_name" size="1" value="<?=$middle_name;?>" class="input_box optional" maxlength="25" />
                    <input type="text" name="last_name" id="last_name" size="18" value="<?=$last_name;?>" class="input_box required" maxlength="50" placeholder="<?=JText::_('LNAME PLACEHOLDER');?>" />
                    <?=JHTML::_('select.genericlist', PVCombo::gets('suffix'), 'suffix', 'class="input_box required"', 'idx', 'value', $suffix, 'suffix');?>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" border="0" class="adminform">
        <tbody>
            <tr>
                <td width="200" height="30">
                    <label id="address1msg" for="address1"><?=JText::_('STREET ADDRESS');?>:</label>
                </td>
                <td>
                    <input type="text" id="address1" name="address1" size="62 value="<?=$address1;?>" class="input_box required" maxlength="60" placeholder="<?=JText::_('STREET PLACEHOLDER');?>" />
                </td>
            </tr>
            <tr>
                <td height="30">
                    <label id="address2msg" for="address2"><?=JText::_('APT_UNIT_SUITE');?>:</label>
                </td>
                <td>
                    <input type="text" id="address2" name="address2" size="62 value="<?=$address2;?>" class="input_box optional" maxlength="60" />
                </td>
            </tr>
            <tr>
                <td height="30">
                    <label id="citymsg" for="city"><?=JText::_('CITY');?>:</label>
                </td>
                <td>
                    <input type="text" id="city" name="city" size="62 value="<?=($city ? $city : 'Philadelphia');?>" class="input_box required" maxlength="60" placeholder="<?=JText::_('CITY PLACEHOLDER');?>" />
                </td>
            </tr>
            <tr>
                <td height="30">
                    <label id="regionmsg" for="region">
                        <?=JText::_('REGION');?>:
                    </label>
                </td>
                <td><?=JHTML::_('select.genericlist', PVCombo::gets('state'), 'region', 'class="input_box required"', 'idx', 'value', ($region ? $region : 'PA'), 'region');?></td>
            </tr>
            <tr>
                <td height="30">
                    <label id="postcodemsg" for="postcode">
                        <?=JText::_('POSTCODE');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="postcode" name="postcode" size="62 value="<?=$postcode;?>" class="input_box required" maxlength="60" placeholder="<?=JText::_('POSTCODE PLACEHOLDER');?>" />
                </td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" border="0" class="adminform">
        <tbody>
            <tr>
                <td width="200" height="30">
                    <label id="phonemsg" for="phone">
                        <?=JText::_('PHONE');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="phone" name="phone" size="62 value="<?=$phone;?>" class="input_box required" maxlength="100" placeholder="<?=JText::_('PHONE PLACEHOLDER');?>" />
                </td>
            </tr>
            <tr>
                <td height="30">
                    <label id="emailmsg" for="email">
                        <?=JText::_('EMAIL');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="email" name="email" size="62 value="<?=$email;?>" class="input_box" maxlength="100" />
                </td>
            </tr>
            <tr>
                <td height="30">&nbsp;</td>
                <td>
                    <button class="button validate" type="submit"><?=JText::_('REGISTER');?></button>
                    <input type="hidden" name="task" value="register" />
                    <input type="hidden" name="controller" value="applicant" />
                </td>
            </tr>
        </tbody>
    </table>
    <?=JHTML::_('form.token');?>
</form>