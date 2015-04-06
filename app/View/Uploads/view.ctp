<?php //pr($message);
  //pr($uploadby);
 // die;
?>
<div class="content-panel">
	<hr>
	<table class="table">
		<thead>
			<tr>
				
				<th><?php echo __('User'); ?></th>
				<td><?php echo $this->Html->link($message['Receiver']['username'], array('controller' => 'users', 'action' => 'view', $message['Receiver']['id'])); ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th><?php echo __('Filename'); ?></th>
				<td><?php echo h($message['Document']['filename']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Upload By'); ?></th>
				<td><?php echo h($message['User']['username']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Description'); ?></th>
				<td><?php echo h($message['Message']['message']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Created'); ?></th>
				<td><?php echo h($message['Message']['created']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Modified'); ?></th>
				<td><?php echo h($message['Message']['modified']); ?></td>
			</tr>
		</tbody>
	</table>
</div>
