
<div class="col-lg-8">
	<div class="form-panel">
		<h4 class="mb"><i class="fa fa-angle-right"></i> Add Staff</h4>

		<?php echo $this->Form->create('Staff', array("class" => "form-horizontal style-form", "type" => 'post')); ?>
		<?php echo $this->Form->input('User.group_id', array('type' => 'hidden', array('label' => ''), 'value' => '2')); ?>
		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">User Name</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('User.username', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Password</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('User.password', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Email</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Staff.email', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Name</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Staff.name', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Father Name</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Staff.father_name', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Date of Birth</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Staff.dob', array('label' => '', "class" => "form-control-sel")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Department</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Staff.department_id', array('label' => '', "class" => "form-control", "options" => $select, "empty" => "Select")); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Reference</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Staff.references', array('label' => false, "class" => "form-control")); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3"><?php echo $this->Html->link('Back', array("controller" => "staffs", "action" => "index"), array("class" => "btn btn-theme")); ?></div>
			<div class="col-sm-3"><?php echo $this->Form->input('submit', array("type" => "submit", "label" => false, "class" => "btn btn-theme")); ?></div>
		</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>