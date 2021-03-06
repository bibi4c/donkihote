<?php
//  debug ( $data );
// debug($stores);
// debug($property);
// debug($items);
// debug($audit_files);
//debug($category);
// debug($audit_id);
// die;
//debug($data);
?>
<?php $user = $this->Session->read('Auth.User'); ?>
<?php echo $this->Form->create('AuditManager', array('type' => 'post', 'url' => array('controller' => 'AuditManager', 'action' => 'index', $audit_id))); ?>
<table id="summaryField">
    <caption>各種ステータス</caption>
    <col width="10%" />
    <col width="15%" />
    <col width="10%" />
    <col width="15%" />
    <col width="10%" />
    <col width="15%" />
    <col width="10%" />
    <col width="15%" />
    <tr>

        <th>状態</th>
        <td>
            <?php
            echo $data_status;
            echo $this->Form->hidden('status', array(
                'label' => false,
                'div' => false,
                'value' => $data['AuditManager']['status']
            ));
            echo $this->Form->hidden('audit_id', array('label' => false, 'value' => $data['AuditManager']['audit_id']));
            ?>
        </td>

        <th>店番</th>
        <td>
            <?php
            echo $stores ['0'] ['Store'] ['store_no'];

            echo $this->Form->hidden('store_id', array(
                'label' => false,
                'div' => false,
                'value' => $stores ['0'] ['Store'] ['store_id']
            ));
            ?>
        </td>

        <th>店舗名</th>
        <td>
            <?php
            echo $stores ['0'] ['Store'] ['name'];
            echo $this->Form->hidden('store_name', array(
                'label' => false,
                'div' => false,
                'value' => $stores ['0'] ['Store'] ['name']
            ));
            ?>
        </td>

        <th>属性</th>
        <td>
            <?php
            echo $property ['0'] ['Property'] ['name'];
            echo $this->Form->hidden('property_id', array(
                'label' => false,
                'div' => false,
                'value' => $property ['0'] ['Property'] ['puroperty_id']
            ));
            ?>
        </td>
    </tr>
    <tr>
        <th>ジャンル</th>
        <td colspan="7">
            <?php
            echo $items ['0'] ['Item'] ['name'];
            echo $this->Form->hidden('item_id', array(
                'label' => false,
                'div' => false,
                'value' => $items ['0'] ['Item'] ['item_id']
            ));
            ?>
        </td>
    </tr>
    <tr>
        <th>監査予定日</th>
        <td>
            <?php
            if (strlen($data ['AuditManager'] ['audit_scheduled_date']) > 0) {
                $date = $data ['AuditManager'] ['audit_scheduled_date'];
                $date = date('Y年n月j日', strtotime($date));
            } else
                $date = '';
            echo $date;
            //echo $data ['AuditManager'] ['audit_scheduled_date'];
            echo $this->Form->hidden('audit_scheduled_date', array(
                'label' => false,
                'div' => false,
                'value' => $data ['AuditManager'] ['audit_scheduled_date']
            ));
            ?>
        </td>

        <th>監査日</th>
        <td>
            <?php
            if ($data['AuditManager']['status'] != 0) {
                if (strlen($data ['AuditManager'] ['audit_date']) > 0) {
                    $date = $data ['AuditManager'] ['audit_date'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
            }
            ?>
        </td>
        <th>承認日</th>
        <td>
            <?php
            if ($data['AuditManager']['status'] != 0) {
                if (strlen($data ['AuditManager'] ['approval_date']) > 0) {
                    $date = $data ['AuditManager'] ['approval_date'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
            }
            ?>
        </td>
        <th>監査完了日</th>
        <td>
            <?php
            if ($data['AuditManager']['status'] != 0) {

                if (strlen($data ['AuditManager'] ['audit_end_date']) > 0) {
                    $date = $data ['AuditManager'] ['audit_end_date'];
                    $date = date('Y年n月j日', strtotime($date));
                } else
                    $date = '';
                echo $date;
            }
            ?>
        </td>
    </tr>
    <tr>
        <th>是正通知日</th>
        <td>
            <?php
            if (strlen($data ['AuditManager'] ['correct_information_date']) > 0) {
                $date = $data ['AuditManager'] ['correct_information_date'];
                $date = date('Y年n月j日', strtotime($date));
            } else
                $date = '';
            echo $date;
            ?>
        </td>
        <th>是正完了予定日</th>
        <td>
            <?php
            if (strlen($data ['AuditManager'] ['correct_end_scheduled_date']) > 0) {
                $date = $data ['AuditManager'] ['correct_end_scheduled_date'];
                $date = date('Y年n月j日', strtotime($date));
            } else
                $date = '';
            echo $date;
            ?>
        </td>
        <th>是正完了日</th>
        <td colspan ="1">
            <?php
            if (strlen($data ['AuditManager'] ['correct_end_date']) > 0) {
                $date = $data ['AuditManager'] ['correct_end_date'];
                $date = date('Y年n月j日', strtotime($date));
            } else
                $date = '';
            echo $date;
            ?>
        </td>
        <th>担当者</th>
        <td colspan ="1">
            <?php
            echo $user_create['User']['user_name'];
            ?>
        </td>
    </tr>
    <tr>
        <th>良/可/不可/全</th>
        <td colspan="7">
<?php
if ($data['AuditManager']['status'] != 0) {
    echo $count1_all . '/' . $count2_all . '/' . $count3_all . '/' . $count_all;
}
?>
        </td>
    </tr>
</table>
            <?php if ($data ['AuditManager'] ['comment'] != NULL) { ?>
    <table class="summaryObject">
        <caption>コメント</caption>
        <tr>
            <td>
    <?php
    $text = $data ['AuditManager'] ['comment'];
    echo nl2br(h($text));
    echo $this->Form->hidden('comment', array('type' => 'text', 'label' => false, 'value' => $data['AuditManager']['comment']));
    ?>
            </td>
        </tr>
    </table>
<?php } ?>

<?php if ($data_status != "未実施") { ?>

                <?php if (count($data_audit_file) > 0) { ?>
        <table class="summaryObject">
            <caption>是正勧告書</caption>
            <tr>
                <td>

                    <?php
                    $linkDownload = $this->Html->url(array(
                        "controller" => "AuditManager",
                        "action" => "download",
                        "5"
                    ));
                    if (count($data_audit_file) > 0) {
                        foreach ($data_audit_file as $audit_file) {
                            $linkDownload = $this->Html->url(array(
                                "controller" => "AuditManager",
                                "action" => "download", $audit_file['Audit_file']['audit_file_id']
                            ));
                            echo "<p><a href='$linkDownload'>" . $audit_file['Audit_file']['audit_file_name'] . '</a></p>';
                        }
                    } else
                        echo '添付ファイルがありません';
                    ?>
                </td>
            </tr>
        </table>
    <?php }
    ?>
    <table class="detailInspectionlist">
        <col width="50%" />
        <col width="8%" />
        <col width="8%" />
        <col width="8%" />
        <col width="8%" />
        <col width="18%" />

        <tr>
            <th>カテゴリ名</th>
            <th>全</th>
            <th>良</th>
            <th>可</th>
            <th>不可</th>
            <th>状態</th>
        </tr>
        <?php
        $count_bibi = count($category);
        $count_babi = 0;
        foreach ($category as $cate) {
            $count1 = 0;
            $count2 = 0;
            $count3 = 0;
            $count = 0;
            $count4 = 0;
            // debug($data_documents);
            foreach ($data_documents as $babi) {
                if ($babi['Document']['category_id'] == $cate['Category']['category_id']) {
                    foreach ($data_audit_details as $bibi) {
                        if ($bibi['Audit_detail']['document_id'] == $babi['Document']['document_id']) {
                            $count++;
                            if ($bibi['Audit_detail']['judgment'] == 1)
                                $count1++;
                            if ($bibi['Audit_detail']['judgment'] == 2)
                                $count2++;
                            if ($bibi['Audit_detail']['judgment'] == 3)
                                $count3++;
                            if ($bibi['Audit_detail']['judgment'] == 4)
                                $count4++;
                        }
                    }
                }
            }
            if ($count1 > 0 || $count2 > 0 || $count3 > 0) {
                $count = $count1 + $count2 + $count3;
            }
            if ($count > 0) {
                if ($count == $count4)
                    $count = 0;
                if ($count == $count1 + $count2 + $count3) {
                    $count_bibi--;
                }
            }
        }
        $count_babi+= $count3;
        if (isset($data_document_cate) && count($data_document_cate) > 0) {
            $count_bibi+=count($data_document_cate);
            foreach ($data_document_cate as $cate1) {
                $c = 0;
                $c1 = 0;
                $c2 = 0;
                $c3 = 0;
                $c4 = 0;
                foreach ($document1 as $doc1) {
                    if ($cate1['Document']['category_id'] == $doc1['Document']['category_id']) {
                        foreach ($arr_data_audit_detail_all as $audit1) {
                            if ($audit1['Audit_detail']['document_id'] == $doc1['Document']['document_id']) {
                                $c++;
                                if ($audit1['Audit_detail']['judgment'] == 1)
                                    $c1++;
                                if ($audit1['Audit_detail']['judgment'] == 2)
                                    $c2++;
                                if ($audit1['Audit_detail']['judgment'] == 3)
                                    $c3++;
                                if ($audit1['Audit_detail']['judgment'] == 4)
                                    $c4++;
                            }
                        }
                    }
                }
                if ($c1 > 0 || $c2 > 0 || $c3 > 0) {
                    $c = $c1 + $c2 + $c3;
                }
                if ($c > 0) {
                    if ($c == $c4)
                        $c = 0;
                    if ($c == $c1 + $c2 + $c3) {
                        $count_bibi--;
                    }
                }
            }
        }
        if (isset($c3))
            $count_babi+=$c3;
        ?> 

        <?php if (isset($data_document_cate) && count($data_document_cate) > 0) { ?>
            <?php
            //debug($data_document_cate);
            foreach ($data_document_cate as $cate1) {
                $c = 0;
                $c1 = 0;
                $c2 = 0;
                $c3 = 0;
                $c4 = 0;
                foreach ($document1 as $doc1) {
                    if ($cate1['Document']['category_id'] == $doc1['Document']['category_id']) {
                        foreach ($arr_data_audit_detail_all as $audit1) {
                            if ($audit1['Audit_detail']['document_id'] == $doc1['Document']['document_id']) {
                                $c++;
                                if ($audit1['Audit_detail']['judgment'] == 1)
                                    $c1++;
                                if ($audit1['Audit_detail']['judgment'] == 2)
                                    $c2++;
                                if ($audit1['Audit_detail']['judgment'] == 3)
                                    $c3++;
                                if ($audit1['Audit_detail']['judgment'] == 4)
                                    $c4++;
                            }
                        }
                    }
                }
                if ($c1 > 0 || $c2 > 0 || $c3 > 0) {
                    $c = $c1 + $c2 + $c3;
                }
                ?>	
                        <?php
                        if ($c > 0) {
                            if ($c == $c4)
                                $c = 0;
                            ?>
                    <tr>
                        <td>
                <?php
                if ($c == $c1 + $c2 + $c3) {
                    echo $this->Html->link($arr_cate[$cate1['Document']['category_id']] . ' （現金実査表からの引き継ぎ）', array('controller' => 'Category', 'action' => 'view1', $cate1['Document']['category_id'], $data['AuditManager']['audit_id']));
                } else {
                    if ($count_bibi == 1) {
                        echo $this->Html->link($arr_cate[$cate1['Document']['category_id']] . ' （現金実査表からの引き継ぎ）', array('controller' => 'Category', 'action' => 'view', $cate1['Document']['category_id'], $data['AuditManager']['audit_id'], '102', $count_babi));
                    } else
                        echo $this->Html->link($arr_cate[$cate1['Document']['category_id']] . ' （現金実査表からの引き継ぎ）', array('controller' => 'Category', 'action' => 'view', $cate1['Document']['category_id'], $data['AuditManager']['audit_id']));
                }
                ?>
                        </td>
                        <td>
                    <?php echo $c; ?>
                        </td>
                        <td>
                    <?php echo $c1; ?>
                        </td>
                        <td><?php echo $c2; ?></td>
                        <td><?php echo $c3; ?></td>
                        <td>
                    <?php
                    if ($c == $c1 + $c2 + $c3) {
                        echo "入力済み";
                    } else {
                        echo "未実施";
                    }
                    ?>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>



            <?php
            //debug($category);
            foreach ($category as $cate) {
                ?>
            <tr>
                <?php
                $count1 = 0;
                $count2 = 0;
                $count3 = 0;
                $count = 0;
                $count4 = 0;
                $count_5 = 0;
                // debug($data_documents);
                foreach ($data_documents as $babi) {
                    if ($babi['Document']['category_id'] == $cate['Category']['category_id']) {
                        foreach ($data_audit_details as $bibi) {
                            if ($bibi['Audit_detail']['document_id'] == $babi['Document']['document_id']) {
                                $count++;
                                if ($bibi['Audit_detail']['judgment'] == 1)
                                    $count1++;
                                if ($bibi['Audit_detail']['judgment'] == 2)
                                    $count2++;
                                if ($bibi['Audit_detail']['judgment'] == 3)
                                    $count3++;
                                if ($bibi['Audit_detail']['judgment'] == 4)
                                    $count4++;
                            }
                        }
                    }
                }
                if ($count1 > 0 || $count2 > 0 || $count3 > 0) {
                    $count = $count1 + $count2 + $count3;
                }
                ?>
                    <?php
                    if ($count > 0) {
                        if ($count == $count4)
                            $count = 0;
                        ?>
                    <td>
                        <?php
                        if ($count == $count1 + $count2 + $count3) {
                            echo $this->Html->link($cate['Category']['category_name'], array('controller' => 'Category', 'action' => 'view1', $cate['Category']['category_id'], $data['AuditManager']['audit_id']));
                        } else {
                            if ($count_bibi == 1) {
                                echo $this->Html->link($cate['Category']['category_name'], array('controller' => 'Category', 'action' => 'view', $cate['Category']['category_id'], $data['AuditManager']['audit_id'], '102', $count_babi));
                            } else
                                echo $this->Html->link($cate['Category']['category_name'], array('controller' => 'Category', 'action' => 'view', $cate['Category']['category_id'], $data['AuditManager']['audit_id']));
                        }
                        ?>

                    </td>
                    <td><?php
                //$count4 = $count1 + $count2 + $count3;
                echo $count;
                ?></td>
                    <td>
                <?php echo $count1 ?>
                    </td>
                    <td> <?php echo $count2 ?> </td>
                    <td> <?php echo $count3 ?> </td>
                    <td>
                <?php
                // debug($count); debug($count1); debug($count2); debug($count3);debug($count3);
                if ($count == $count1 + $count2 + $count3) {
                    echo "入力済み";
                } else {
                    echo "未実施";
                }
                //if ($data_status == "実施中") echo "未実施";
                ?>
                    </td>
            <?php } ?>
            </tr>
        <?php } ?>
    <?php } ?>
</table>

<div id="actionField" class="clearfix">
    <?php
    if ($data['AuditManager']['status'] == 0) {
        if ($user['authority_id'] == 1 || $user['authority_id'] == 4) {
            ?>
            <button class="btnStandard linkCanceller posright" type="submit">監査開始</button>
            <?php
            if (isset($back_search)) {
                echo $this->Html->link('戻る', array('controller' => 'AuditManager', 'action' => 'search'), array('class' => 'btnCanceller linkCanceller posLeft'));
            } else {
                echo $this->Html->link('戻る', array('controller' => 'calendar', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft'));
            }
            ?>
            <?php //echo $this->Html->link('戻る', array('controller'=>'calendar', 'action'=>'index'), array('class'=>'btnCanceller linkCanceller posLeft'));?>
            <?php echo $this->Html->link('削除', array('controller' => 'AuditManager', 'action' => 'delete_confirm', $data['AuditManager']['audit_id']), array('class' => 'btnDelete linkCanceller posright posright1')); ?>
        <?php } else { ?>
            <?php
            if (isset($back_search)) {
                echo $this->Html->link('戻る', array('controller' => 'AuditManager', 'action' => 'search'), array('class' => 'btnCanceller linkCanceller posLeft'));
            } else {
                echo $this->Html->link('戻る', array('controller' => 'calendar', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft'));
            }
            ?>
        <?php } ?>

    <?php } else if ($data['AuditManager']['status'] == 1 || $data['AuditManager']['status'] == 2 || $data['AuditManager']['status'] == 3) { ?>
        <?php if ($user['authority_id'] == 2 || $user['authority_id'] == 4) { ?>
            <?php echo $this->Html->link('更新画面へ', array('controller' => 'AuditManager', 'action' => 'view', $audit_id), array('class' => 'btnStandard linkCanceller posright')); ?>
            <?php
            if (isset($back_search)) {
                echo $this->Html->link('戻る', array('controller' => 'AuditManager', 'action' => 'search'), array('class' => 'btnCanceller linkCanceller posLeft'));
            } else {
                echo $this->Html->link('戻る', array('controller' => 'calendar', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft'));
            }
            ?>
        <?php echo $this->Html->link('是正勧告書印刷', array('controller' => 'AuditManager', 'action' => 'report_edit', $data['AuditManager']['audit_id']), array('class' => 'btnStandard linkCanceller posright posright1', 'target' => '_blank')); ?>
        <?php echo $this->Html->link('作業報告書印刷', array('controller' => 'AuditManager', 'action' => 'report_work', $data['AuditManager']['audit_id']), array('class' => 'btnStandard linkCanceller posright posright1', 'target' => '_blank')); ?>
    <?php } else { ?>
        <?php
        if (isset($back_search)) {
            echo $this->Html->link('戻る', array('controller' => 'AuditManager', 'action' => 'search'), array('class' => 'btnCanceller linkCanceller posLeft'));
        } else {
            echo $this->Html->link('戻る', array('controller' => 'calendar', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft'));
        }
        ?>
    <?php } ?>
<?php } else { ?>
    <?php
    if (isset($back_search)) {
        echo $this->Html->link('戻る', array('controller' => 'AuditManager', 'action' => 'search'), array('class' => 'btnCanceller linkCanceller posLeft'));
    } else {
        echo $this->Html->link('戻る', array('controller' => 'calendar', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft'));
    }
    ?>
<?php } ?>
</div>
<?php echo $this->Form->end(); ?>
<?php // $this->element('sql_dump') ?>
<script>
    function deleteFile(url, id) {
//alert(url);
        if (confirm('本当にこのファイルを削除しますか？')) {
            $.ajax({
                type: 'POST',
                url: url,
                data:
                        {
                        },
                success: function(data) {//alert(data);
                    $('.file_' + id).parent().hide();
                },
                error: function() {
                    alert("error");
                }

            });
        }
    }
</script>