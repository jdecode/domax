<script>
	$(document).ready(function() {
	
		$('#UploadDropDown').change(function() {
			var action_id = $('#UploadDropDown').val();

			$.ajax({
				type: 'POST',
				data: 'action_id=' + action_id,
				url: '<?php echo $this->base ?>/admin/uploads/ajax',
				success: function(resp) {
					$("#response").html(resp);
				}
			});
			

		});
	});
</script>
<?php /*
  <div id="errror"></div>
  <div class='table'><br><br>
  <fieldset   style="width: 600px; margin-left: 200px;">
  <legend><?php echo __('Add Upload'); ?></legend>
  <?php echo $this->Form->create('Upload',array('type'=>'file')); ?>
  <table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
  <td>Drop Down</td>
  <td><?php
  echo $this->Form->input('drop_down', array('label'=>'','type' => 'select','id'=>'UploadDropDown', 'options' => array('' => '--select--', '1' => 'Customer', '2' => 'File No', '3' => 'PanCard', '4' => 'Bussiness Name')));
  ?></td>

  </tr>
  <tr>
  <td></td>
  <td><div id="response"></div></td>
  </tr>
  <tr>
  <td>File</td>
  <td><?php echo $this->Form->input('filename',array('label'=>'','type'=>'file')); ?><?php

  echo $this->Form->input('upload_by',array('type'=>'hidden','value'=>$_SESSION['Auth']['User']['id']));
  ?></td>
  </tr>
  <tr>
  <td>Description</td><td><?php echo $this->Form->input('description',array('label'=>''));?></td>
  </tr>
  <tr>
  <td colspan='2' align="center"> <?php echo $this->Form->end(__('Submit')); ?></td>
  </tr>
  </table>
  </fieldset>
  </div>
 */ ?>

<div class="col-lg-8">
	<div class="form-panel">
		<h4 class="mb"><i class="fa fa-angle-right"></i>Add Folder</h4>
		<?php echo $this->Form->create('ManageFolder', array("class" => "form-horizontal style-form", "id" => "UploadAdminAddForm")); ?>
		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Folder Name</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Name', array('label' => false, 'type' => 'text')); ?>
			</div>
		</div>

	 

		<div class="row">
			<div class="col-sm-3"><?php echo $this->Html->link('Back', array("controller" => "manageFolders", "action" => "manage"), array("class" => "btn btn-theme")); ?></div>
			<div class="col-sm-3"><?php echo $this->Form->input('submit', array("type" => "submit", "label" => false, "class" => "btn btn-theme")); ?></div>
		</div>


<?php echo $this->Form->end(); ?>
	</div>
</div>

