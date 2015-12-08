<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

if (isset($this->message)) {
    $this->display('message');
}

$fields = array('prefix', 'fname', 'mname', 'lname', 'suffix', 'division', 'address1', 'address2', 'city', 'region', 'postcode', 'email');
foreach ($fields as $field) {
    $$field = JRequest::getVar($field, null, 'post', 'string');
}

jimport("combo.Combo");
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
		<?=JHTML::_('select.genericlist', Combo::getPrefixes(), 'prefix', 'class="inputbox required"', 'idx', 'value', '', 'true')?>
  		<input type="text" name="fname" id="fname" size="20%" value="<?=$fname?>" class="inputbox required" maxlength="50" placeholder="(firstname is required)" />
  		<input type="text" name="mname" id="mname" size="1%" value="<?=$mname?>" class="inputbox optional" maxlength="25" />
  		<input type="text" name="lname" id="lname" size="20%" value="<?=$lname?>" class="inputbox required" maxlength="50" placeholder="(lastname is required)" />
		<?=JHTML::_('select.genericlist', Combo::getSuffixes(), 'suffix', 'class="inputbox required"', 'idx', 'value', '', 'true')?>
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
<?=JHTML::_('select.genericlist', Combo::getUSStates(), 'region', 'class="inputbox required"', 'idx', 'value', ($region ? $region : 'PA'), 'true')?>
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
		<label id="emailmsg" for="email">
<?=JText::_('Email');?>:
		</label>
	</td>
	<td>
		<input type="text" id="email" name="email" size="60%" value="<?=$email?>" class="inputbox validate-email" maxlength="100" />
	</td>
</tr>
</table>
	<button class="button validate" type="submit"><?=JText::_('Register');?></button>
	<input type="hidden" name="task" value="register_save" />
<?php echo JHTML::_('form.token'); ?>
</form>
