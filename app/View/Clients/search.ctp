  <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody><tr>

                <th><?php echo $this->Paginator->sort('id','Sr No.'); ?></th>
                <th><?php echo $this->Paginator->sort('user_id', 'Client Name'); ?></th>
                <th><?php echo $this->Paginator->sort('fileno'); ?></th>
                <th><?php echo $this->Paginator->sort('pancard'); ?></th>
                <th><?php echo $this->Paginator->sort('bussiness_name'); ?></th>
		
                <th width="150" class="ac"><?php echo __('Actions'); ?></th>
		
            </tr>
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?php echo h($client['Client']['id']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($client['Client']['name'], array('controller' => 'users', 'action' => 'view', $client['User']['id'])); ?>
                </td>
                <td><?php echo h($client['Client']['fileno']); ?>&nbsp;</td>
                <td><?php echo h($client['Client']['pancard']); ?>&nbsp;</td>
                <td><?php echo h($client['Client']['bussiness_name']); ?>&nbsp;</td>

                <td class="actions">

                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $client['Client']['id']),array('class'=>'ico view')); ?>
<?php  if($_SESSION['Auth']['User']['group_id']=='1'){ ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $client['Client']['id']),array('class'=>'ico edit')); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $client['Client']['id']), null, __('Are you sure you want to delete # %s?', $client['Client']['id'])); ?>
<?php } ?>
                </td>

            </tr>
        <?php endforeach; ?>

        </tbody></table>