<?php /*
  <div class="table">
  <fieldset   style="width: 500px; margin-left: 250px;">
  <legend><?php echo __('Add Client'); ?></legend>
  <?php echo $this->Form->create('Client'); ?>
  <table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
  <td>User Name</td>
  <td><?php echo $this->Form->input('User.username', array('label' => '')); ?></td>

  </tr>
  <tr>
  <td>Password</td>
  <td><?php echo $this->Form->input('User.password', array('label' => '')); ?></td>

  </tr>
  <tr>
  <td>Email</td>
  <td><?php echo $this->Form->input('Client.email', array('label' => '')); ?></td>

  </tr>
  <tr>
  <td>Name</td>
  <td><?php echo $this->Form->input('name', array('label' => '')); ?></td>

  </tr>
  <?php echo $this->Form->input('User.group_id', array('type' => 'hidden', 'value' => '3')); ?>

  <tr>
  <td>File No</td>
  <td><?php echo $this->Form->input('fileno', array('label' => '')); ?></td>
  </tr>
  <tr>
  <Td>PanCard</td>
  <td><?php echo $this->Form->input('pancard', array('label' => '')); ?></td>
  </tr>
  <tr>
  <Td>Business Name</td>
  <td><?php echo $this->Form->input('bussiness_name', array('label' => '')); ?></td>
  </tr>
  <tr>
  <td colspan="2" align="center"> <?php echo $this->Form->end(__('Submit')); ?></td>
  </tr>


  </table>
  </fieldset>
  </div> */ ?>


<div class="col-lg-8">
	<div class="form-panel">
		<h4 class="mb"><i class="fa fa-angle-right"></i> Add Client</h4>
		<?php echo $this->Form->create('Client', array("class" => "form-horizontal style-form")); ?>
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
				<?php echo $this->Form->input('email', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Name</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('name', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>


		<?php echo $this->Form->input('User.group_id', array('label' => '', 'type' => 'hidden', 'value' => '3', "class" => "form-control")); ?>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">File No</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('fileno', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Pan card</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('pancard', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Business Name</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('bussiness_name', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="row">
		<div class="col-sm-3"><?php echo $this->Html->link('Back', array("controller"=>"clients","action"=>"index"),array( "class" => "btn btn-theme")); ?></div>
		<div class="col-sm-3"><?php echo $this->Form->input('submit', array("type" => "submit", "label" => false, "class" => "btn btn-theme")); ?></div>
		</div>


		<?php echo $this->Form->end(); ?>
	</div>
</div>