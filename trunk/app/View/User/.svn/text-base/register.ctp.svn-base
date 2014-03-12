<style>
.error-message {
    display: none;
    margin-left: 10px;
}
#error_mes{
  	background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #999999;
    margin: 5px 0 30px;
    padding: 10px;
	display: none;
	font-weight: bold;
	font-size: 15px;
}
 </style>
 	<h4 id="error_mes" class="clearfix" style="top: 10px; color: red"></h4>
				<?php echo $this->Form->create('User',array('url'=>array('controller'=>'User','action'=>'register')));?>
				<table id="summaryField">
				<col width="15%" />
				<col width="85%" />
				<tr>
					<th>ID</th>
					<td>
                    <?php echo $this->Form->input('user_id',array('type'=>'text','style'=>'width: 190px;','value'=>$user_info['user_id'],'label'=>false, 'required' => FALSE));?>
                        </td>
				</tr>
                  <tr>
                    <th>名前</th>
                     <td>
                     <?php echo $this->Form->input('user_name',array('type'=>'text','style'=>'width: 190px;','value'=>$user_info['user_name'],'label'=>false,'required' => FALSE));?>
                     </td>
                     </tr>
                     
                     <tr>
                    <th>パスワード</th>
                     <td>
                     <?php echo $this->Form->input('password',array('type'=>'text','style'=>'width: 190px;','value'=>$user_info['password'],'label'=>false, 'required' => FALSE));?>
                     </td>
                     </tr>
                     
                <tr>
                    <th>権限</th>
                     <td >
                     <?php 
					    $options = array();
						foreach ($authoritys as $author){
						 $options +=  array($author['Authority']['idauthority_id']=>$author['Authority']['name']);
						}
						echo $this->Form->input ( '権限', array (
								'options' => $options,
								'default' => $user_info['authority_id'],
								'style' => 'width:200px; height:22px;', 
								'label'=>false
						) );
					 ?>
                    </td>
                </tr>  
				<tr>
                    <th>メールアドレス</th>
                     <td>
                     <?php echo $this->Form->input('mail_address',array('type'=>'text','style'=>'width: 190px;','required'=>FALSE,'label'=>false,'value'=>$user_info['mail_address']));?>
                     </td>
                     </tr>
                <tr>
                    <th>有効／無効</th>
                    <td>
                    <?php 
					$options = array (
									'1' => '有効',
									'0' => '無効' 
								);
					  echo $this->Form->input ( '有効／無効', array (
																'options' => $options,
																'default' => $user_info['valid_flag'],
																'style' => 'width:200px; height:22px;',
																'label'=>false 
															) );
					
					?>
                </tr>                
				</table>
                 <div id="actionField" class="clearfix">
                <?php echo $this->Html->link('戻る', array('controller'=>'User', 'action'=>'index'), array('class'=>'btnCanceller linkCanceller posLeft'));?>
                <button class="btnStandard linkCanceller posright" type="submit">登録</button>
			</div>
            <?php echo $this->Form->end(); ?>
 <script>
  var tt = ($(".error-message:first").text());
  $("#error_mes").text(tt);
  if (tt.length > 0) $("#error_mes").show();
</script>
            
