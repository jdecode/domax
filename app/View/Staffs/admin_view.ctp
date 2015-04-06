<div class="col-md-12">
	<div class="content-panel">
		<hr>
		<table class="table">
			<tbody>
				<tr>
					<th><?php echo __('Staff Name'); ?></th>
					<td><?php echo $this->Html->link($staff['Staff']['name'], array('controller' => 'users', 'action' => 'view', $staff['User']['id'])); ?></td>
				</tr>
				<tr>
					<th><?php echo __('Email ID'); ?></th>
					<td><?php echo $this->Html->link($staff['Staff']['email'], 'mailto:' . $staff['Staff']['email']); ?></td>
				</tr>
				<tr>
					<th><?php echo __('Father Name'); ?></th>
					<td><?php echo h($staff['Staff']['father_name']); ?></td>
				</tr>
				<tr>
					<th><?php echo __('Dob'); ?></th>
					<td><?php echo h($staff['Staff']['dob']); ?></td>
				</tr>
				<tr>
					<th><?php echo __('References'); ?></th>
					<td><?php echo h($staff['Staff']['references']); ?></td>
				</tr>
				<tr>
					<th><?php echo __('Department'); ?></th>
					<td><?php echo h($depart[$staff['Staff']['department_id']]); ?></td>
				</tr>
			</tbody>
		</table>

		<div class="row">
			<div class="col-sm-3"><?php echo $this->Html->link('Back', array("controller" => "staffs", "action" => "index"), array("class" => "btn btn-theme")); ?></div>

		</div>
	</div>
</div>