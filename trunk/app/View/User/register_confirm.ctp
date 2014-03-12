<div class="mainarea">
	 <div class="error_mes clearfix" style="display:block;margin: 5px 0 20px;"><h4 style="top: 10px; font-weight: bold;">以下の内容を登録します。よろしければOKボタンを押してください。</h4></div><br>
	<?php 
	echo $this->Form->create('User_confirm', array('url' => array('controller' => 'User', 'action' => 'success_register')));?>
	<table id="summaryField">
		<col width="15%" />
		<col width="85%" />
		<tr>
			<th>ID</th>
			<td>
				<?php 
				echo $user_data['User']['user_id'];
				echo $this->Form->hidden('user_id', array('label'=>false, 'value'=>$user_data['User']['user_id'],'style'=>'background:white;border:none;color:back', 'type'=>''));?>
			</td>
		</tr>
		<tr>
			<th>名前</th>
			<td>
				<?php 
				echo $user_data['User']['user_name'];
				echo $this->Form->hidden('user_name', array('label'=>false, 'value'=>$user_data['User']['user_name'],'style'=>'background:white;border:none;'));?>
			</td>

		</tr>
		 <tr>
			<th>パスワード</th>
			<td>
				<?php 
				echo $user_data['User']['password'];
				echo $this->Form->hidden('password', array('label'=>false, 'value'=>$user_data['User']['password'],'style'=>'background:white;border:none;','type'=>'text'));?>
			</td>

		</tr> 
		<tr>
			<th>権限</th>
			<td>
				<?php 
				echo $authority['0']['Authority']['name'];
				echo $this->Form->hidden('authority_id', array('label'=>false, 'value'=>$user_data['User']['権限'],'style'=>'background:white;border:none;'));?>		
			</td>
		</tr>
		<tr>
			<th>メールアドレス</th>
			<td>
				<?php 
				echo $user_data['User']['mail_address'];
				echo $this->Form->hidden('mail_address', array('label'=>false, 'value'=>$user_data['User']['mail_address'],'style'=>'background:white;border:none;'));?>
			</td>
		</tr>
		<tr>
			<th>有効／無効</th>
			<td><?php 
				echo $valid;
				echo $this->Form->hidden('valid_flag', array('label'=>false, 'value'=>$user_data['User']['有効／無効'], 'style'=>'background:white;border:none;'));
			?></td>
		</tr>
	</table>
	<div id="actionField" class="clearfix">
		 <?php echo $this->Html->link('キャンセル', array('controller'=>'User', 'action'=>'register'), array('class'=>'btnCanceller linkCanceller posLeft'));?>
         <button class="btnStandard linkCanceller posright"
			type="submit">OK</button>
	</div>
	 <?php echo $this->Form->end(); ?>
</div>

