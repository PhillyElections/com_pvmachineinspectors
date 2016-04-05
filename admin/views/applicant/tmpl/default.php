<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
// we'll need these for the combo
jimport("pvcombo.PVCombo");
if (count(JRequest::getVar('msg', null, 'post'))) {
    foreach (JRequest::getVar('msg', null, 'post') as $msg) {
        JError::raiseWarning(1, $msg);
    }
}
$applicant = $this->applicant;
$document->addCustomTag('<script src="/components/com_pvmachineinspectors/assets/js/machineinspectors.js" async defer></script>');
?>
<form action="<?=JRoute::_('index.php?option=com_pvmachineinspectors');?>" method="post" id="adminForm" name="adminForm" class="form-validate">
    <table cellpadding="0" cellspacing="0" border="0" max-width="120em" class="adminform">
        <tbody>
            <tr>
                <td width="10%" height="40">
                    <label id="namemsg" for="first_name">
                        <?=JText::_('Name');?>:
                    </label>
                </td>
                <td>
                    <?=JHTML::_('select.genericlist', PVCombo::gets('prefix'), 'prefix', 'class="input_box required"', 'idx', 'value', PVCombo::keySearch('prefix', $applicant->prefix), 'prefix')?>
                    <input type="text" name="first_name" id="first_name" size="18%" value="<?=$applicant->first_name?>" class="input_box required" maxlength="50" placeholder="<?=JText::_('FNAME PLACEHOLDER');?>" />
                    <input type="text" name="middle_name" id="middle_name" size="1%" value="<?=$applicant->middle_name?>" class="input_box optional" maxlength="25" />
                    <input type="text" name="last_name" id="last_name" size="18%" value="<?=$applicant->last_name?>" class="input_box required" maxlength="50" placeholder="<?=JText::_('LNAME PLACEHOLDER');?>" />
                    <?=JHTML::_('select.genericlist', PVCombo::gets('suffix'), 'suffix', 'class="input_box required"', 'idx', 'value', PVCombo::keySearch('suffix', $applicant->suffix), 'suffix')?>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" border="0" max-width="120em" class="adminform">
        <tbody>
            <tr>
                <td height="40">
                    <label id="address1msg" for="address1">
                        <?=JText::_('STREET ADDRESS');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="address1" name="address1" size="60%" value="<?=$applicant->address1?>" class="input_box required" maxlength="60" placeholder="<?=JText::_('STREET PLACEHOLDER');?>" />
                </td>
            </tr>
            <tr>
                <td height="40">
                    <label id="address2msg" for="address2">
                        <?=JText::_('APT_UNIT_SUITE');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="address2" name="address2" size="60%" value="<?=$applicant->address2?>" class="input_box optional" maxlength="60" />
                </td>
            </tr>
            <tr>
                <td height="40">
                    <label id="citymsg" for="city">
                        <?=JText::_('CITY');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="city" name="city" size="60%" value="<?=($applicant->city ? $applicant->city : 'Philadelphia')?>" class="input_box required" maxlength="60" placeholder="<?=JText::_('CITY PLACEHOLDER');?>" />
                </td>
            </tr>
            <tr>
                <td height="40">
                    <label id="regionmsg" for="region">
                        <?=JText::_('REGION');?>:
                    </label>
                </td>
                <td>
                    <?=JHTML::_('select.genericlist', PVCombo::gets('state'), 'region', 'class="input_box required"', 'idx', 'value', ($applicant->region ? $applicant->region : 'PA'), 'region')?>
                </td>
            </tr>
            <tr>
                <td height="40">
                    <label id="postcodemsg" for="postcode">
                        <?=JText::_('POSTCODE');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="postcode" name="postcode" size="60%" value="<?=$applicant->postcode?>" class="input_box required" maxlength="60" placeholder="<?=JText::_('POSTCODE PLACEHOLDER');?>" />
                </td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" border="0" max-width="120em" class="adminform">
        <tbody>
            <tr>
                <td height="40">
                    <label id="phonemsg" for="phone">
                        <?=JText::_('PHONE');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="phone" name="phone" size="60%" value="<?=$applicant->phone?>" class="input_box required" maxlength="100" placeholder="<?=JText::_('PHONE PLACEHOLDER');?>" />
                </td>
            </tr>
            <tr>
                <td height="40">
                    <label id="emailmsg" for="email">
                        <?=JText::_('EMAIL');?>:
                    </label>
                </td>
                <td>
                    <input type="text" id="email" name="email" size="60%" value="<?=$applicant->email?>" class="input_box" maxlength="100" />
                </td>
            </tr>
            <tr>
                <td height="40">&nbsp;</td>
                <td>
                    <button class="button validate" type="submit"><?=$this->isNew ? JText::_('REGISTER') : JText::_('UPDATE');?></button>
                    <input type="hidden" name="task" value="<?=$this->isNew ? 'register' : 'update'?>" />
                    <input type="hidden" name="controller" value="applicant" />
                    <input type="hidden" name="id" value="<?=$applicant->id?>" />
                    <input type="hidden" name="division_id" value="<?=$applicant->division_id?>" />
                    <?=JHTML::_('form.token');?>
                </td>
            </tr>
        </tbody>
    </table>
</form>