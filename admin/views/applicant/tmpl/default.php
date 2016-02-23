<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
// we'll need these for the combo
jimport("pvcombo.PVCombo");
if (count(JRequest::getVar('msg', null, 'post'))) {
	foreach (JRequest::getVar('msg', null, 'post') as $msg) {
		JError::raiseWarning(1, $msg);
	}
}
$applicant = $this->applicant;
?>
<form action="<?=JRoute::_('index.php?option=com_pvmachineinspectors');?>" method="post" id="adminForm" name="adminForm" class="form-validate">

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
<tr>
    <td width="30%" height="40">
        <label id="namemsg" for="first_name"><?=JText::_('NAME');?>:</label>
    </td>
    <td>
<?=JHTML::_('select.genericlist', PVCombo::gets('prefix'), 'prefix', 'class="inputbox required"', 'idx', 'value', PVCombo::keySearch('prefix', $appliant->prefix), true)?>
        <input type="text" name="first_name" id="first_name" size="18%" value="<?=$applicant->first_name?>" class="inputbox required" maxlength="50" placeholder="<?=JText::_('FNAME PLACEHOLDER');?>" />
        <input type="text" name="middle_name" id="middle_name" size="1%" value="<?=$applicant->middle_name?>" class="inputbox optional" maxlength="25" />
        <input type="text" name="last_name" id="last_name" size="18%" value="<?=$applicant->last_name?>" class="inputbox required" maxlength="50" placeholder="<?=JText::_('LNAME PLACEHOLDER');?>" />
<?=JHTML::_('select.genericlist', PVCombo::gets('suffix'), 'suffix', 'class="inputbox required"', 'idx', 'value', PVCombo::keySearch('suffix', $appliant->suffix), true)?>
    </td>

</tr>
<tr>
    <td height="40">
        <label id="address1msg" for="address1"><?=JText::_('STREET NAME');?>:</label>
    </td>
    <td>
        <input type="text" id="address1" name="address1" size="60%" value="<?=$applicant->address1?>" class="inputbox required" maxlength="60" placeholder="<?=JText::_('STREET ADDRESS PLACEHOLDER');?>" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="address2msg" for="address2"><?=JText::_('APT_UNIT_SUITE');?>:</label>
    </td>
    <td>
        <input type="text" id="address2" name="address2" size="60%" value="<?=$applicant->address2?>" class="inputbox optional" maxlength="60" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="citymsg" for="city"><?=JText::_('CITY');?>:</label>
    </td>
    <td>
        <input type="text" id="city" name="city" size="60%" value="<?=($applicant->city?$applicant->city:'Philadelphia')?>" class="inputbox required" maxlength="60" placeholder="<?=JText::_('CITY REQUIRED');?>" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="regionmsg" for="region"><?=JText::_('STATE');?>:</label>
    </td>
    <td>
<?=JHTML::_('select.genericlist', PVCombo::gets('state'), 'region', 'class="inputbox required"', 'idx', 'value', ($applicant->region?PVCombo::keySearch('state', $appliant->region):'PA'), true)?>
</td>
</tr>
<tr>
    <td height="40">
        <label id="postcodemsg" for="postcode"><?=JText::_('ZIPCODE');?>:</label>
    </td>
    <td>
        <input type="text" id="postcode" name="postcode" size="60%" value="<?=$applicant->postcode?>" class="inputbox required" maxlength="60" placeholder=<?=JText::_('ZIPCODE PLACEHOLDER');?> />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="phonemsg" for="phone"><?=JText::_('PHONE');?>:</label>
    </td>
    <td>
        <input type="text" id="phone" name="phone" size="60%" value="<?=$applicant->phone?>" class="inputbox" maxlength="100" placeholder="<?=JText::_('PHONE PLACEHOLDER');?>" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="emailmsg" for="email"><?=JText::_('EMAIL');?>:</label>
    </td>
    <td>
        <input type="text" id="email" name="email" size="60%" value="<?=$applicant->email?>" class="inputbox required" maxlength="100"  />
    </td>
</tr>
<tr>
    <td height="40">&nbsp;</td>
    <td>
        <button class="button validate" type="submit"><?=JText::_('UPDATE');?></button>
        <input type="hidden" name="task" value="update" />
        <input type="hidden" name="controller" value="applicant" />
        <input type="hidden" name="id" value="<?=$applicant->id?>" />
        <input type="hidden" name="division_id" value="<?=$applicant->division_id?>" />
<?=JHTML::_('form.token');?>
</td>
</tr>
</table>
</form>
