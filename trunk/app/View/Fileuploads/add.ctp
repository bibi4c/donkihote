<?php
echo $this->Html->script(array('jquery-1.6.2.min', 'jquery-ui-1.8.14.custom.min', '14jquery.fileUploader'));
echo $this->Html->css(array('ui-lightness/jquery-ui-1.8.14.custom', 'fileUploader', 'drag_drop'));
?>
<style>
    .px-widget ul.actions {
        display: none;
    }
</style>
<script type="text/javascript">
    $(function() {
        $('.fileUpload').fileUploader({
            autoUpload: false,
            limit: false,
            buttonUpload: '#px-submit',
            buttonClear: '#px-clear',
            selectFileLabel: 'Select files',
            allowedExtension: '',
            timeInterval: [1, 2, 4, 2, 1, 5], //Mock percentage for iframe upload
            percentageInterval: [10, 20, 30, 40, 60, 80],
            //Callbacks
            onValidationError: null,
            onFileChange: function(e, form) {
            },
            onFileRemove: function(e) {
            },
            beforeUpload: function(e) {
            },
            beforeEachUpload: function(form) {
            },
            afterEachUpload: function(data, status, formContainer) {
            },
            afterUpload: function(formContainer) {
                if ($('.upload-data').hasClass('error')) {
                    alert("アップロードしましたファイルの形式は対応しておりません。");
                }
                parent.$.fancybox.close();
            }
        });
    });
    function hideTempu1() {
        document.getElementById('FileuploadFile').click();

    }
    function hideTempu() {
        //$("#file_drag").hide();
        document.getElementById('px-submit').click();
        window.scrollBy(0, 0);
        //
    }
    ;
    function hideTempu2() {
        document.getElementById('px-clear').click();
        parent.$.fancybox.close();

    }
    function isIE() {
        var myNav = navigator.userAgent.toLowerCase();
        return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
    }
</script>
<style>

    #px-submit{
        display: none;
    }
    #px-clear{
        display: none;

    }
    .status{
        display: none;
    }
    .upload-data{
        font-size: 18px;
    }
</style>
<?php
preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);

if (count($matches) > 1) {
    //Then we're using IE
    $version = $matches[1];
}
?>
<?php
if (isset($version) && $version < 10) {
    ?>
    <style>

        .px-widget .ui-button {
            float: right;
            height:45px;
            position: relative;
            width: 120px;
        }
    </style>
    <fieldset>
        <legend>ファイル添付</legend>
        <div class="fileuploads form">
            <?php echo $this->Form->create('Fileupload', array('type' => 'file')); ?>
            <?php
            echo $this->Form->input('file', array('type' => 'file', 'label' => '', 'class' => 'fileUpload', 'multiple' => 'multiple', 'style' => 'clear:both'));

            echo $this->Form->button('OK', array('type' => 'submit', 'id' => 'px-submit', 'style' => 'display:none'));
            echo $this->Form->button('キャンセル', array('type' => 'reset', 'id' => 'px-clear', 'style' => 'display:none'));
            ?>
            <?php
            echo $this->Form->end();
            //debug($this->request);
            ?>
            <div id="div_bibi" style="margin-top: 100px ">
                <button id="popup_button2" type="button" onclick="hideTempu2()">キャンセル</button>
                <button id="submitbutton" type="button" onclick="hideTempu()">OK</button>
            </div>
    </fieldset>
    <?php
} else {
    ?>
    <style>
        .ui-button {
            display: none;
        }
        .px-widget .ui-button {
            float: right;
            height: 33px;
        }

    </style>
    <fieldset>
        <legend>ファイル添付</legend>
        <div class="fileuploads form">
            <?php echo $this->Form->create('Fileupload', array('type' => 'file')); ?>
            <?php
            echo $this->Form->input('file', array('type' => 'file', 'label' => '', 'class' => 'fileUpload', 'multiple' => 'multiple'));
            echo $this->Form->button('OK', array('type' => 'submit', 'id' => 'px-submit', 'class' => ''));
            echo $this->Form->button('キャンセル', array('type' => 'reset', 'id' => 'px-clear', 'class' => ''));
            ?>
            <fieldset style="border: none" >
                <input type="button" id="get_file" onclick="hideTempu1()" value="参照">
                <input type="file" id="my_file">
                <div>
                    <div id="filedrag"><h1>ここにファイルをドラッグしてください</h1></div>
                </div> 
            </fieldset>
        </div>
        <div id="" style="margin-top: 10px;">	
            <button id="popup_button2" type="button" onclick="hideTempu2()">キャンセル</button>
            <button id="submitbutton" type="button" onclick="hideTempu()">OK</button>
        </div>
    </fieldset>
    <?php
    echo $this->Form->end();
    //debug($this->request);
}
?>
