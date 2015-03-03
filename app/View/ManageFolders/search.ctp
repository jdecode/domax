<table width="100%" cellspacing="0" cellpadding="0" border="0">
       <tr>
			<th><?php echo $this->Paginator->sort('id','Sr No');?></th>
			<th><?php echo $this->Paginator->sort('user_id','Client');?></th>
			<th><?php echo $this->Paginator->sort('filename');?></th>
			<th><?php echo $this->Paginator->sort('upload_by');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
   
	foreach ($uploads as $upload):?>
	<tr>
		<td><?php echo h($upload['Upload']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($upload['User']['username'], array('controller' => 'users', 'action' => 'view', $upload['User']['id'])); ?>
		</td>
		<td><?php echo h($upload['Upload']['filename']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($users[$upload['Upload']['upload_by']], array('controller' => 'users', 'action' => 'view', $upload['Upload']['upload_by'])); ?>&nbsp;</td>
		<td><?php echo h($upload['Upload']['created']); ?>&nbsp;</td>
		<td><?php echo h($upload['Upload']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $upload['Upload']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $upload['Upload']['id'])); ?>
		<?php if($_SESSION['Auth']['User']['group_id']=='1') { ?>	
		<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $upload['Upload']['id']), null, __('Are you sure you want to delete # %s?', $upload['Upload']['id'])); ?>
<?php } ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>