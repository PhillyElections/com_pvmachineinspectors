<?php 
defined('_JEXEC') or die('Restricted access');
$pagination = &$this->pagination;

jimport("pvcombo.PVCombo");

$document = &JFactory::getDocument();
$document->addCustomTag('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>');
$document->addCustomTag('<script src="components/com_pvmachineinspectors/assets/js/filter.js"></script>');
$document->addCustomTag('<script src="/media/multi-column-select/Multi-Column-Select/Multi-Column-Select.js" async defer></script>');
$document->addStyleSheet('components/com_pvmachineinspectors/assets/css/filter.css');
?>
<form action="<?=JRoute::_('index.php?option=com_pvmachineinspectors');?>" method="post" name="adminForm" id="adminForm">
	<div id="editcell">
		<table class="adminlist">
			<thead>
<?php 
// show if there are any results or if there's a ward filter set
if (count($this->items) or JRequest::getVar('ward')):
?>
                <tr>
                    <th colspan="10">
                    <div data-filter="Filter by Wards">
                        <?=JHTML::_('select.genericlist', PVCombo::getsFromObject($this->wards, 'ward', 'ward'), 'ward[]', 'multiple ', 'idx', 'value', (JRequest::getVar('ward') ? JRequest::getVar('ward') : ''), 'ward');?></div>
                    <!--<div data-filter="Filter by Date">&nbsp;</div>--></th>
                </tr>
<?php
endif;
?>
				<tr>
					<th width="5">
						<?=JText::_('ID');?>
					</th>
					<th width="5">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($this->items);?>);" />
					</th>
					<th width="5">
						<?=JText::_('WARD');?>
					</th>
					<th width="5">
						<?=JText::_('DIVISION');?>
					</th>
					<th>
						<?=JText::_('NAME');?>
					</th>
					<th>
						<?=JText::_('PHONE');?>
					</th>
					<th>
						<?=JText::_('EMAIL');?>
					</th>
					<th>
						<?=JText::_('STREET ADDRESS');?>
					</th>
					<th>
						<?=JText::_('POSTCODE');?>
					</th>
					<th>
						<?=JText::_('DATE');?>
					</th>
				</tr>
			</thead>
			<?php
$k = 0;
for ($i = 0, $n = count($this->items); $i < $n; $i++) {
    $row      = &$this->items[$i];
    $checked  = JHTML::_('grid.id', $i, $row->id);
    $link     = JRoute::_('index.php?option=com_pvmachineinspectors&controller=applicant&task=edit&cid[]=' . $row->id);
    $fullname = ($row->prefix ? $row->prefix . " " : "") . $row->first_name . " " . ($row->middle_name ? $row->middle_name . " " : "") . $row->last_name . ($row->suffix ? ", " . $row->suffix : "");
    $matches  = '';
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
				    <?=$row->ward;?>
				</td>
				<td>
					<?=$row->division;?>
				</td>
				<td>
					<a href="<?=$link;?>"><?=$fullname;?></a>
				</td>
				<td>
					<?=count($matches) ? sprintf("(%d) %d-%d", $matches[1], $matches[2], $matches[3]) : '';?>
				</td>
				<td>
					<?=$row->email;?>
				</td>
				<td>
					<?=$row->address1 . ($row->address2 ? ' ' . $row->address2 : '');?>
				</td>
				<td>
					<?=$row->postcode;?>
				</td>
				<td>
					<?=$row->created;?>
				</td>
			</tr>
			<?php
$k = 1 - $k;
}
?>
			<tfoot>
			<tr>
				<td colspan="10"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
			</tfoot>
		</table>
	</div>
	<?=JHTML::_('form.token');?>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="applicants" />
	<?=JHTML::_('form.token');?>
</form>