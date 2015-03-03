<?php /* <div class="table">
  <table width="100%" cellspacing="5" cellpadding="5" border="0">
  <tr>
  <td width="70%"></td><td><?php echo $this->Html->link('Add Department', array('controller' => 'departments', 'action' => 'admin_add')); ?></td>
  </tr>
  </table>
  <table cellpadding="0" align="center" width="100%" cellspacing="0">
  <tr>
  <th><?php echo $this->Paginator->sort('id', 'Sr No'); ?></th>
  <th><?php echo $this->Paginator->sort('name'); ?></th>
  <th><?php echo $this->Paginator->sort('created'); ?></th>
  <th><?php echo $this->Paginator->sort('modified'); ?></th>
  <th class="actions"><?php echo __('Actions'); ?></th>
  </tr>
  <?php foreach ($departments as $group): ?>
  <tr>
  <td><?php echo h($group['Department']['id']); ?>&nbsp;</td>
  <td><?php echo h($group['Department']['name']); ?>&nbsp;</td>
  <td><?php echo h($group['Department']['created']); ?>&nbsp;</td>
  <td><?php echo h($group['Department']['modified']); ?>&nbsp;</td>
  <td class="actions">

  <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $group['Department']['id'])); ?>
  <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $group['Department']['id']), null, __('Are you sure you want to delete # %s?', $group['Department']['id'])); ?>
  </td>
  </tr>
  <?php endforeach; ?>
  </table>
  <p>
  <?php
  echo $this->Paginator->counter(array(
  'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
  ));
  ?>	</p>

  <div class="paging">
  <?php
  echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
  echo $this->Paginator->numbers(array('separator' => ''));
  echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
  ?>
  </div>
  </div>
 */ ?>

<div class="col-md-12">
	<div class="content-panel">
		<table class="table table-striped table-advance table-hover">
			<h4><i class="fa fa-angle-right"></i> Departments</h4>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Html->link('<span aria-hidden="true" class="glyphicon glyphicon-plus"></span><span aria-hidden="true" class="glyphicon glyphicon-user"></span>', array("controller" => "departments", "action" => "add", "admin" => true), array("escape" => false, "class" => "btn-lg pull-right", "title" => "Add Department")); ?>
			<div class=" clear">&nbsp;</div>
			<hr>
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id', 'Sr No'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($departments as $group): ?>
					<tr>
						<td><?php echo h($group['Department']['id']); ?>&nbsp;</td>
						<td><?php echo h($group['Department']['name']); ?>&nbsp;</td>
						<td><?php echo h($group['Department']['created']); ?>&nbsp;</td>
						<td><?php echo h($group['Department']['modified']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>', array('action' => 'edit', $group['Department']['id']), array('escape' => false,'title'=>"Edit")); ?>
							<?php echo $this->Form->postLink('<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>', array('action' => 'delete', $group['Department']['id']), array('escape' => false,'title'=>"Delete"), __('Are you sure you want to delete # %s?', $group['Department']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
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

