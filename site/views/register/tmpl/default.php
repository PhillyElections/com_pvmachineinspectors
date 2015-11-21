<?php // no direct access
defined('_JEXEC') or die('Restricted access');

if (isset($this->message)) {
	$this->display('message');
}

$fname    = JRequest::getVar('fname', null, 'post', 'string');
$mname    = JRequest::getVar('mname', null, 'post', 'string');
$lname    = JRequest::getVar('lname', null, 'post', 'string');
$division = JRequest::getVar('division', null, 'post', 'string');
$addr1    = JRequest::getVar('address1', null, 'post', 'string');
$addr2    = JRequest::getVar('address2', null, 'post', 'string');
$addr3    = JRequest::getVar('address3', null, 'post', 'string');
$city     = JRequest::getVar('city', null, 'post', 'string');
$province = JRequest::getVar('province', null, 'post', 'string');
$postcode = JRequest::getVar('postcode', null, 'post', 'string');
$email    = JRequest::getVar('email', null, 'post', 'string');
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
<?=JHTML::_('select.genericlist', $this->getTitles(), 'prefix', 'class="inputbox required"', 'idx', 'title', '1', 'true')?>
  		<input type="text" name="fname" id="fname" size="45%" value="<?=$fname?>" class="inputbox required" maxlength="50" placeholder="(firstname is required)" />
  		<input type="text" name="mname" id="mname" size="6%" value="<?=$mname?>" class="inputbox optional" maxlength="25" />
  		<input type="text" name="lname" id="lname" size="45%" value="<?=$lname?>" class="inputbox required" maxlength="50" placeholder="(lastname is required)" />
  	</td>

</tr>
<tr>
	<td height="40">
		<label id="address1msg" for="address1">
<?=JText::_('Street Address');?>:
		</label>
	</td>
	<td>
		<input type="text" id="address1" name="address1" size="60" value="<?=$addr1?>" class="inputbox required" maxlength="60" placeholder="(street address is required)" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="address2msg" for="address2">
<?=JText::_('Apt/Unit/Suite');?>:
		</label>
	</td>
	<td>
		<input type="text" id="address2" name="address2" size="60" value="<?=$addr2?>" class="inputbox optional" maxlength="60" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="address3msg" for="address3">
<?=JText::_('Addtl Addr Info');?>:
		</label>
	</td>
	<td>
		<input type="text" id="address3" name="address3" size="60" value="<?=$addr3?>" class="inputbox optional" maxlength="60" /> *
	</td>
</tr>
<tr>
	<td height="40">
		<label id="citymsg" for="city">
<?=JText::_('City');?>:
		</label>
	</td>
	<td>
		<input type="text" id="city" name="city" size="60" value="<?=($city?$city:'Philadelphia')?>" class="inputbox required" maxlength="60" placeholder="(city is required)" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="provincemsg" for="province">
<?=JText::_('State');?>:
		</label>
	</td>
	<td>
<?=JHTML::_('select.genericlist', $this->getUSStates(), 'province', 'class="inputbox required"', 'abbr', 'state', ($postcode?$postcode:'PA'), 'true')?>
</td>
</tr>
<tr>
	<td height="40">
		<label id="postcodemsg" for="postcode">
<?=JText::_('Zipcode');?>:
		</label>
	</td>
	<td>
		<input type="text" id="postcode" name="postcode" size="60" value="<?=$postcode?>" class="inputbox required" maxlength="60" placeholder="(zip is required)" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="emailmsg" for="email">
<?=JText::_('Email');?>:
		</label>
	</td>
	<td>
		<input type="text" id="email" name="email" size="40" value="<?=$email?>" class="inputbox validate-email" maxlength="100" /> *
	</td>
</tr>
</table>
	<button class="button validate" type="submit"><?=JText::_('Register');?></button>
	<input type="hidden" name="task" value="register_save" />
<?php echo JHTML::_('form.token');?>
</form>
