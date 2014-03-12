<div class="fileuploads view">
    <h2><?php echo __('Fileupload'); ?></h2>
    <dl>
        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($fileupload['Fileupload']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($fileupload['Fileupload']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Type'); ?></dt>
        <dd>
            <?php echo h($fileupload['Fileupload']['type']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Size'); ?></dt>
        <dd>
            <?php echo h($fileupload['Fileupload']['size']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($fileupload['Fileupload']['created']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Fileupload'), array('action' => 'edit', $fileupload['Fileupload']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Fileupload'), array('action' => 'delete', $fileupload['Fileupload']['id']), null, __('Are you sure you want to delete # %s?', $fileupload['Fileupload']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Fileuploads'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Fileupload'), array('action' => 'add')); ?> </li>
    </ul>
</div>
