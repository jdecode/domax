<?php
if ($this->params['controller'] == 'clients') {
	$client_class = 'active';
} else {
	$client_class = '';
}

if ($this->params['controller'] == 'staffs') {
	$staffs_class = 'active';
} else {
	$staffs_class = '';
}

if ($this->params['controller'] == 'uploads') {
	$uploads_class = 'active';
} else {
	$uploads_class = '';
}

if ($this->params['controller'] == 'departments') {
	$departments_class = 'active';
} else {
	$departments_class = '';
}

if(strtolower($this->params['controller']) == 'managefolders'){
	$manage_folder = 'active';
}else{
	$manage_folder = '';
}

if ($this->params['controller'] == 'users' && $this->params['action'] == 'admin_reset_password') {
	$rep_class = 'active';
} else {
	$rep_class = '';
}

?>



<ul class="sidebar-menu" id="nav-accordion">

	<p class="centered"><a href="#">
			<?php echo $this->Html->image("/assets/img/ui-sam.jpg",array("class"=>"img-circle", "width"=>"60"))?>
			
			</a></p>
	<h5 class="centered">him-soft-solution Admin</h5>
<?php //if (isset($_SESSION['Auth']['User']['group_id']) && $_SESSION['Auth']['User']['group_id'] == '1') { ?>
<?php if ($_is_admin) { ?>
	<li class="sub-menu">
		<a href="javascript:;"  class="<?php echo $client_class;?>">
			<i class="fa fa-desktop"></i>
			<span>Clients</span>
		</a>
		<ul class="sub">
			<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		</ul>
	</li>
	
	<li class="sub-menu">
		<a href="javascript:;" class="<?php echo $staffs_class;?>" >
			<i class="fa fa-desktop"></i>
			<span>Staff</span>
		</a>
		<ul class="sub">
			<li><?php echo $this->Html->link(__('List Staffs'), array('controller' => 'staffs', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New Staff'), array('controller' => 'staffs', 'action' => 'add')); ?> </li>
		</ul>
	</li>
<?php }?>
	<li class="sub-menu">
		<a href="javascript:;"  class="<?php echo $uploads_class;?>">
			<i class="fa fa-desktop"></i>
			<span>Uploads</span>
		</a>
		<ul class="sub">
			<li><?php echo $this->Html->link(__('Received'), array('controller' => 'uploads', 'action' => 'inbox')); ?> </li>
			<li><?php echo $this->Html->link(__('Uploaded'), array('controller' => 'uploads', 'action' => 'draft')); ?> </li>
			<li><?php echo $this->Html->link(__('Sent'), array('controller' => 'uploads', 'action' => 'sent')); ?> </li>
			<li><?php echo $this->Html->link(__('Compose'), array('controller' => 'uploads', 'action' => 'add')); ?> </li>
			<?php
			if(isset($_folders) && is_array($_folders) && count($_folders)) {
				foreach($_folders as $_folder) {
				?>
				<li><?php echo $this->Html->link(ucwords(strtolower($_folder['ManageFolder']['Name'])), array('controller' => 'uploads', 'action' => 'folder/'.$_folder['ManageFolder']['id'], 'admin' => true)); ?> </li>
				<?php
				}
			}
			?>
		</ul>
	</li>
	<li class="sub-menu">
		<a href="javascript:;"  class="<?php echo $uploads_class;?>">
			<!--<i class="fa fa-desktop"></i>--> 
			<?php echo $this->Html->link(__('<i class="fa fa-desktop"></i> Manage Folders'),array('controller'=>'manageFolders','action'=>'manage'),array("class"=>$manage_folder,"escape"=>false));?>
		</a>
	</li>
	
	<?php if ($_is_admin) { ?>
	<li>
		<?php echo $this->Html->link(__('<i class="fa fa-th"></i> Departments'), array('controller' => 'departments', 'action' => 'admin_index'), array("class"=>$departments_class,"escape"=>false)); ?>
	</li>
	<li><?php echo $this->Html->link(__('<i class="fa fa-th"></i> Reset Password'), array('controller' => 'users', 'action' => 'reset_password'), array("class"=>$rep_class,"escape"=>false)); ?> </li>
	<?php }?>
</ul>
