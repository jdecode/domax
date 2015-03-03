<?php /*<div class="table">

    <h2><?php echo __('Upload'); ?></h2>
    <table width="80%">
        <tr>
            <td><?php echo __('User'); ?></td><td><?php echo $this->Html->link($upload['User']['username'], array('controller' => 'users', 'action' => 'view', $upload['User']['id'])); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Filename'); ?></td><td><?php echo h($upload['Upload']['filename']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Upload By'); ?></td><td><?php echo h($uploadby[$upload['Upload']['upload_by']]); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Description'); ?></td><td><?php echo h($upload['Upload']['description']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Created'); ?></td><td><?php echo h($upload['Upload']['created']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Modified'); ?></td><td><?php echo h($upload['Upload']['modified']); ?></td>
        </tr>
    </table>
</div>
*/?>


<div class="content-panel">
	<hr>
	<table class="table">
		<thead>
			<tr>
				
				<th><?php echo __('User'); ?></th>
				<td><?php echo $this->Html->link($upload['User']['username'], array('controller' => 'users', 'action' => 'view', $upload['User']['id'])); ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th><?php echo __('Filename'); ?></th>
				<td><?php echo h($upload['Upload']['filename']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Upload By'); ?></th>
				<td><?php echo h($uploadby[$upload['Upload']['upload_by']]); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Description'); ?></th>
				<td><?php echo h($upload['Upload']['description']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Created'); ?></th>
				<td><?php echo h($upload['Upload']['created']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Modified'); ?></th>
				<td><?php echo h($upload['Upload']['modified']); ?></td>
			</tr>
		</tbody>
	</table>
</div>
