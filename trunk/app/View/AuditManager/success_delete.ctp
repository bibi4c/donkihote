<div class="mainarea">
    <table id="serchfield">
        <tr>
            <th>監査項目削除が完了しました。</th>
        </tr>
        <tr>
            <td colspan="10">
                <div class="btn">
                    <?php echo $this->Html->link('カレンダーへ戻る', array('controller' => 'calendar', 'action' => 'index'), array('class' => 'btnStandard linkCanceller posLeft')); ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="10">
                <div class="btn">
                    <?php echo $this->Html->link('検索へ戻る', array('controller' => 'AuditManager', 'action' => 'search'), array('class' => 'btnStandard linkCanceller posLeft')); ?>
                </div>
            </td>
        </tr>
    </table>
</div>