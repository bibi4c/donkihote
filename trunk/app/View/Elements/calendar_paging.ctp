<?php
$root = $this->App->webroot('/');
$textcolor = array('blue', 'red', 'blue', 'blue', 'blue');
$text = array('未実施', '監査完了', '承認待ち', '是正中', '実施中');
$icon = array('img/tron1.png', 'img/tron3.png', 'img/tron2.png', 'img/tron1.png', 'img/tron1.png');
$link = array('AuditManager/index', 'AuditManager/index', 'AuditManager/index', 'AuditManager/index', 'AuditManager/index', 'Calendar/eventlist');
$options = "";
//debug($audits);
$date0 = "0";
$count_bibi = 0;
foreach ($audits as $audit) {
    $date1 = $audit ['Audit'] ['audit_scheduled_date'];
    if ($date1 != $date0) {
        if ($count_bibi > 2) {
            $options3 = "{";
            $count_bibi = $count_bibi - 2;
            $options3 .= "title: '<span></span><a style=\" position: absolute;margin-top: 20px;padding-left: 15px;color:" . $textcolor[0] . "\" class=\"fancybox fancybox.iframe\" href=\"" . $root . $link[5] . '/' . $date0 . "\">他" . $count_bibi . "件</a>',";
            $date22 = date('Y/m/d', strtotime($date0));
            $options3 .= "start: new Date('" . $date22 . "')},";
            //debug($date0);
            $options .= $options3;
        }
        if (isset($options1))
            $options .= $options1;
    }
    if ($date1 == $date0) {
        $count_bibi++;
        if ($count_bibi < 3)
            $options1 .="{";
    }
    else {
        $count_bibi = 1;
        $options1 = "{";
    }
    if ($count_bibi < 3) {
        $id = $audit ['Audit'] ['status'];
        $no = $audit ['Audit'] ['store_no'];
        $item_ids = $audit ['Audit'] ['item_id'];
        $date = $audit ['Audit'] ['audit_end_date'];
        if ($date != NULL) {
            $date = date('Y年n月j日', strtotime($date));
            $date = "(" . $date . ")";
        }
        $options1 .= "title: '<img style=\"vertical-align: sub;\" src=\"" . $root . $icon[$item_ids] . "\"><a href=\"" . $root . $link[$id] . '/' . $audit ['Audit'] ['audit_id'] . "\" style=\"text-decoration:none\"><span style=\" color:" . $textcolor[$id] . "\">" . $no . ":" . $text[$id] . "<br /><span style=\" margin-left: 20px;\">" . $date . "</span></span></a>',";

        $date22 = date('Y/m/d', strtotime($audit ['Audit'] ['audit_scheduled_date']));
        $options1 .= "start: new Date('" . $date22 . "')},";
        //debug($date22);
        //debug('sdad'.$audit ['Audit'] ['audit_scheduled_date']);
    }
    $date0 = $date1;
}
if (isset($options1))
    $options .= $options1;
$len_tt = strlen($options);
$options[$len_tt - 1] = ' ';
//debug($options);
?>
<script>

    $(document).ready(function() {

        var date = new Date();
        //alert(date("2013/09/13"));
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var tt = window.location.href.toString().toLowerCase().replace('index', '').replace('/calendar', '');
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title'
            },
            editable: false,
            events: [
<?php
echo $options;
?>
            ]
        });

    });

</script>