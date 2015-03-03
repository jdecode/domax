<?php /*
  <div class="table">
  <br><br>
  <fieldset   style="width: 500px; margin-left: 250px;">
  <legend>Client Details</legend>
  <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
  <th>Title</th>
  <th>Value</th>
  </tr>
  <tr>
  <td><?php echo __('User'); ?></td>
  <td><?php echo $this->Html->link($client['Client']['name'], array('controller' => 'users', 'action' => 'view', $client['User']['id'])); ?></td>
  </tr>
  <tr class="odd">
  <td><?php echo __('Fileno'); ?></td>
  <td><?php echo h($client['Client']['fileno']); ?></td>
  </tr>
  <tr class="odd">
  <td><?php echo __('Email'); ?></td>
  <td><?php echo $this->Html->link($client['Client']['email'], 'mailto:' . $client['Client']['email']); ?></td>
  </tr>
  <tr>
  <td><?php echo __('Pancard'); ?></td>
  <td><?php echo h($client['Client']['pancard']); ?></td>
  </tr>
  <tr>
  <td><?php echo __('Bussiness Name'); ?></td>
  <td><?php echo h($client['Client']['bussiness_name']); ?></td>
  </tr>
  </tbody></table>
  </fieldset>
  </div> */ ?>
<div class="col-md-12">
	<div class="content-panel">
		<hr>
		<table class="table">
			<tbody>
				<tr>
					<th><?php echo __('User'); ?></th>
					<td><?php echo $this->Html->link($client['Client']['name'], array('controller' => 'users', 'action' => 'view', $client['User']['id'])); ?></td>
				</tr>
				<tr class="odd">
					<th><?php echo __('Fileno'); ?></th>
					<td><?php echo h($client['Client']['fileno']); ?></td>
				</tr>
				<tr class="odd">
					<th><?php echo __('Email'); ?></th>
					<td><?php echo $this->Html->link($client['Client']['email'], 'mailto:' . $client['Client']['email']); ?></td>
				</tr>
				<tr>
					<th><?php echo __('Pancard'); ?></th>
					<td><?php echo h($client['Client']['pancard']); ?></td>
				</tr>
				<tr>
					<th><?php echo __('Bussiness Name'); ?></th>
					<td><?php echo h($client['Client']['bussiness_name']); ?></td>
				</tr>
			</tbody>
		</table>
		<div class="row">
			<div class="col-sm-3"><?php echo $this->Html->link('Back', array("controller" => "clients", "action" => "index"), array("class" => "btn btn-theme")); ?></div>

		</div>
	</div>
</div>
