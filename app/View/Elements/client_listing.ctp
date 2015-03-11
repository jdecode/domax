<?php
//pr($messages); //die;
?>
<div class="col-md-12">
	<div class="content-panel">
		<table class="table table-striped table-advance table-hover">
			<h4><i class="fa fa-angle-right"></i> <?php echo $_label; ?> </h4>
			<?php echo $this->Session->flash(); ?>
			<?php
			$_add_id = $folder_id ? $folder_id : 0;
			echo $this->Html->link(
					'<span aria-hidden="true" class="glyphicon glyphicon-plus"></span>',
					array(
						"controller" => "uploads",
						"action" => "add/".$_add_id,
						"client" => true
					),
					array(
						"escape" => false,
						"class" => "btn-lg pull-right",
						"title" => "Add Upload"
					)
				); ?>
			<div class=" clear">&nbsp;</div>
			<hr>
			<thead>
				<?php echo $this->Form->create("Upload", array("url" => array("controller" => "uploads", "action" => "index"), "type" => "get")) ?>
				<tr>

					<th><?php echo $this->Paginator->sort('id', '#ID'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id', 'Client'); ?></th>
					<th><?php echo $this->Paginator->sort('filename'); ?></th>
					<th><?php echo $this->Paginator->sort('upload_by'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo $this->Form->input('client', array('label' => false, "class" => "form-control input-sm")); ?></td>
					<td><?php echo $this->Form->input('file_name', array('label' => false, "class" => "form-control input-sm")); ?></td>

					<td>&nbsp;</td>
					<td><?php echo $this->Form->input("Filter", array("type" => "submit", "label" => false, "class" => "btn btn-sm btn-theme")); ?></td>
				</tr>
				<?php echo $this->Form->end(); ?>
			</thead>
			<tbody>

				<?php
				if (!empty($messages)) {
					foreach ($messages as $message):
						?>
						<tr>
							<td><?php echo h($message['Message']['id']); ?>&nbsp;</td>
							<td>
								<?php echo $this->Html->link($message['Receiver']['username'], array('controller' => 'users', 'action' => 'view', $message['User']['id'])); ?>
							</td>
							<td><?php echo $this->Html->link('<span class="btn btn-primary">Download</span>', '/app/webroot/files/uploads/' . $message['Document']['filename'], array('escape' => false, 'target' => '_blank')); ?>&nbsp;</td>
							<td>&nbsp;<?php //echo $this->Html->link($users[$message['InboxUpload']['sent_from']], array('controller' => 'users', 'action' => 'view', $message['SentUpload']['sent_from']));  ?>&nbsp;</td>
							<td><?php echo date('F d, Y H:i', $message['Message']['created']); ?>&nbsp;</td>
							<!--<td class="actions">
								<?php //echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-eye-open"></i></button>', array('action' => 'view', $message['Message']['id']), array('escape' => false, 'title' => "View")); ?>
								<?php //echo $this->Html->link('<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>', array('action' => 'edit', $message['User']['id']), array('escape' => false, 'title' => "Edit")); ?>
								<?php //if ($_SESSION['Auth']['User']['group_id'] == '1') { ?>	
								<?php //echo $this->Form->postLink('<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>', array('action' => 'delete', $message['User']['id']), array('escape' => false, 'title' => "Delete"), __('Are you sure you want to delete # %s?', $message['User']['id'])); ?>
								<?php //} ?>
							</td>-->
						</tr>
					<?php
					endforeach;
				}else {
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
			//$this->Paginator->options = array( 'url' => $paginatorURL );
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
