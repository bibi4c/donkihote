<?php
//$this->Paginator->options(
//        array('update'=>'#content',
//                'url'=>array('controller'=>'User', 
//'action'=>'postlist')));
//debug($documents);
?>
<table class="resultlist" id="content">
    <tr>
        <th>項目番号</th>
        <th>内容</th>
        <th>ジャンル</th>
        <th>カテゴリ</th>
        <th>開始日</th>
        <th>終了日</th>
    </tr>

    <?php foreach ($documents as $document): ?>
        <tr>
            <td style="text-align: center;">
                <?php
                $item_id = $document['Document']['document_no'];
                $category_id = $document['Document']['category_id'];
                //debug($item_id);
                if ($item_id < 10) {
                    $item_id = '00' . $item_id;
                } else if (10 <= $item_id && $item_id < 100) {
                    $item_id = '0' . $item_id;
                }
                if ($category_id < 10) {
                    $category_id = '00' . $document['Document']['category_id'];
                } else if (10 <= $category_id && $category_id < 100) {
                    $category_id = '0' . $document['Document']['category_id'];
                }
                $document_no = $category_id . '-' . $item_id;
                echo $this->Html->link($document_no, array('controller' => 'document', 'action' => 'view', $document['Document']['document_id']));
                ?>
            </td>

            <td><?php echo $document['Document']['contents']; ?></td>
            <td><?php
                foreach ($items as $item) {
                    if ($item['Item']['item_id'] == $document['Document']['item_id']) {
                        echo $item['Item']['name'];
                        break;
                    }
                }
                ?></td>
            <td><?php
                foreach ($categories as $category) {
                    if ($category['Category']['category_id'] == $document['Document']['category_id']) {
                        echo $category['Category']['category_name'];
                        break;
                    }
                }
                ?></td>
            <td><?php
                if (strlen($document['Document']['start_date']) > 0) {
                    $date = $document['Document']['start_date'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
                ?>
            </td>
            <td><?php
            if (strlen($document['Document']['end_date']) > 0) {
                $date = $document['Document']['end_date'];
                $date = date('Y年n月j日', strtotime($date));
            } else
                $date = '';
            echo $date;
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
$pos = strrpos($this->here, "page");
?>
<?php if (count($data_all_document) > 10 || $pos == TRUE) { ?>
    <ul class="paging">
        <li>
            <?php
            echo $this->Paginator->prev('<', null, null, array('class' => 'nolink'));
            ?>
        </li>
        <li><?php echo $this->Paginator->numbers(array('separator' => '', 'style' => 'width:20px;')); ?></li>
        <li><?php echo $this->Paginator->next('>', null, null, array('class' => 'nolink')); ?></li>
    </ul>
        <?php
        }?>