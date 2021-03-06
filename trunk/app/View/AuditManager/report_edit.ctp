<style>
    #wrapper {
        background-color: white;
    }
    table th {
        font-weight: bolder;
    }
    table td {
    }
    table.summaryObject caption {
        background: none repeat scroll 0 0 #EFEFEF;
        font-weight: bolder;
        color: black;
    }	
    table#summaryField caption {
        background: none repeat scroll 0 0 #EFEFEF;
        font-weight: bolder;
        color: black;
    }
</style>
<title><?php echo '是正報告書'; ?></title>
<?php
//  debug ( $data );
// debug($stores);
// debug($property);
// debug($items);
// debug($audit_files);
// debug($category);
//die;
echo $this->Html->css(array('reset', 'style'));
?>
<div id="wrapper">
    <div id="container">
        <div class="toparea clearfix"></div>
        <div>

            <h4 style="text-align: center; top: 10px;">
<!-- 				<img alt="是正報告書" src="img/title_correct.png"> -->
                <?php echo $this->Html->image('title_correct.png', array('alt' => '是正報告書')); ?>
                <br>
                <br>
            </h4>
        </div>

        <div class="mainarea">
            <table id="summaryField">
                <col width="10%" />
                <col width="15%" />
                <col width="10%" />
                <col width="15%" />
                <col width="10%" />
                <col width="15%" />
                <tr>
                    <th>店番</th>
                    <td>
                        <?php
                        echo $stores ['0'] ['Store'] ['store_no'];
                        ?> 
                    </td>
                    <th>店舗名</th>
                    <td>
                        <?php
                        echo $stores ['0'] ['Store'] ['name'];
                        ?>
                    </td>
                    <th>属性</th>
                    <td>
                        <?php
                        echo $property ['0'] ['Property'] ['name'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td colspan="5">
                        <?php
                        echo $items ['0'] ['Item'] ['name'];
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
                </tr>
                <tr>
                    <th>監査完了日</th>
                    <td colspan="5">
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
                    <td>
                        <?php
                        if (strlen($data ['AuditManager'] ['correct_end_date']) > 0) {
                            $date = $data ['AuditManager'] ['correct_end_date'];
                            $date = date('Y年n月j日', strtotime($date));
                        } else
                            $date = '';
                        echo $date;
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>状態</th>
                    <td>
                        <?php echo $data_status; ?>
                    </td>
                    <th>良／可／不可／全</th>
                    <td colspan="1">
<?php
if ($data['AuditManager']['status'] != 0) {
    echo $count1_all . '/' . $count2_all . '/' . $count3_all . '/' . $count_all;
} else {
    echo '0/0/0/0';
}
?>
                    </td>

                    <th>担当者</th>
                    <td colspan ="1">
            <?php
            echo $user_create['User']['user_name'];
            ?>
                    </td>
                </tr>

            </table>

                        <?php if (strlen($data ['AuditManager'] ['comment']) > 0) { ?>
                <table class="summaryObject">
                    <caption>コメント</caption>
                    <tr>
                        <td>
                <?php
                $text = $data ['AuditManager'] ['comment'];
                echo nl2br(h($text));
                ?>
                        </td>
                    </tr>
                </table>

                <?php } ?>

            <table id="summaryField">
                <col width="10%" />
                <col width="20%" />
                <col width="70%" />
                <caption>不可項目</caption>
                        <?php
                        if (isset($data_documents_judgment) && count($data_documents_judgment) > 0) {
                            foreach ($data_documents_judgment as $data_judgments) {
                                ?>
                        <tr>
                            <td>
                                <?php
                                $item_id = $data_judgments['Document']['document_no'];
                                $category_id = $data_judgments['Document']['category_id'];
                                //debug($item_id);
                                if ($item_id < 10) {
                                    $item_id = '00' . $item_id;
                                } else if (10 <= $item_id && $item_id < 100) {
                                    $item_id = '0' . $item_id;
                                }
                                if ($category_id < 10) {
                                    $category_id = '00' . $data_judgments['Document']['category_id'];
                                } else if (10 <= $category_id && $category_id < 100) {
                                    $category_id = '0' . $data_judgments['Document']['category_id'];
                                }
                                $document_no = $category_id . '-' . $item_id;
                                echo $document_no;
                                ?>
                            </td>
                            <td>
        <?php echo $arr_name_category[$data_judgments['Document']['category_id']]; ?>
                            </td>
                            <td>
        <?php echo $data_judgments['Document']['contents']; ?>
                            </td>
                        </tr>
    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>
<?php } ?>
            </table>


            <table id="summaryField">
                <col width="55%" />
                <col width="5%" />
                <col width="5%" />
                <col width="5%" />
                <col width="5%" />
                <tr>
                    <th></th>
                    <th>全</th>
                    <th>良</th>
                    <th>可</th>
                    <th>不可</th>
                </tr>
                <tr>
                    <?php
                    //debug($data_audit_details);
                    foreach ($category as $cate) {
                        ?>
                    <tr>
                        <?php
                        $count1 = 0;
                        $count2 = 0;
                        $count3 = 0;
                        $count = 0;
                        $count4 = 0;
                        foreach ($data_documents as $babi) {
                            if ($babi['Document']['category_id'] == $cate['Category']['category_id']) {
                                $count++;
                                foreach ($data_audit_details as $bibi) {
                                    if ($bibi['Audit_detail']['document_id'] == $babi['Document']['document_id']) {
                                        if ($bibi['Audit_detail']['judgment'] == 1)
                                            $count1++;
                                        if ($bibi['Audit_detail']['judgment'] == 2)
                                            $count2++;
                                        if ($bibi['Audit_detail']['judgment'] == 3)
                                            $count3++;
                                    }
                                }
                            }
                        }
                        if ($count1 > 0 || $count2 > 0 || $count3 > 0) {
                            $count = $count1 + $count2 + $count3;
                        }
                        ?>
    <?php if ($count > 0) { ?>
                            <td>
                            <?php
                            echo $cate['Category']['category_name'];
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
    <?php } ?>
                    </tr>
<?php } ?>
            </table>
            <table class="summaryObject">
                <caption>備考</caption>
                <tr>
                    <td style="border: 1px solid #333333;" height="100dpi"></td>
                </tr>
            </table>
        </div>
    </div>
</div>