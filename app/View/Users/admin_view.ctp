<?php /* <div class="table">
  <?php //debug($user); ?>
  <h2><?php echo __('User'); ?></h2>

  <table width="100%" align="center">
  <tr>
  <td>&nbsp;</td>
  <td><?php echo __('Username :'); ?></td><td><?php echo h($user['User']['username']); ?></td>
  <td><?php echo __('Pan No :'); ?></td><td><?php echo h($user['Client']['pancard']); ?></td>
  <td><?php echo __('File No :'); ?></td><td><?php echo h($user['Client']['fileno']); ?></td>
  <td><?php echo __('Bussiness :'); ?></td><td><?php echo h($user['Client']['bussiness_name']); ?></td>
  </tr>

  </table>
  <br><h2 style="margin-left: 100px;">Uploaded Files</h2><br>
  <?php echo $this->Form->create('Upload', array('action' => 'admin_delete1')); ?>
  <table width="100%" align="center">

  <tr>
  <td>&nbsp;</td><td><?php echo __('Name of file'); ?></td><td><?php echo __('Date of Upload'); ?></td><td><?php echo __('Action'); ?></td>
  </tr>
  <?php foreach ($upload as $uploads): ?>
  <tr>
  <td><td><input type="checkbox"  name="data[Upload][id][]" value=<?php echo $uploads['Upload']['id']; ?>></td></td><td><?php echo $uploads['Upload']['filename']; ?></td><td><?php echo $uploads['Upload']['created']; ?></td><td><?php echo $this->Html->link('Delete', array('controller' => 'uploads', 'action' => 'delete', $uploads['Upload']['id'])); ?></td>
  </tr>
  <?php endforeach; ?>
  </table>
  <?php echo $this->Form->end('Delete'); ?>
  </div>
 */ ?>




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
	<?php echo $this->Form->create('Upload', array('action' => 'admin_delete1')); ?>
	<table class="table table-striped table-advance table-hover">
		<thead>

			<tr>
				<th>&nbsp;</th>	
				<th><?php echo __('Name of file'); ?></th>
				<th><?php echo __('Date of Upload'); ?></th>
				<th><?php echo __('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($upload as $uploads): ?>
				<tr>
					<td><input type="checkbox"  name="data[Upload][id][]" value=<?php echo $uploads['Upload']['id']; ?>></td>
					<td><?php echo $uploads['Upload']['filename']; ?></td>
					<td><?php echo $uploads['Upload']['created']; ?></td>
					<td><?php echo $this->Html->link('<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>', array('controller' => 'uploads', 'action' => 'delete', $uploads['Upload']['id']), array("escape" => false)); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo $this->Form->end('Delete'); ?>
</div>

