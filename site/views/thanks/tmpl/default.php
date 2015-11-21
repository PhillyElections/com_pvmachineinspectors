<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="javascript">
document.write('blow me');

</script>
<?php

  if(isset($this->message)){
    $this->display('message');
  }
?>

<div> after displaying the thank you message, redirect to the main page</div>

