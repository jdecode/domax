<?php if(empty($option)&&empty($option2)&&empty($option3)&&empty($option4)&&empty($option5)&&empty($option6)){
	echo '<div style="color:red;">';
	echo('Please make sure required options are selected');
	echo '</div>';
}else{
?>

<label class="col-sm-3 col-md-3 control-label">User</label>
<div class="col-sm-9 scrollable">

<?php if(!empty($option)){ ?>
<?php echo $this->Form->input('Upload.filetouser',array('label'=>'Customer Name','multiple'=>'checkbox','type'=>'select','options'=>$option,"label"=>false)) ?>
<?php } ?>
<?php if(!empty($option2)){ ?>
<?php echo $this->Form->input('Upload.filetouser',array('label'=>'File No','multiple'=>'checkbox','type'=>'select','options'=>$option2,"label"=>false)) ?>
<?php } ?>
<?php if(!empty($option3)){ ?>
<?php echo $this->Form->input('Upload.filetouser',array('label'=>'Pancard','multiple'=>'checkbox','type'=>'select','options'=>$option3,"label"=>false)) ?>
<?php } ?>
<?php if(!empty($option4)){ ?>
<?php echo $this->Form->input('Upload.filetouser',array('label'=>'Bussiness Name','type'=>'select','multiple'=>'checkbox','options'=>$option4,"label"=>false)) ?>
<?php } ?>
<?php if(!empty($option5)){ ?>
<?php echo $this->Form->input('Upload.filetouser',array('label'=>'Staff Name','type'=>'select','multiple'=>'checkbox','options'=>$option5,"label"=>false)) ?>
<?php } ?>
<?php if(!empty($option6)){ ?>
<?php echo $this->Form->input('Upload.filetouser',array('label'=>'','multiple'=>'checkbox','type'=>'select','options'=>$option6,"label"=>false)) ?>
<?php } ?>
<?php if(empty($option)&&empty($option2)&&empty($option3)&&empty($option4)&&empty($option5)&&empty($option6)){
	
}
?>
</div>
<label class="col-sm-3 col-md-3 control-label">Folders</label>
<div class="col-sm-9 ">
	<?php 
	$options=array(0=>"Inbox");
	foreach($_folders as $_folder){
	//	pr($_folder['ManageFolder']['Name']);
		$options[$_folder['ManageFolder']['id']]=$_folder['ManageFolder']['Name'];
	
	}
	//pr($options);
	if(!empty($options)){
		//echo $option;
		echo $this->Form->input('folder_id',array('label'=>'folder','multiple'=>'checkbox','options'=>$options,"label"=>false));	
	}
	?>

</div>
<?php }?>