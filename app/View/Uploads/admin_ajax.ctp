
<label class="col-sm-3 col-sm-3 control-label">User</label>
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
</div>