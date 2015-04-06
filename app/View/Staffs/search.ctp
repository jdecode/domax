<table cellpadding="0" align="center" width="100%" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id', 'Sr No'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id', 'Staff Name'); ?></th>

            <th><?php echo $this->Paginator->sort('father_name'); ?></th>
            <th><?php echo $this->Paginator->sort('dob'); ?></th>
            <th><?php echo $this->Paginator->sort('references'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach ($staffs as $staff): ?>
            <tr>
                <td><?php echo h($staff['Staff']['id']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($staff['Staff']['name'], array('controller' => 'users', 'action' => 'view', $staff['User']['id'])); ?>
                </td>

                <td><?php echo h($staff['Staff']['father_name']); ?>&nbsp;</td>
                <td><?php echo h($staff['Staff']['dob']); ?>&nbsp;</td>
                <td><?php echo h($staff['Staff']['references']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $staff['Staff']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $staff['Staff']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $staff['Staff']['id']), null, __('Are you sure you want to delete # %s?', $staff['Staff']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>