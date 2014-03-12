<?php
//$this->Paginator->options(
//        array('update'=>'#content',
//                'url'=>array('controller'=>'User', 
//'action'=>'postlist')));
?>
<table class="resultlist" id="content">
    <tr>
        <th>ID</th>
        <th>担当者名</th>
        <th>権限</th>
        <th>メールアドレス</th>
        <th>有効／無効</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $this->Html->link($user['User']['user_id'], array('controller' => 'User', 'action' => 'view', $user['User']['user_id'])); ?></td>
            <td><?php echo $user['User']['user_name']; ?></td>
            <td><?php
                foreach ($authoritys as $author) {
                    if ($user['User']['authority_id'] == $author['Authority']['idauthority_id']) {
                        echo $author['Authority']['name'];
                        break;
                    }
                }
                ?></td>
            <td><?php echo $user['User']['mail_address']; ?></td>
            <td><?php
            if ($user['User']['valid_flag'] == 1) {
                echo '有効';
            } else if ($user['User']['valid_flag'] == 0) {
                echo '無効';
            }
                ?></td>
        </tr>
            <?php endforeach; ?>
</table>
    <?php if (count($data_all_user) > 10) { ?>
    <ul class="paging">
        <li><?php echo $this->Paginator->prev('<', null, null, array('class' => 'nolink')); ?></li>
        <li><?php echo $this->Paginator->numbers(array('separator' => '', 'style' => 'width:20px;')); ?></li>
        <li><?php echo $this->Paginator->next('>', null, null, array('class' => 'nolink')); ?></li>
    </ul>
<?php
}?>