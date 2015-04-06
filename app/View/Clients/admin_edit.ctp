<?php /*<div class="table">
    <?php echo $this->Form->create('Client'); ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td>Name</td>
                <td><?php echo $this->Form->input('name', array('label' => ''));
    echo $this->Form->input('User.group_id', array('type' => 'hidden', 'value' => '3')); ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $this->Form->input('Client.email', array('label' => '')); ?></td>

            </tr>
            <tr>
                <Td>File No</td>
                <td><?php echo $this->Form->input('fileno', array('label' => '')); ?></td>
            </tr>
            <tr>
                <td>PanCard</td>
                <td><?php echo $this->Form->input('pancard', array('label' => ''));
    echo $this->Form->input('id'); ?></td>
            </tr>	
            <tr>
                <td>Bussiness Name</td>
                <td><?php echo $this->Form->input('bussiness_name', array('label' => '')); ?></td>
            </tr>
            <tr>

                <td colspan="2"><?php echo $this->Form->end(__('Submit')); ?></td>
            </tr>



        </tbody></tr>
</div>
*/?>
<?php //pr($this->request->data);?>
<div class="col-lg-8">
	<div class="form-panel">
		<h4 class="mb"><i class="fa fa-angle-right"></i> Add Client</h4>
		<?php echo $this->Form->create('Client', array("class" => "form-horizontal style-form")); ?>
		
		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Email</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Client.email', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Name</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Client.name', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>


		<?php echo $this->Form->input('User.group_id', array('label' => '', 'type' => 'hidden', 'value' => '3', "class" => "form-control")); ?>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">File No</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Client.fileno', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Pan card</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Client.pancard', array('label' => '', "class" => "form-control")); echo $this->Form->input('id');  ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 col-sm-3 control-label">Business Name</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('Client.bussiness_name', array('label' => '', "class" => "form-control")); ?>
			</div>
		</div>
		<div class="row">
		<div class="col-sm-3"><?php echo $this->Html->link('Back', array("controller"=>"clients","action"=>"index"),array( "class" => "btn btn-theme")); ?></div>
		<div class="col-sm-3"><?php echo $this->Form->input('submit', array("type" => "submit", "label" => false, "class" => "btn btn-theme")); ?></div>
		</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>