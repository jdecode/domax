
<div class="col-md-12">
	<div class="content-panel">


		<table class="table table-striped table-advance table-hover">
			<h4><i class="fa fa-angle-right"></i> Clients</h4>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Html->link('<span aria-hidden="true" class="glyphicon glyphicon-plus"></span><span aria-hidden="true" class="glyphicon glyphicon-user"></span>', array("controller" => "clients", "action" => "add", "admin" => true), array("escape" => false, "class" => "btn-lg pull-right", "title" => "Add Client")); ?>
			<div class=" clear">&nbsp;</div>
			<hr>

			<thead>
				<?php echo $this->Form->create("client", array("url" => array("controller" => "clients", "action" => "index"), "type" => "get")) ?>
				<tr>
					<th><?php echo $this->Paginator->sort('id', 'Sr No.'); ?></th>
                    <th><?php echo $this->Paginator->sort('user_id', 'Client Name'); ?></th>
                    <th><?php echo $this->Paginator->sort('fileno'); ?></th>
                    <th><?php echo $this->Paginator->sort('pancard'); ?></th>
                    <th><?php echo $this->Paginator->sort('bussiness_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('status'); ?></th>
                    <th width="150" class="ac"><?php echo __('Actions'); ?></th>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo $this->Form->input('client_name', array('label' => false, "class" => "form-control input-sm","required"=>FALSE)); ?></td>
					<td><?php echo $this->Form->input('file_no', array('label' => false, "class" => "form-control input-sm","required"=>FALSE)); ?></td>
					<td><?php echo $this->Form->input('pancard', array('label' => false, "class" => "form-control input-sm","required"=>FALSE)); ?></td>
					<td><?php echo $this->Form->input('bussiness_name', array('label' => false, "class" => "form-control input-sm","required"=>FALSE)); ?></td>
					<td>&nbsp</td>
					<td><?php echo $this->Form->input("Filter", array("type" => "submit", "label" => false, "class" => "btn btn-sm btn-theme")); ?></td>
				</tr>
				<?php echo $this->Form->end(); ?>
			</thead>

			<tbody>
				<?php
				$i =1;
				if (!empty($clients)) {
					foreach ($clients as $client):
						?>
						<tr>
							<td><?php echo $i; ?>&nbsp;</td>
							<td>
								<?php echo $this->Html->link(ucfirst($client['Client']['name']), array('controller' => 'users', 'action' => 'view', $client['User']['id'])); ?>
							</td>
							<td><?php echo h($client['Client']['fileno']); ?>&nbsp;</td>
							<td><?php echo h($client['Client']['pancard']); ?>&nbsp;</td>
							<td><?php echo h($client['Client']['bussiness_name']); ?>&nbsp;</td>
							<?php if ($client['User']['status'] == '0') { ?>
								<td><?php echo $this->Html->link('<button class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button>', array('controller' => 'users', 'action' => 'login_status', '0', 'pass' => $client['Client']['user_id']), array('escape' => false, "title" => "Active it ")); ?>&nbsp;</td>
							<?php } else { ?>
								<td><?php echo $this->Html->link('<button class="btn btn-success btn-xs"><span aria-hidden="true" class="fa fa-check "></span></button>', array('controller' => 'users', 'action' => 'admin_login_status', '1', '0', 'pass' => $client['Client']['user_id']), array('escape' => false, "title" => "Inactive it")); ?>&nbsp;</td>
							<?php } ?>
							<td class="actions">
								<?php echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-eye-open"></i></button>', array('action' => 'view', $client['Client']['id']), array('class' => 'ico view', 'escape' => false, "title" => "View")); ?>
								<?php if ($_is_admin) { ?>
									<?php echo $this->Html->link('<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>', array('action' => 'edit', $client['Client']['id']), array('class' => 'ico edit', 'escape' => false, "title" => "Edit")); ?>
									<?php echo $this->Html->link('<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>', array('action' => 'delete', $client['Client']['id']), array('escape' => false, "title" => "Delete"), __('Are you sure you want to delete # %s?', $client['Client']['id'])); ?>
								<?php } ?>
							</td>
						</tr>
						<?php
						$i++;
					endforeach;
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
			$this->Paginator->options = array( 'url' => $paginatorURL );
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


