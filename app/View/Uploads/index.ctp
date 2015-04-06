<script>
    $(document).ready(function () {
        $("#upload_searchFileno").keyup(function () {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->base; ?>/uploads/search',
                data: 'search_by=fileno&value=' + $('#upload_searchFileno').val(),
                success: function (response) {
                    $('#response').html(response);
                }
            });
        });
    });

</script>
<?php /*
<div class="table">


	<?php $this->Form->create('upload_search'); ?>
    <table width="100%" cellspacing="5" cellpadding="5" border="0">
        <tr>
            <td>Search by File Name</td><td><?php echo $this->Form->input('fileno', array('label' => '')); ?></td>



        </tr>
    </table>
	<?php echo $this->Form->end(array('style' => 'display:none')); ?>
    <div id="response">
		<?php echo $this->Form->create('Upload', array('action' => 'admin_delete1')); ?>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <th></th>
                <th><?php echo $this->Paginator->sort('id', 'Sr No'); ?></th>
                <th><?php echo $this->Paginator->sort('user_id', 'Client'); ?></th>
                <th><?php echo $this->Paginator->sort('filename'); ?></th>
                <th><?php echo $this->Paginator->sort('upload_by'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
			<?php foreach ($uploads as $upload): ?>
				<tr>
					<td><input type="checkbox"  name="data[Upload][id][]" value=<?php echo $upload['Upload']['id']; ?>></td>
					<td><?php echo h($upload['Upload']['id']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($upload['User']['username'], array('controller' => 'users', 'action' => 'view', $upload['User']['id'])); ?>
					</td>
					<td><?php echo $this->Html->link($upload['Upload']['filename'], '/app/webroot/files/uploads/' . $upload['User']['id'] . '/' . $upload['Upload']['filename']); ?>&nbsp;</td>
					<td><?php echo $this->Html->link($users[$upload['Upload']['upload_by']], array('controller' => 'users', 'action' => 'view', $upload['Upload']['upload_by'])); ?>&nbsp;</td>
					<td><?php echo h($upload['Upload']['created']); ?>&nbsp;</td>
					<td><?php echo h($upload['Upload']['modified']); ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('action' => 'view', $upload['Upload']['id'])); ?>
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $upload['Upload']['id'])); ?>
						<?php //if ($_SESSION['Auth']['User']['group_id'] == '1') { ?>	
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $upload['Upload']['id']), null, __('Are you sure you want to delete # %s?', $upload['Upload']['id'])); ?>
						<?php //} ?>
					</td>
				</tr>
			<?php endforeach; ?>
        </table>
        <p>
			<?php
			echo $this->Form->end('Delete');
			echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}')
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
</div>

*/?>

<div class="col-md-12">
	<div class="content-panel">
		<table class="table table-striped table-advance table-hover">
			<h4><i class="fa fa-angle-right"></i> Uploads</h4>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Html->link('<span aria-hidden="true" class="glyphicon glyphicon-plus"></span>', array("controller" => "uploads", "action" => "add", "admin" => true), array("escape" => false, "class" => "btn-lg pull-right", "title" => "Add Upload")); ?>
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
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo $this->Form->input('client', array('label' => false, "class" => "form-control input-sm")); ?></td>
					<td><?php echo $this->Form->input('file_name', array('label' => false, "class" => "form-control input-sm")); ?></td>
					
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><?php echo $this->Form->input("Filter", array("type" => "submit", "label" => false, "class" => "btn btn-sm btn-theme")); ?></td>
				</tr>
				<?php echo $this->Form->end(); ?>
			</thead>
			<tbody>
				
				<?php 
				
				if(!empty($uploads)){
				foreach ($uploads as $upload): ?>
				<tr>
					
					<td><?php echo h($upload['Upload']['id']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($upload['User']['username'], array('controller' => 'users', 'action' => 'view', $upload['User']['id'])); ?>
					</td>
					<td><?php echo $this->Html->link($upload['Upload']['filename'], '/app/webroot/files/uploads/' . $upload['User']['id'] . '/' . $upload['Upload']['filename']); ?>&nbsp;</td>
					<td><?php echo $this->Html->link($users[$upload['Upload']['upload_by']], array('controller' => 'users', 'action' => 'view', $upload['Upload']['upload_by'])); ?>&nbsp;</td>
					<td><?php echo h($upload['Upload']['created']); ?>&nbsp;</td>
					<td><?php echo h($upload['Upload']['modified']); ?>&nbsp;</td>
					<td class="actions">
						<?php echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-eye-open"></i></button>', array('action' => 'view', $upload['Upload']['id']), array('escape' => false,'title'=>"View")); ?>
						<?php echo $this->Html->link('<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>', array('action' => 'edit', $upload['Upload']['id']), array('escape' => false,'title'=>"Edit")); ?>
						<?php //if ($_SESSION['Auth']['User']['group_id'] == '1') { ?>	
						<?php echo $this->Form->postLink('<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>', array('action' => 'delete', $upload['Upload']['id']), array('escape' => false,'title'=>"Delete"), __('Are you sure you want to delete # %s?', $upload['Upload']['id'])); ?>
						<?php //} ?>
					</td>
				</tr>
			<?php endforeach;  }else {
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
