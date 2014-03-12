<style>
	#resultAction {
		width: 100%;
	}
	
	table#serchfield input.shopcode {
		width: 70%;
}
</style>
<?php
			if(!isset($authority)){
			   $authority = '0';
			};
			if(!isset($effective)){
			   $effective = '2';
			};
			if(!isset($name)){
			   $name = '';
			};
			
?>
<?php //debug($search);?>
<h4 style="top: 10px; color: red">
	<?php if (isset($e_message)) echo '<div class="error_mes clearfix" style="display:block">'.$e_message.'</div>'?> 
</h4>
<?php echo $this->Form->create('searchForm', array('url' => array('controller' => 'User', 'action' => 'search')));?>
<table id="serchfield">
	<col width="5%" />
	<col width="25%" />
	<col width="5%" />
	<col width="25%" />
	<col width="5%" />
	<col width="23%" />
	<tr>
		<th style="font-size: 16px"></th>
	<tr>
	<tr>
		<th>担当者名</th>
		<td>
			<?php echo $this->Form->input('担当者名', array('label'=>false,'value'=>$search['searchForm']['担当者名']));?>
		</td>
		<th>権限</th>
		<td>
			<?php
			
			$options = array ('0' => '');
			foreach ($authoritys as $author){
			 $options +=  array($author['Authority']['idauthority_id']=>$author['Authority']['name']);
			}
			echo $this->Form->input ( '権限', array (
					'options' => $options,
					'default' => $search['searchForm']['権限'],
					'style' => 'width:60%; height:22px;', 
					'label'=>false
			) );
			?>
		</td>
		<th>有効／無効</th>
		<td>
			<?php
				$options = array (
									'2' => '',
									'1' => '有効',
									'0' => '無効' 
								);
				echo $this->Form->input ( '有効／無効', array (
																'options' => $options,
																'default' => $search['searchForm']['有効／無効'],
																'style' => 'width:60%; height:22px;',
																'label'=>false 
															) );
			?>
	    </td>
	</tr>
	<tr>
		<td colspan="6">
			<div class="btn">
				<div class="MCC010_btn_color ">
				  <button class="btnStandard posright" type="submit" style="height: 30px;">この条件で検索する</button>
				</div>
			</div>
		</td>
	</tr>

</table>
<?php 	echo $this->Form->end(); ?>

<div id="resultSummary">
	<div id="resultAction">
		<?php echo $this->Html->link('新規作成', array('controller'=>'User', 'action'=>'register'), array('class'=>'btnStandard linkCanceller posright postop','style'=>'height: 30px;'));?>
	</div>
	<div id="resultCount">
						
						<?php
						if(!isset($paging_show)) echo $this->Paginator->counter ( array (
								'format' => __ ( '全<strong>{:count}</strong>件中　<strong>{:start}</strong>件～<strong>{:end}</strong>件を表示' ) 
						) );
						?>
	</div>
</div>
<?php  
if (! isset ( $paging_show ))
	echo $this->element ( 'paging' );
else {
	echo "<style>#actionField {margin:75px 0 0;}</style>";
}
?>

<?php //echo $this->Paginator->counter(); ?>
<div id="actionField" class="clearfix">
							<?php echo $this->Html->link('戻る', array('controller'=>'menu', 'action'=>'index'), array('class'=>'btnCanceller linkCanceller posLeft'));?>
</div>
