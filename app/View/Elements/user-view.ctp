<?php 
//pr($user);
//pr($document);
//pr($upload);
?>




<div class="content-panel">
	<hr>
	<table class="table">
		<tbody>
			<tr>
				<th><?php echo __('Username: '); ?></th>
				<td><?php echo h($user['User']['username']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Pan No: '); ?></th>
				<td><?php echo h($user['Client']['pancard']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('File No: '); ?></th>
				<td><?php echo h($user['Client']['fileno']); ?></td>
			</tr>
			<tr>
				<th><?php echo __('Bussiness: '); ?></th>
				<td><?php echo h($user['Client']['bussiness_name']); ?></td>
			</tr>
		</tbody>
	</table>

	<hr/>
	<?php //echo $this->Form->create('Message', array('url' => array('controller' =>'messages', 'action' => 'delete' ,'admin'=>true ))); ?>
	<table class="table table-striped table-advance table-hover">
		<thead>

			<tr>
				<!--<th>&nbsp;</th>	-->
				<th><?php echo __('Name of file'); ?></th>
				<th><?php echo __('Date of Upload'); ?></th>
				<th><?php echo __('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($document as $documents): ?>
			<tr>
					<!--<td><input name="data['Message']['id'][]" value=<?php echo $documents['Message']['id']; ?>></td>-->
					<td><?php echo $documents['Document']['filename']; ?></td>
					<td><?php echo $documents['Document']['created']; ?></td>
			<td><?php echo $this->Html->link('<span class="btn btn-primary">Download</span>', '/app/webroot/files/uploads/' . $documents['Document']['filename'], array('escape' => false, 'target' => '_blank')); ?>&nbsp;</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php //echo $this->Form->end('Delete'); ?>
</div>

