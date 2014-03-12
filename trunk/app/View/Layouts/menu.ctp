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
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--[if lt IE 9]>
        <?php echo $this->Html->script(array('html5.js')); ?>
         <![endif]-->
        <?php echo $this->Html->charset(); ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo '監査報告書データ管理：メニュー'; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->script(array('common', 'bootstrap'));
        echo $this->Html->css(array('style', 'reset'));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div class="main">
                    <h1>メニュー</h1>
                </div>
            </div>

            <div id="container">
                <div class="toparea clearfix">
                    <div class="link">
                        <?php
                        echo $this->Html->link('ホーム', array('controller' => 'menu', 'action' => 'index'), array('escape' => false, 'class' => 'smHome')
                        );
                        ?>
                        <?php
                        echo $this->Html->link('ログアウト', array('controller' => 'login', 'action' => 'logout'), array('escape' => false, 'class' => 'smLogout')
                        );
                        ?>
                    </div>
                </div>
                <div class="mainarea">		
                    <ul id="operationMenu" class="clearfix">
                        <li><?php
                        echo $this->Html->link(
                                $this->Html->image("menu_calendar.png", array("alt" => "カレンダー")), array('controller' => 'calendar', 'action' => 'index'), array('escape' => false)
                        );
                        ?>
                        </li>
                        <li><?php
                            echo $this->Html->link(
                                    $this->Html->image("menu_search.png", array("alt" => "監査情報検索")), array('controller' => 'AuditManager', 'action' => 'search'), array('escape' => false)
                            );
                            ?>
                        </li>
                        <li><?php
                            if ($aryUser['authority_id'] == '2' || $aryUser['authority_id'] == '4')
                                echo $this->Html->link(
                                        $this->Html->image("menu_editdocs.png", array("alt" => "書類項目編集")), array('controller' => 'document', 'action' => 'index'), array('escape' => false)
                                );
                            ?>
                        </li>
                        <li><?php
                            if ($aryUser['authority_id'] == '2' || $aryUser['authority_id'] == '4')
                                echo $this->Html->link(
                                        $this->Html->image("menu_editstore.png", array("alt" => "店舗情報編集")), array('controller' => 'store', 'action' => 'index'), array('escape' => false)
                                );
                            ?>
                        </li>
                        <li><?php
                            if ($aryUser['authority_id'] == '2' || $aryUser['authority_id'] == '4')
                                echo $this->Html->link(
                                        $this->Html->image("menu_edituser.png", array("alt" => "ユーザー情報編集")), array('controller' => 'user', 'action' => 'index'), array('escape' => false)
                                );
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
