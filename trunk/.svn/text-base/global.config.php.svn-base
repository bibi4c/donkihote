<?php

	//-----------------------------------------------------------------------------
	// DB設定＆情報
	//-----------------------------------------------------------------------------
	define('DB_USER', 		'root'); 		//DB接続ユーザ
	define('DB_PASSWORD',	'');
	define('DB_HOST',		'localhost');
	define('DB_NAME',		'audit_db');
	define('SYS_ENCODE',	'UTF8');		//システムエンコード

	//-----------------------------------------------------------------------------
	// メールサーバ設定
	//-----------------------------------------------------------------------------
	// SMTPサーバの場合に設定
	define('SENDMAIL_HOST',			'ominext.sakura.ne.jp');
	define('SENDMAIL_PORT',			587);
	define('SENDMAIL_TIMEOUT',		30);
	define('SENDMAIL_SENDER_MAIL',	'noreply@med.nihon-u.ac.jp');
	define('SENDMAIL_SENDER_NAME',	'監査報告書システム');
	define('SENDMAIL_USERNAME',		'test@ominext.com');
	define('SENDMAIL_PASSWORD',		'1qazxsw2');

	//送り先設定
	// _SENDMAIL_RECEIVER : 担当者
	// _SENDMAIL_SHOP : 店番
	// _SENDMAIL_GENRE : ジャンル
	define('SENDMAIL_SUBJECT',		'【監査報告書システム】店舗%%_SENDMAIL_SHOP%%報告書提出');
	define('SENDMAIL_CONTENT',		'監査結果が提出されました。<br><br>
									担当者: %%_SENDMAIL_RECEIVER%%<br>
									店番: %%_SENDMAIL_SHOP%%<br>
									ジャンル : %%_SENDMAIL_GENRE%%<br><br>
									※このメールには返信できません');
