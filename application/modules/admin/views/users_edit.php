<div class="content-body">
    <div class="container-fluid">
        <!--<div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Form</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Element</a></li>
            </ol>
        </div> -->
        <!-- row -->
        
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                   <form method="post" action="<?php echo base_url()?>admin/user_edit/<?php echo $member_data['id'];?>" id="user_edit_validate_js" name="user_edit_validate_js" enctype="multipart/form-data">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User List</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('file_error')) { ?>
                                  <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('file_error'); ?>.</div>
                                <?php } ?>
              
                 
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User Role</label>
                                    <select class=" form-control" id="e_urole"  name="e_urole"> 
                                        <option value="">select</option>

                                    <?php foreach($role_data as $role) {?>   
                                        <option <?php echo $role['id'] ?>><?php echo $role['name']; ?></option>
                                        <?php  } ?>
                                    </select>
                                    <span class="error"><?php echo form_error('e_urole'); ?></span>
                                </div>              
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First Name </label>
                                    <input type="text" class="form-control" id="e_ufirst_name"  name="e_ufirst_name" placeholder="Enter First Name" value="<?php if($member_data['first_name'] != "") {
                                        echo $member_data['first_name'];
                                    } else {
                                        echo set_value('e_ufirst_name'); 
                                    }?>" onkeypress="return isalpha(event);">  
                                    <span class="error"><?php echo form_error('e_ufirst_name'); ?></span>                     
                                </div>              
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="e_ulast_name"  name="e_ulast_name" placeholder="Enter Last Name" value="<?php if($member_data['last_name'] != "") {
                                        echo $member_data['last_name'];
                                    } else {
                                        echo set_value('e_ulast_name'); 

                                    }?>" onkeypress="return isalpha(event);">
                                    <span class="error"><?php echo form_error('e_ulast_name'); ?></span>                     
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="e_uemail"  name="e_uemail" placeholder="Enter Email Address" value="<?php if($member_data['email'] != "") {
                                        echo $member_data['email'];
                                    } else {
                                        echo set_value('e_uemail'); 
                                    }?>">  
                                    <span class="error"><?php echo form_error('e_uemail'); ?></span>
                                </div>              
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile No </label>
                                    <input type="text" class="form-control" id="e_umobile"  name="e_umobile" placeholder="Enter Mobile No" value="<?php if($member_data['mobile'] != "") {
                                        echo $member_data['mobile'];
                                    } else {
                                        echo set_value('e_umobile'); } ?>" onkeypress="return isNumber(event);" onInput="checkLength();">  
                                    <span class="error"><?php echo form_error('e_umobile'); ?></span>                     
                                </div>              
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date Of Birth</label>
                                    <input type="Date" class="form-control" id="e_udob"  name="e_udob" value="<?php if($member_data['dob'] != "") {
                                        echo $member_data['dob'];
                                    } else {echo set_value('e_udob');  }?>">
                                    <span class="error"><?php echo form_error('e_udob'); ?></span>                     
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender:</label><br>
                                    <label class="radio-inline">
                                      <input type="radio" name="e_ugender" id="e_ugender1" value="1" <?php 
                                          if(set_radio('e_ugender', '1')) {
                                              echo 'checked'; 
                                          }else{
                                             if($member_data['gender'] == '1' ){
                                          echo 'checked';
                                        }
                                          }?>> male
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="e_ugender" id="e_ugender2" value="2"<?php 
                                          if(set_radio('e_ugender', '2')) {
                                              echo 'checked'; 
                                          }else{
                                             if($member_data['gender'] == '2' ){
                                          echo 'checked';
                                        }
                                          }?>> female
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="e_ugender" id="e_ugender3" value="3"<?php 
                                          if(set_radio('e_ugender', '3')) {
                                              echo 'checked'; 
                                          }else{
                                             if($member_data['gender'] == '3' ){
                                          echo 'checked';
                                        }
                                          }?>
                                      <?php 
                                          if(set_radio('e_ugender', '3')){
                                            echo 'checked ';
                                          }
                                          ?>> other
                                    </label>
                                    <span class="error"><?php echo form_error('e_ugender'); ?></span>
                                </div>              
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="Password" class="form-control" id="e_upassword"  name="e_upassword" placeholder="Enter Password" value="<?php if($member_data['password'] != "") {
                                        echo $member_data['og_password'];
                                    } else { echo set_value('e_upassowrd'); } ?>">      
                                    <span class="error"><?php echo form_error('e_upassword'); ?></span>
                                </div>              
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="Password" class="form-control" id="e_ucpassword"  name="e_ucpassword" value="" placeholder="Enter Confirm Password">
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>status</label>
                                    <select class="form-control" id="e_ustatus" name="e_ustatus">
                                      <option value="">select</option>
                                      <option value="1" <?php if($member_data['status'] == "1"){
                                            echo "selected";

                                          }?>>Active</option>
                                      <option value="0" <?php if($member_data['status'] == "0"){
                                            echo "selected";

                                          }?>>Deactive</option>
                                    </select>
                                    <span class="error"><?php echo form_error('e_ustatus'); ?></span>

                                </div>              
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Profile Pic</label>
                                    <input type="file" class="form-control" id="e_ufile"  name="e_ufile">  
                                </div>              
                            </div>  
                        </div>
                    </div>
                </div>
                 <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Permission</h4>
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                                    <tbody>
                                        <?php if($parent_permission != 0) { 
                                                $permission = (array) json_decode($member_data['permission']);
                                                foreach($parent_permission AS $parent)
                                                { ?>
                                            <tr>
                                                <td>
                                                    <?php echo ucfirst($parent['name']); ?>
                                                </td>
                                                <td>
                                                <label class="switch">
                                                    <input id="per_<?php echo $parent['id']; ?>" class="sw2 parent_title" type="checkbox" name="permission[]"  value="<?php echo $parent['id']; ?>" data-id="<?php echo $parent['id']; ?>" data-select="<?php echo $parent['id']; ?>" <?php if(in_array($parent['id'], $permission)){ echo 'checked'; } ?> />
                                                    <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <?php
                                                    if (is_array($sub_permission[$parent['id']]) || is_object($sub_permission[$parent['id']]))
                                                    {
                                                     foreach($sub_permission[$parent['id']] AS $k =>$v){  ?> 
                                                    <td>
                                                        <?php echo ucfirst($v['name']); ?>  
                                                    </td>
                                                    <td>
                                                        <label class="label" style="padding:0px 0px 0px">
                                                            <input data-parentId="<?= $parent['id'] ?>" id="subper_<?php echo $v['id']; ?>" class="label__checkbox subcheckbpxes per_<?= $parent['id'] ?> sub_title" type="checkbox" name="permission[]" value="<?php echo $v['id']; ?>" data-id="<?php echo $v['id']; ?>" data-pid="<?php echo $parent['id']; ?>"  <?php if(in_array($v['id'], $permission)){ echo 'checked'; } ?>  />
                                                        </label>
                                                    </td>
                                                <?php }  } ?>
                                            </tr>
                                        <?php    }  ?>
                                       <?php  } ?>
                                    </tbody>
                                </table>
                            <label id="permission[]-error" class="errors" for="permission[]"></label>    
                        </div>
                        <button class="btn btn-primary" type="submit">Add User</button>
                        <a class="btn btn-outline-primary" href="<?php echo base_url()?>admin/user_view">cancel</a>
                    </div>

            </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ADMIN_CUSTOM_JS; ?>user_edit.js"></script>