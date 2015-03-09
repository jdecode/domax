<script>
	$(document).ready(function() {
		//alert("Asd");
		/* $("#UploadAdminAddForm").submit(function(){
		 if($('#UploadDropDown').val()==''){
		 $('#errror').html('<div class="message" id="flashMessage">Select drop down firstly.</div>');
		 return false;
		 } else{
		 return true;
		 }      
		 });*/
		$('#UploadDropDown').change(function() {
			var action_id = $('#UploadDropDown').val();

			$.ajax({
				type: 'POST',
				data: 'action_id=' + action_id,
				url: '<?php echo $this->base ?>/uploads/ajax',
				success: function(resp) {
					$("#response").html(resp);
				}
			});


		});
	});
</script>


<div class="col-lg-8">
	<div class="form-panel">
		<h4 class="mb"><i class="fa fa-angle-right"></i>Add Upload</h4>
		<?php echo $this->Form->create('Upload', array("class" => "form-horizontal style-form", "id" => "UploadAdminAddForm", "enctype" => "multipart/form-data")); ?>
		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Drop Down</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('drop_down', array('label' => '', 'type' => 'select', 'id' => 'UploadDropDown', 'options' => array('' => '--select--', '1' => 'Customer', '2' => 'File No', '3' => 'PanCard', '4' => 'Bussiness Name', '5' => 'staff'))); ?>
				<?php echo $this->Form->input('_folder_id', array('type' => 'hidden', 'value' => $_folder_id)); ?>
			</div>
		</div>

		<div class="form-group">
			<div id="response" class=""></div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">File</label>
			<div class="col-sm-9">
				<?php
				echo $this->Form->input('filename', array('label' => false, 'type' => 'file'));

				echo $this->Form->input('upload_by', array('type' => 'hidden', 'value' => $_admin_data['id']));
				?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Name/Title</label>
			<div class="col-sm-9">
			<?php echo $this->Form->input('title', array('label' => '')); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Description</label>
			<div class="col-sm-9">
			<?php echo $this->Form->input('description', array('label' => '')); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3"><?php echo $this->Html->link('Back', array("controller" => "uploads", "action" => "index"), array("class" => "btn btn-theme")); ?></div>
			<div class="col-sm-3"><?php echo $this->Form->input('submit', array("type" => "submit", "label" => false, "class" => "btn btn-theme")); ?></div>
		</div>


<?php echo $this->Form->end(); ?>
	</div>
</div>

