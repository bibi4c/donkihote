<?php
echo $this->Html->script('jquery.fancybox');
echo $this->Html->css('jquery.fancybox');
?> 
<style>
    #calendar {
        width: 970px;
        margin: 0 auto;
    }
    .fc-button-gotoDate {
        float: right;
        margin-right: 20px;
        margin-top: -13px;
        right: -226px;
    }
    thead, th {
        background-color: white;
    }
</style>
<h4 style="top: 10px; color: red">
    <?php if (isset($e_message)) echo '<div class="error_mes clearfix" style="display:block">' . $e_message . '</div>' ?> 
</h4>

<?php echo $this->Form->create('searchForm', array('url' => array('controller' => 'calendar', 'action' => 'search'))); ?>
<table id="serchfield">
    <col width="9%" /><col width="25%" /><col width="9%" /><col width="25%" /><col width="9%" /><col width="23%" />
    <tr>
        <th style="font-size:16px">表示条件</th>
    <tr>
        <th>属性</th>
        <td>
            <?php
            $options = array('0' => '');
            foreach ($property_datas as $property) {
                $options += array(
                    $property ['Property'] ['puroperty_id'] => $property ['Property'] ['name']
                );
            }
            echo $this->Form->input('property_id', array(
                'options' => $options,
                'default' => $search ['searchForm'] ['property_id'],
                'style' => 'width:80%; height:22px;',
                'label' => false
            ));
            ?>
        </td>
        <th>ジャンル</th>
        <td>
            <?php
            $options = array('0' => '');
            foreach ($items as $item) {
                $options += array(
                    $item ['Item'] ['item_id'] => $item ['Item'] ['name']
                );
            }
            echo $this->Form->input('item_id', array(
                'options' => $options,
                'default' => $search ['searchForm'] ['item_id'],
                'style' => 'width:80%; height:22px;',
                'label' => false
            ));
            ?>
        </td>
        <th>担当者</th>
        <td>
            <?php
            $options = array('0' => '');
            foreach ($users as $user) {
                $options += array(
                    $user ['User'] ['user_id'] => $user ['User'] ['user_name']
                );
            }
            echo $this->Form->input('user_id', array(
                'options' => $options,
                'default' => $search ['searchForm'] ['user_id'],
                'style' => 'width:80%; height:22px;',
                'label' => false
            ));
            ?>
        </td>
    </tr>
    <tr>
        <th>状態</th>
        <td>
            <?php
            $options = array('' => '');
            $options += array('0' => '未実施');
            $options += array('4' => '実施中');
            $options += array('2' => '承認待ち');
            $options += array('3' => '是正中');
            $options += array('1' => '監査完了');

            echo $this->Form->input('status_n', array(
                'options' => $options,
                'default' => $search ['searchForm'] ['status_n'],
                'style' => 'width:80%; height:22px;',
                'label' => false
            ));
            ?>
        </td>
    </tr>	
    <tr>
        <td colspan="10">
            <div class="btn">			
                <input type="submit" name="login" value="この条件で検索する" style="height: 30px;" class="btnStandard posright" />
            </div>
        </td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>
<div id='calendar'></div>

<?php echo $this->element('calendar_paging');
?>
<div id="actionField" class="clearfix">
    <?php echo $this->Html->link('戻る', array('controller' => 'menu', 'action' => 'index'), array('class' => 'btnCanceller linkCanceller posLeft')); ?>
</div>

<script>
    $(document).ready(function() {

        $('.fancybox').click(function(event) {
            $('.fancybox').fancybox({
                'autoDimensions': false,
                'autoSize': false,
                'height': 300,
                'width': 330,
                'z-index': 10000,
                afterClose: function() {
                    //alert(id);	
                }
            });
        });
    });
</script>
<script>
    function gotolink(url) {
        parent.$.fancybox.close();
        window.location = url;
    }
</script>
