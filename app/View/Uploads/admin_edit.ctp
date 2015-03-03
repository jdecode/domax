<script>
    $(document).ready(function () {
        $("#UploadAdminAddForm").submit(function () {
            if ($('#UploadDropDown').val() == '') {
                $('#errror').html('<div class="message" id="flashMessage">Select drop down firstly.</div>');
                return false;
            } else {
                return true;
            }
        });
        $('#UploadDropDown').change(function () {
            var action_id = $('#UploadDropDown').val();
            $.ajax({
                type: 'POST',
                data: 'action_id=' + action_id,
                url: '<?php echo $this->base ?>/admin/uploads/ajax',
                success: function (resp) {
                    $("#response").html(resp);
                }
            });


        });
    });
</script>
<div id="errror"></div>

<?php /*
  <div class="table">
  <?php //debug($this->request->data) ?>
  <?php echo $this->Form->create('Upload', array('type' => 'file')); ?>
  <fieldset style="margin-left: 200px; width: 500px;">
  <legend><?php echo __('Add Upload'); ?></legend>
  <?php
  if ($this->request->data['Upload']['filetouser'] == '1') {
  $label = 'Customer Name';
  $select = '1';
  } else if ($this->request->data['Upload']['filetouser'] == '2') {
  $label = 'File No';
  $select = '2';
  } else if ($this->request->data['Upload']['filetouser'] == '3') {
  $label = 'PanCard';
  $select = '3';
  } else if ($this->request->data['Upload']['filetouser'] == '4') {
  $label = 'Bussiness Name';
  $select = '4';
  }
  $this->request->data['Upload']['drop_down'] = $select;
  echo $this->Form->input('upload_by', array('type' => 'hidden', 'value' => $_SESSION['Auth']['User']['id']));
  ?>
  <table>
  <tr>
  <td>Drop Down</td><td><?php echo $this->Form->input('Upload.drop_down', array('label' => '', 'type' => 'select', 'options' => array('' => '--select--', '1' => 'Customer', '2' => 'File No', '3' => 'PanCard', '4' => 'Bussiness Name'))); ?></td>
  </tr>
  <tr>
  <td>&nbsp;</td><td><div id="response"><?php echo $this->Form->input('Upload.filetouser', array('label' => $label, 'type' => 'select', 'options' => $option)); ?></div></td>
  </tr>
  <tr>
  <td>File Name</td><td><?php echo $this->Form->input('filename', array('type' => 'file', 'label' => '')); ?></td>
  </tr>
  <tr>
  <td>Description</td><td><?php echo $this->Form->input('description', array('label' => '')); ?></td>
  </tr>
  <tr>
  <td colspan="2" align="center"><?php echo $this->Form->end(__('Submit')); ?></td>
  </tr>
  </table>


  </fieldset>

  </div> */ ?>


<div class="col-lg-8">
	<div class="form-panel">
		<h4 class="mb"><i class="fa fa-angle-right"></i>Edit Upload</h4>
		<?php echo $this->Form->create('Upload', array("class" => "form-horizontal style-form", "id" => "UploadAdminAddForm", "enctype" => "multipart/form-data")); ?>
		<?php
		$select=0;
		if ($this->request->data['Upload']['filetouser'] == '1') {
			$label = 'Customer Name';
			$select = '1';
		} else if ($this->request->data['Upload']['filetouser'] == '2') {
			$label = 'File No';
			$select = '2';
		} else if ($this->request->data['Upload']['filetouser'] == '3') {
			$label = 'PanCard';
			$select = '3';
		} else if ($this->request->data['Upload']['filetouser'] == '4') {
			$label = 'Bussiness Name';
			$select = '4';
		}
		$this->request->data['Upload']['drop_down'] = $select;

		echo $this->Form->input('upload_by', array('type' => 'hidden', 'value' => $_SESSION['Auth']['User']['id']));
		?>
		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Drop Down</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('drop_down', array('label' => '', 'type' => 'select', 'id' => 'UploadDropDown', 'options' => array('' => '--select--', '1' => 'Customer', '2' => 'File No', '3' => 'PanCard', '4' => 'Bussiness Name'))); ?>
			</div>
		</div>

		<div class="form-group">


			<div id="response">
				<label class="col-sm-3 col-sm-3 control-label">User</label>
				<div class="col-sm-9">
					
					<?php
					 if(!isset($label)){
						 $label= 0;
					 }
					echo $this->Form->input('Upload.filetouser', array('label' => $label, 'type' => 'select', 'options' => $option, 'label' => false)); ?>
				</div>
			</div>

		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">File</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('filename', array('label' => false, 'type' => 'file')); ?>
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