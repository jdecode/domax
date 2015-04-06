

<?php

if ($this->params['controller']=='clients' && $this->params['action'] == 'admin_index') {
    $class = ' background-position: 0 bottom';
} else {
    $class = '';
}
if ($this->params['controller']=='clients' && $this->params['action'] == 'admin_add') {
    $class1 = ' background-position: 0 bottom';
} else {
    $class1 = '';
}
if ($this->params['controller']=='staffs' && $this->params['action'] == 'admin_index') {
    $class2 = ' background-position: 0 bottom';
} else {
    $class2 = '';
}
if ($this->params['controller']=='staffs' && $this->params['action'] == 'admin_add') {
    $class3 = ' background-position: 0 bottom';
} else {
    $class3 = '';
}
if ($this->params['controller']=='users' && $this->params['action'] == 'admin_reset_password') {
    $class4 = ' background-position: 0 bottom';
} else {
    $class4 = '';
}
if ($this->params['controller']=='uploads' && $this->params['action'] == 'admin_index') {
    $class5 = ' background-position: 0 bottom';
} else {
    $class5 = '';
}if ($this->params['controller']=='uploads' && $this->params['action'] == 'admin_add') {
    $class6 = ' background-position: 0 bottom';
} else {
    $class6 = '';
}if ($this->params['controller']=='departments' && $this->params['action'] == 'admin_index') {
    $class7 = ' background-position: 0 bottom';
} else if ($this->params['controller']=='departments' && $this->params['action'] == 'admin_add') {
    $class7 = ' background-position: 0 bottom';
} else {
    $class7 = '';
}?>
<ul>
    <?php if (isset($_SESSION['Auth']['User']['group_id']) && $_SESSION['Auth']['User']['group_id'] == '1') { ?>
        <li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index'), array('style' => $class)); ?></li>
        <li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add'), array('style' => $class1)); ?> </li>
        <li><?php echo $this->Html->link(__('List Staffs'), array('controller' => 'staffs', 'action' => 'index'), array('style' => $class2)); ?> </li>
        <li><?php echo $this->Html->link(__('New Staff'), array('controller' => 'staffs', 'action' => 'add'), array('style' => $class3)); ?> </li>
        <li><?php echo $this->Html->link(__('Reset Password'), array('controller' => 'users', 'action' => 'reset_password'), array('style' => $class4)); ?> </li>
        <li><?php echo $this->Html->link(__('Departments'), array('controller' => 'departments', 'action' => 'admin_index'), array('style' => $class7)); ?> </li>
    <?php } ?>
    <li><?php echo $this->Html->link(__('List Uploads'), array('controller' => 'uploads', 'action' => 'index'), array('style' => $class5)); ?> </li>
    <li><?php echo $this->Html->link(__('New Upload'), array('controller' => 'uploads', 'action' => 'add'), array('style' => $class6)); ?> </li>
</ul>