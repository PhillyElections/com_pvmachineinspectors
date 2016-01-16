<?php defined('_JEXEC') or die('Restricted access');
d($this->items);
?>
<form action="<?=JRoute::_('index.php?option=com_pvmachineinspectors');?>" method="post" name="adminForm">
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?=JText::_('ID');?>
			</th>
			<th width="5">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($this->items);?>);" />
			</th>
			<th>
				<?=JText::_('Name');?>
			</th>
			<th width="5">
				<?=JText::_('Ward');?>
			</th>
			<th width="5">
				<?=JText::_('Division');?>
			</th>
			<th>
				<?=JText::_('Phone');?>
			</th>
			<th>
				<?=JText::_('Email');?>
			</th>
		</tr>
	</thead>
	<?php
$k = 0;
for ($i = 0, $n = count($this->items); $i < $n; $i++) {
    $row = &$this->items[$i];
    $checked = JHTML::_('grid.id', $i, $row->id);
    $link = JRoute::_('index.php?option=com_pvmachineinspectors&controller=applicant&task=edit&cid[]=' . $row->id);
    $fullname = ($row->prefix ? $row->prefix . " " : "") . $row->first_name . " " . ($row->middle_name ? $row->middle_name . " " : "") . $row->last_name . " " . ($row->suffix ? ", " . $row->suffix : "");
    $matches = '';
    preg_match('/^(\d{3})(\d{3})(\d{4})$/', $row->phone, $matches);

    ?>
		<tr class="<?="row$k";?>">
			<td>
				<?=$row->id;?>
			</td>
			<td>
				<?=$checked;?>
			</td>
			<td>
				<a href="<?=$link;?>"><?=$fullname;?></a>
			</td>
			<td>
				<?=$row->ward;?>
			</td>
			<td>
				<?=$row->division;?>
			</td>
			<td>
				<?=count($matches) ? sprintf("(%d) %d-%d", $matches[1], $matches[2], $matches[3]) : '';?>
			</td>
			<td>
				<?=$row->email;?>
			</td>
		</tr>
		<?php
$k = 1 - $k;
}
?>
	</table>
</div>
<?=JHTML::_('form.token');?>
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="applicant" />
<?=JHTML::_('form.token');?>
</form>
