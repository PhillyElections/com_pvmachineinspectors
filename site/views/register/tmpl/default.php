<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$document = &JFactory::getDocument();
jimport("pvcombo.PVCombo");
jimport("kint.kint");
if (count(JRequest::getVar('msg', null, 'post'))) {
    foreach (JRequest::getVar('msg', null, 'post') as $msg) {
        JError::raiseWarning(1, $msg);
    }
}
// lets go through the post array and extract any existing values for display
$fields = array('prefix', 'first_name', 'middle_name', 'last_name', 'suffix', 'division', 'address1', 'address2', 'city', 'region', 'postcode', 'phone', 'email');
foreach ($fields as $field) {
    $$field = JRequest::getVar($field, null, 'post');
}

//$document->addScript('http://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete');
$document->addScript(JURI::root(true) . '/components/com_pvmachineinspectors/assets/js/machineinspectors.js');
$document->addCustomTag('<script src="http://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete" async defer></script>');
?>
<form action="<?=JRoute::_('index.php?option=com_pvmachineinspectors');?>" method="post" id="josForm" name="josForm" class="form-validate">

<div class="componentheading"><?=$this->escape($this->params->get('page_title'));?></div>
    <table id="address">
      <tr>
        <td class="label">Street address</td>
        <td class="slimField"><input class="field" id="street_number"
              disabled="true"></input></td>
        <td class="wideField" colspan="2"><input class="field" id="route"
              disabled="true"></input></td>
      </tr>
      <tr>
        <td class="label">City</td>
        <td class="wideField" colspan="3"><input class="field" id="locality"
              disabled="true"></input></td>
      </tr>
      <tr>
        <td class="label">State</td>
        <td class="slimField"><input class="field"
              id="administrative_area_level_1" disabled="true"></input></td>
        <td class="label">Zip code</td>
        <td class="wideField"><input class="field" id="postal_code"
              disabled="true"></input></td>
      </tr>
      <tr>
        <td class="label">Country</td>
        <td class="wideField" colspan="3"><input class="field"
              id="country" disabled="true"></input></td>
      </tr>
    </table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
<tr>
	<td width="30%" height="40">
		<label id="namemsg" for="first_name"><?=JText::_('Name');?>:</label>
	</td>
  	<td>
<?=JHTML::_('select.genericlist', PVCombo::gets('prefix'), 'prefix', 'class="inputbox required"', 'idx', 'value', $prefix, true)?>
  		<input type="text" name="first_name" id="first_name" size="18%" value="<?=$first_name?>" class="inputbox required" maxlength="50" placeholder="<?=JText::_('FNAME PLACEHOLDER');?>" />
  		<input type="text" name="middle_name" id="middle_name" size="1%" value="<?=$middle_name?>" class="inputbox optional" maxlength="25" />
  		<input type="text" name="last_name" id="last_name" size="18%" value="<?=$last_name?>" class="inputbox required" maxlength="50" placeholder="<?=JText::_('LNAME PLACEHOLDER');?>" />
<?=JHTML::_('select.genericlist', PVCombo::gets('suffix'), 'suffix', 'class="inputbox required"', 'idx', 'value', $suffix, true)?>
  	</td>

</tr>
<tr>
	<td height="40">
		<label id="address1msg" for="address1"><?=JText::_('STREET ADDRESS');?>:</label>
	</td>
	<td>
    <td id="locationField">
      <input id="autocomplete" placeholder="Enter your address"
             onFocus="geolocate()" type="text"></input>
	</td>
</tr>
<tr>
	<td height="40">
		<label id="address1msg" for="address1"><?=JText::_('STREET ADDRESS');?>:</label>
	</td>
	<td>
		<input type="text" id="address1" name="address1" size="60%" value="<?=$address1?>" class="inputbox required" maxlength="60" placeholder="<?=JText::_('STREET PLACEHOLDER');?>" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="address2msg" for="address2"><?=JText::_('APT_UNIT_SUITE');?>:</label>
	</td>
	<td>
		<input type="text" id="address2" name="address2" size="60%" value="<?=$address2?>" class="inputbox optional" maxlength="60" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="citymsg" for="city"><?=JText::_('CITY');?>:</label>
	</td>
	<td>
		<input type="text" id="city" name="city" size="60%" value="<?=($city ? $city : 'Philadelphia')?>" class="inputbox required" maxlength="60" placeholder="<?=JText::_('CITY PLACEHOLDER');?>" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="regionmsg" for="region">
<?=JText::_('REGION');?>:
		</label>
	</td>
	<td><? /*=JHTML::_('select.genericlist', PVCombo::gets('state'), 'region', 'class="inputbox required"', 'idx', 'value', ($region ? $region : 'PA'), true)*/?><input type="text" id="state" name="state" size="60%" value="<?=($region ? $region : 'PA')?>" /></td>
</tr>
<tr>
	<td height="40">
		<label id="postcodemsg" for="postcode">
<?=JText::_('POSTCODE');?>:
		</label>
	</td>
	<td>
		<input type="text" id="postcode" name="postcode" size="60%" value="<?=$postcode?>" class="inputbox required" maxlength="60" placeholder="<?=JText::_('POSTCODE PLACEHOLDER');?>" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="phonemsg" for="phone">
<?=JText::_('PHONE');?>:
		</label>
	</td>
	<td>
		<input type="text" id="phone" name="phone" size="60%" value="<?=$phone?>" class="inputbox required" maxlength="100" placeholder="<?=JText::_('PHONE PLACEHOLDER');?>" />
	</td>
</tr>
<tr>
	<td height="40">
		<label id="emailmsg" for="email">
<?=JText::_('EMAIL');?>:
		</label>
	</td>
	<td>
		<input type="text" id="email" name="email" size="60%" value="<?=$email?>" class="inputbox" maxlength="100" />
	</td>
</tr>
<tr>
	<td height="40">&nbsp;</td>
	<td>
		<button class="button validate" type="submit"><?=JText::_('REGISTER');?></button>
		<input type="hidden" name="task" value="save" />
	</td>
</tr>
</table>

<?=JHTML::_('form.token');?>
</form>