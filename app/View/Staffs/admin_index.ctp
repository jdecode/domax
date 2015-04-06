<?php
$page = isset($this->params->params['named']['page']) && is_numeric($this->params->params['named']['page']) ? $this->params->params['named']['page'] : 1;
echo $page;
?>
<div class="col-md-12">
	<div class="content-panel">
		<table class="table table-striped table-advance table-hover">
			<h4><i class="fa fa-angle-right"></i> Staff</h4>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Html->link('<span aria-hidden="true" class="glyphicon glyphicon-plus"></span><span aria-hidden="true" class="glyphicon glyphicon-user"></span>', array("controller" => "staffs", "action" => "add", "admin" => true), array("escape" => false, "class" => "btn-lg pull-right", "title" => "Add Staff")); ?>
			<div class=" clear">&nbsp;</div>
			<hr>
			<thead>
				<?php echo $this->Form->create("Staff", array("url" => array("controller" => "staffs", "action" => "index"), "type" => "get")) ?>
				<tr>
					<th><?php echo $this->Paginator->sort('id', 'Sr No'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id', 'Staff Name'); ?></th>
					<th><?php echo $this->Paginator->sort('father_name'); ?></th>
					<th><?php echo $this->Paginator->sort('dob'); ?></th>
					<th><?php echo $this->Paginator->sort('department'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td><?php echo $this->Form->input('staff_name', array('label' => false, "class" => "form-control input-sm", "required" => false)); ?></td>
					<td><?php echo $this->Form->input('father_name', array('label' => false, "class" => "form-control input-sm", "required" => false)); ?></td>
					<td>&nbsp;</td>
					<td><?php echo $this->Form->input('dept', array('type' => 'select', 'options' => $dept_list, 'empty' => 'Select', 'label' => false, "class" => "form-control input-sm")); ?></td>
					<td><?php echo $this->Form->input("Filter", array("type" => "submit", "label" => false, "class" => "btn btn-sm btn-theme")); ?></td>
				</tr>
				<?php echo $this->Form->end(); ?>

			</thead>
			<tbody>

				<?php
				if (!empty($staffs)) {
					$i = 1+(($page-1)*10);
					foreach ($staffs as $staff) {
						?>
						<tr>
							<td><?php echo $i; ?>&nbsp;</td>
							<td>
								<?php echo $this->Html->link($staff['Staff']['name'], array('controller' => 'users', 'action' => 'view', $staff['User']['id'])); ?>
							</td>

							<td><?php echo h($staff['Staff']['father_name']); ?>&nbsp;</td>
							<td><?php echo h($staff['Staff']['dob']); ?>&nbsp;</td>
							<td><?php echo $depart[$staff['Staff']['department_id']]; ?>&nbsp;</td>
							<td class="actions">
								<?php echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-eye-open"></i></button>', array('action' => 'view', $staff['Staff']['id']), array('escape' => false)); ?>
								<?php echo $this->Html->link('<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>', array('action' => 'edit', $staff['Staff']['id']), array('escape' => false)); ?>
								<?php echo $this->Form->postLink('<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>', array('action' => 'delete', $staff['Staff']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $staff['Staff']['id'])); ?>
							</td>
						</tr>
						<?php
						$i++;
					}
				} else {
					?>
					<tr>
						<td colspan="9">
							<div class="alert alert-danger" role="alert">No result found</div>
						</td>
					</tr>
				<?php } ?>


			</tbody>
		</table>
	</div><!-- /content-panel -->


	<div class=" clear">&nbsp;</div>
	<?php
	if (!isset($summary)) {
		$summary = 'before';
	}
	?>

    <div class="pull-right <?php echo (!empty($class) ? $class : ''); ?>">
		<?php if ($summary == 'before') { ?>
			<div class="pagination-summary before" style="text-align:right">
				<?php
				echo $this->Paginator->counter(array(
					'format' => __('{:current} of {:count} ' . ucfirst($this->request->params['controller']) . '  /  Page {:page} of {:pages}')
				));
				?>
			</div>         
			<?php
		}

		$params = $this->Paginator->params();
		if ($params['pageCount'] > 1) {
			$this->Paginator->options = array('url' => $paginatorURL);
			?>
			<ul class="pagination">
				<li><?php echo $this->Paginator->first('«', array('escape' => false), null, array('escape' => false, 'class' => 'prev disabled')); ?></li>
				<li><?php echo $this->Paginator->prev('‹', array('escape' => false), null, array('escape' => false, 'class' => 'prev disabled')); ?></li>
				<?php echo $this->Paginator->numbers(array('separator' => '</li><li>', 'before' => '<li>', 'after' => '</li>')); ?>
				<li><?php echo $this->Paginator->next('›', array('escape' => false), null, array('escape' => false, 'class' => 'next disabled')); ?></li>
				<li><?php echo $this->Paginator->last('»', array('escape' => false), null, array('escape' => false, 'class' => 'next disabled')); ?></li>
			</ul>
			<?php if ($summary == 'after') { ?>
				<div class="pagination-summary after" style="text-align:right">
					<?php
					echo $this->Paginator->counter(array(
						'format' => __('{:current} of {:count} ' . ucfirst($this->request->params['controller']) . '  /  Page {:page} of {:pages}')
					));
					?>
				</div>         
				<?php
			}
		}
		?>
    </div><!-- /.pagination -->

</div><!-- /col-md-12 -->


