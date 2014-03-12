<style>

    table#serchfield th {
        float: right;
        margin-left: -5%;
    }
    table#serchfield{
        margin-top: 13%;
    }

    .btn {
        margin: 0 auto 4%;
    }
    .login-input{
        width:33%;
        margin-top:10%;
        margin-right: 450px;
        margin-left: 70px;
    }
    .ie .login-input{
        width:33%;
        margin-top:10%;
        margin-right: 444px;
        margin-left: 63px;
    }
    #error_mes{
        background: none repeat scroll 0 0 #FFFFFF;
        border: 1px solid #999999;
        margin: 5px 0 30px;
        padding: 10px;
        display: none;
        font-weight: bold;
        font-size: 15px;
        color: red;
    }
</style>

<div id="error_mes" class="clearfix">
    <h4 style="top: 10px; color: red"></h4>
</div>
<h4 style="top: 10px; color: red">
    <?php if (isset($err_message)) echo '<div class="error_mes clearfix" style="display:block">' . $err_message . '</div>' ?> 
</h4>
<table id="serchfield">
    <?php
    echo $this->Form->create('User', array('url' => array('controller' => 'login', 'action' => 'login')));
    ?>
    <tr>
        <th><?php echo $this->Form->input('user_id', array('type' => 'text', 'class' => 'login-input', 'label' => 'ID', 'required' => false)); ?></th>

    </tr>
    <tr>
        <th><?php echo $this->Form->input('password', array('type' => 'password', 'style' => 'margin-right: 450px;margin-left: 20px;width:33%;', 'label' => 'パスワード', 'required' => false)); ?></th>
    </tr>			
    <tr>
        <td colspan="10">
            <div class="btn">
                <button class="btnStandard linkCanceller" style="margin: 5px -93px 5px 5px;line-height: 30px;float: none;" type="submit">ログイン</button>
            </div>
        </td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>
<script>
    var tt = ($(".error-message:first").text());
    $("#error_mes").text(tt);
    if (tt.length > 0)
        $("#error_mes").show();
</script>