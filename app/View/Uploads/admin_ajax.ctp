<?php if(empty($option)&&empty($option2)&&empty($option3)&&empty($option4)&&empty($option5)&&empty($option6)){
	echo '<div style="color:red;">';
	echo('Please make sure required options are selected');
	echo '</div>';
}else{
?>
<div class="scrollable">
	<label class="col-sm-3 col-md-3 control-label">User</label>
	<div class="col-sm-9 ">


		<?php //echo $this->Form->input('Upload.filetouser',array('label'=>'Select All','id'=>'selectall','type'=>'checkbox',"label"=>false)); ?>
		<?php if (!empty($option)) { ?>
			<?php echo $this->Form->input('Upload.filetouser', array('label' => 'Customer Name', 'multiple' => 'checkbox', 'id' => 'checkbox1', 'options' => $option, "label" => false)) ?>
		<?php } ?>
		<?php if (!empty($option2)) { ?>
			<?php echo $this->Form->input('Upload.filetouser', array('label' => 'File No', 'multiple' => 'checkbox', 'options' => $option2, "label" => false)) ?>
		<?php } ?>
		<?php if (!empty($option3)) { ?>
			<?php echo $this->Form->input('Upload.filetouser', array('label' => 'Pancard', 'multiple' => 'checkbox', 'options' => $option3, "label" => false)) ?>
		<?php } ?>
		<?php if (!empty($option4)) { ?>
			<?php echo $this->Form->input('Upload.filetouser', array('label' => 'Bussiness Name', 'multiple' => 'checkbox', 'options' => $option4, "label" => false)) ?>
		<?php } ?>
		<?php if (!empty($option5)) { ?>
			<?php echo $this->Form->input('Upload.filetouser', array('label' => 'Staff Name', 'multiple' => 'checkbox', 'options' => $option5, "label" => false)) ?>
		<?php } ?>
	</div>

	
	<label class="col-sm-3 col-md-3 control-label" style="border-top:1px solid #D1D1D1;">Folders</label>
	<div class="col-sm-9 ">
		<?php
		$options = array(0 => "Inbox");
		foreach ($_folders as $_folder) {
			//	pr($_folder['ManageFolder']['Name']);
			$options[$_folder['ManageFolder']['id']] = $_folder['ManageFolder']['Name'];
		}
		//pr($options);
		if (!empty($options)) {
			//echo $option;
			echo $this->Form->input('Upload.folder_id', array('label' => 'folder', 'multiple' => 'checkbox', 'options' => $options, "label" => false));
		}
		?>

	</div>
</div>

<?php } ?>