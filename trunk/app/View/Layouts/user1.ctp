<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$aryUser = $this->Session->read('Auth.User');
if (isset($aryUser)) {
    $user_id = $aryUser['user_id'];
}
?>
<?php $webroot = $this->App->webroot('/'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo '監査報告書データ管理：' . $page_tittle; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->script('modernizr.custom.52985');
        echo $this->Html->css(array('reset', 'style', 'drag_drop'));

        echo $this->Html->css('jquery-ui');
        echo $this->Html->script('jquery-1.8.3');
        echo $this->Html->script('jquery.1.7.2.min');
        echo $this->Html->script('jquery-ui');
        echo $this->Html->script('jquery-ui-timepicker-addon');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
        <style>

            img {
                margin-top: -7px;
            }

            #header {
                background: none;
                height: 44px;
                position: absolute;
                width: 100%;
                z-index: 100;
            }
        </style>
<?php echo $this->Html->script(array('html5.js')); ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div class="main">
                    <h1><?php echo $page_tittle ?></h1>
                </div>
            </div>

            <div id="container">

                <div class="mainarea">	
<?php echo $this->Session->flash('auth'); ?>
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content');
                    ?>

                </div>
            </div>
        </div>
    </body>
</html>