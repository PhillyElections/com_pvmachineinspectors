<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport("pvcombo.PVCombo");

if (count(JRequest::getVar('msg', null, 'post'))) {
    foreach (JRequest::getVar('msg', null, 'post') as $msg) {
        JError::raiseWarning(1, $msg);
    }
}
// lets go through the post array and extract any existing values for display
$fields = array('prefix', 'fname', 'mname', 'lname', 'suffix', 'division', 'address1', 'address2', 'city', 'region', 'postcode', 'phone', 'email');
foreach ($fields as $field) {
    $$field = JRequest::getVar($field, null, 'post');
}

?>
<form action="<?=JRoute::_('index.php?option=com_pvmachineinspectors');?>" method="post" id="josForm" name="josForm" class="form-validate">

<div class="componentheading"><?=$this->escape($this->params->get('page_title'));?></div>

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
<tr>
	<td width="30%" height="40">
		<label id="namemsg" for="fname">
<?=JText::_('Name');?>:
		</label>
	</td>
  	<td>
		<?=JHTML::_('select.genericlist', PVCombo::gets('prefix'), 'prefix', 'class="inputbox required"', 'idx', 'value', $prefix, true)?>
  		<input type="text" name="fname" id="fname" size="18%" value="<?=$fname?>" class="inputbox required" maxlength="50" placeholder="(firstname is required)" />
  		<input type="text" name="mname" id="mname" size="1%" value="<?=$mname?>" class="inputbox optional" maxlength="25" />
  		<input type="text" name="lname" id="lname" size="18%" value="<?=$lname?>" class="inputbox required" maxlength="50" placeholder="(lastname is required)" />
		<?=JHTML::_('select.genericlist', PVCombo::gets('suffix'), 'suffix', 'class="inputbox required"', 'idx', 'value', $suffix, true)?>
  	</td>

</tr>
<tr>
	<td height="40">
		<label id="address1msg" for="address1">
<?=JText::_('Street Address');?>:
		</label>
	</td>
	<td>
		<input type="text" id="address1" name="address1" size="60%" value="<?=$address1?>" class="inputbox required" maxlength="60" placeholder="(street address is required)" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="address2msg" for="address2">
<?=JText::_('Apt/Unit/Suite');?>:
		</label>
	</td>
	<td>
		<input type="text" id="address2" name="address2" size="60%" value="<?=$address2?>" class="inputbox optional" maxlength="60" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="citymsg" for="city">
<?=JText::_('City');?>:
		</label>
	</td>
	<td>
		<input type="text" id="city" name="city" size="60%" value="<?=($city ? $city : 'Philadelphia')?>" class="inputbox required" maxlength="60" placeholder="(city is required)" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="regionmsg" for="region">
<?=JText::_('State');?>:
		</label>
	</td>
	<td>
<?=JHTML::_('select.genericlist', PVCombo::gets('state'), 'region', 'class="inputbox required"', 'idx', 'value', ($region ? $region : 'PA'), true)?>
</td>
</tr>
<tr>
	<td height="40">
		<label id="postcodemsg" for="postcode">
		<?=JText::_('Zipcode');?>:
		</label>
	</td>
	<td>
		<input type="text" id="postcode" name="postcode" size="60%" value="<?=$postcode?>" class="inputbox required" maxlength="60" placeholder="(zip is required)" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="emailmsg" for="phone">
			<?=JText::_('Phone');?>:
		</label>
	</td>
	<td>
		<input type="text" id="phone" name="phone" size="60%" value="<?=$phone?>" class="inputbox" maxlength="100" placeholder="(either email or phone required)" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="emailmsg" for="email">
			<?=JText::_('Email');?>:
		</label>
	</td>
	<td>
		<input type="text" id="email" name="email" size="60%" value="<?=$email?>" class="inputbox" maxlength="100" placeholder="(either email or phone required)" />
	</td>
</tr>
<tr>
	<td height="40">&nbsp;</td>
	<td>
		<button class="button validate" type="submit"><?=JText::_('Register');?></button>
		<input type="hidden" name="task" value="register_save" />
	</td>
</tr>
</table>

<?=JHTML::_('form.token');?>
</form>
