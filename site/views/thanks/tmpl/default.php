<?php 
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php

  if(isset($this->message)){
    $this->display('message');
  }
?>

<div> after displaying the thank you message, redirect to the main page</div>

