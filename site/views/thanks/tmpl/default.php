<?php
// no direct access
defined('_JEXEC') or die('Restricted access');?>

<?php

if (isset($this->message)) {
	$this->display('message');
}
?>
<p><?=JText::_("THANK YOU")?></p>