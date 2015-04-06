<?php
//echo '<pre>';
//foreach($table_data as $t_data){
//pr($t_data);
//}
//die;
//echo "hello";
?>

<div class="col-md-12">
	<div class="content-panel">

		<table class="table table-striped table-advance table-hover">
			<h4><i class="fa fa-angle-right"></i> Manage Folders </h4>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Html->link('<span aria-hidden="true" class="glyphicon glyphicon-plus"></span>', array("controller" => "manage_folders", "action" => "add", "admin" => true), array("escape" => false, "class" => "btn-lg pull-right", "title" => "Add Folder")); ?>
			<div class=" clear">&nbsp;</div>
			<hr>
			<thead>
				<?php echo $this->Form->create("ManageFolder", array("url" => array("controller" => "manageFolders", "action" => "manage"), "type" => "get")) ?>
				<tr>

					<th><?php echo $this->Paginator->sort('user_id', '#ID'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id', 'Name'); ?></th>
				
					<th><?php echo $this->Paginator->sort('Status'); ?></th>
					<!--<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>-->
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			<!--	<tr>
					<td>&nbsp;</td>
					<td><?php echo $this->Form->input('name', array('label' => false, "class" => "form-control input-sm")); ?></td>
					<td></td>


					<td><?php echo $this->Form->input("Filter", array("type" => "submit", "label" => false, "class" => "btn btn-sm btn-theme")); ?></td>
				</tr>-->
				<?php //echo $this->Form->end(); ?>
			</thead>
			<tbody>

				<?php
				if (!empty($table_data)) {
					//pr($table_data); die;
					foreach ($table_data as $t_data) {
						if (!empty($t_data['ManageFolder'])) {
							?>
							<tr>

								<td><?php echo $t_data['ManageFolder']['id']; ?></td>
								<td>
									<?php echo $t_data['ManageFolder']['Name']; ?>
								</td>
								<td><?php
									if ($t_data['ManageFolder']['Status'] == 1) {
										echo "Active";
									} else {
										echo "Inactive";
									}
									?>&nbsp;</td>
								
								<td class="actions">
									<?php
									if ($t_data['ManageFolder']['Status'] == 1) {
										echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="fa fa-times"></i></button>', array('action' => 'deactivate', $t_data['ManageFolder']['id']), array('escape' => false, 'title' => "Deactivate"), __('Are you sure you want to Deactivate  %s?', $t_data['ManageFolder']['Name']));
									} else {

										echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', array('action' => 'activate', $t_data['ManageFolder']['id']), array('escape' => false, 'title' => "Activate"), __('Are you sure you want to Activate  %s?', $t_data['ManageFolder']['Name']));
									}
									?>

								</td>
							</tr>
							<?php
						}
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
