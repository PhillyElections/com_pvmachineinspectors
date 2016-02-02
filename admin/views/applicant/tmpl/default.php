<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
// we'll need these for the combo boxes
jimport("pvcombo.PVCombo");

?>
<form action="<?=JRoute::_('index.php?option=com_pvmachineinspectors');?>" method="post" id="josForm" name="josForm" class="form-validate">

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
<tr>
    <td width="30%" height="40">
        <label id="namemsg" for="first_name">
<?=JText::_('Name');?>:
        </label>
    </td>
    <td>
        <?=JHTML::_('select.genericlist', PVCombo::gets('prefix'), 'prefix', 'class="inputbox required"', 'idx', 'value', PVCombo::get('prefix', $this->applicant->prefix), true)?>
        <input type="text" name="first_name" id="first_name" size="18%" value="<?=$this->applicant->first_name?>" class="inputbox required" maxlength="50" placeholder="(firstname is required)" />
        <input type="text" name="middle_name" id="middle_name" size="1%" value="<?=$this->applicant->middle_name?>" class="inputbox optional" maxlength="25" />
        <input type="text" name="last_name" id="last_name" size="18%" value="<?=$this->applicant->last_name?>" class="inputbox required" maxlength="50" placeholder="(lastname is required)" />
        <?=JHTML::_('select.genericlist', PVCombo::gets('suffix'), 'suffix', 'class="inputbox required"', 'idx', 'value', PVCombo::get('suffix', $this->applicant->suffix), true)?>
    </td>

</tr>
<tr>
    <td height="40">
        <label id="address1msg" for="address1">
<?=JText::_('Street Address');?>:
        </label>
    </td>
    <td>
        <input type="text" id="address1" name="address1" size="60%" value="<?=$this->applicant->address1?>" class="inputbox required" maxlength="60" placeholder="(street address is required)" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="address2msg" for="address2">
<?=JText::_('Apt/Unit/Suite');?>:
        </label>
    </td>
    <td>
        <input type="text" id="address2" name="address2" size="60%" value="<?=$this->applicant->address2?>" class="inputbox optional" maxlength="60" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="citymsg" for="city">
<?=JText::_('City');?>:
        </label>
    </td>
    <td>
        <input type="text" id="city" name="city" size="60%" value="<?=($this->applicant->city ? $this->applicant->city : 'Philadelphia')?>" class="inputbox required" maxlength="60" placeholder="(city is required)" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="regionmsg" for="region">
<?=JText::_('State');?>:
        </label>
    </td>
    <td>
<?=JHTML::_('select.genericlist', PVCombo::gets('state'), 'region', 'class="inputbox required"', 'idx', 'value', ($this->applicant->region ? PVCombo::get('state', $this->applicant->region) : 'PA'), true)?>
</td>
</tr>
<tr>
    <td height="40">
        <label id="postcodemsg" for="postcode">
        <?=JText::_('Zipcode');?>:
        </label>
    </td>
    <td>
        <input type="text" id="postcode" name="postcode" size="60%" value="<?=$this->applicant->postcode?>" class="inputbox required" maxlength="60" placeholder="(zip is required)" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="phonemsg" for="phone">
            <?=JText::_('Phone');?>:
        </label>
    </td>
    <td>
        <input type="text" id="phone" name="phone" size="60%" value="<?=$this->applicant->phone?>" class="inputbox" maxlength="100" placeholder="(either email or phone required)" />
    </td>
</tr>
<tr>
    <td height="40">
        <label id="emailmsg" for="email">
            <?=JText::_('Email');?>:
        </label>
    </td>
    <td>
        <input type="text" id="email" name="email" size="60%" value="<?=$this->applicant->email?>" class="inputbox" maxlength="100" placeholder="(either email or phone required)" />
    </td>
</tr>
<tr>
    <td height="40">&nbsp;</td>
    <td>
        <button class="button validate" type="submit"><?=$this->isNew ? JText::_('Register') : JText::_('Update');?></button>
        <input type="hidden" name="task" value="<?=$this->isNew ? 'register' : 'update'?>" />
        <input type="hidden" name="controller" value="applicant" />
        <input type="hidden" name="id" value="<?=$this->applicant->id?>" />
        <input type="hidden" name="division_id" value="<?=$this->applicant->division_id?>" />
        <?=JHTML::_('form.token');?>
    </td>
</tr>
</table>
</form>
