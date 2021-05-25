
		<table id="example1" class="table table-bordered table-striped">
			<tbody>
			<?php 
				foreach($role_data as $row){

					$permission = json_decode($row['permission']);
					foreach($parent_permission as $row1){
			?>
						<tr>
							<td>
								<?php echo ucfirst($row1['name']); ?>
							</td>
							<td>
								<label class="switch">
								<input id="per_<?php echo $row1['id']; ?>" class="sw2 parent_title" type="checkbox" name="permission[]"  value="<?php echo $row1['id']; ?>" data-id="<?php echo $row1['id']; ?>" data-select="<?php echo $row1['id']; ?>" <?php
								if (in_array($row1['id'], $permission)) {
									echo 'checked';
								}
								?> />
								<span class="slider round"></span>
								</label>
							</td>

							<?php
							foreach ($parent_sub[$row1['id']] AS $k => $v) {
								?>                                   
								<td style="font-size: 14px;">
									<strong> <?php echo ucfirst($v['name']); ?></strong>
								</td>
								<td>
									<label class="label" style="padding:0px 0px 0px">
										<input data-parentId="<?= $row1['id'] ?>" id="subper_<?php echo $v['id']; ?>" class="label__checkbox subcheckbpxes per_<?= $row1['id'] ?> sub_title" type="checkbox" name="permission[]" value="<?php echo $v['id']; ?>" data-id="<?php echo $v['id']; ?>" data-pid="<?php echo $row1['id']; ?>" <?php
										if (in_array($v['id'], $permission)) {
											echo 'checked';
										}
										?> />
										<span class="label__text">
											<span class="label__check">
												<i class="fa fa-check icon"></i>
											</span>
										</span>
									</label>
								</td>
								<?php
							}
							?>
						</tr>
			<?php 
					}
				}

			?>	

			<?php echo form_error('permission[]');?>
                                <label id="permission[]-error" class="errors" for="permission[]"></label>
			
			</tbody>
		</table>	
		
<script>

/******************* Permission **********************/
$(".parent_title").click(function (){
	var select_id = $(this).attr("data-select");	
	if($(this).is(':checked')){
		$(".per_"+select_id).each(function (){
			$(this).prop("checked", true);
		});
	}else{
		$(".per_"+select_id).each(function (){
			$(this).prop("checked", false);
		});
	}
});
$(".sub_title").click(function (){
	var select_id = $(this).attr("data-pid");
	if($(this).is(':checked')){
		$("#per_"+select_id).prop("checked", true);
	}
});
/****************** End Permission **********************/


</script>
