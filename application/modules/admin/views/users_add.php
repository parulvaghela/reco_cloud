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
                 <form method="post" action="<?php echo base_url()?>admin/user_add" id="user_add_validate_js" name="user_add_validate_js" enctype="multipart/form-data">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Add</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('file_error')) { ?>
                                  <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('file_error'); ?>.</div>
                                <?php } ?>
              
                   
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User Role</label>
                                    <select class=" form-control" id="urole"  name="urole"> 
                                    <?php foreach($role_data as $role) {?>   
                                        <option value="<?php echo $role['id'] ?>"><?php echo $role['name']; ?></option>
                                        <?php  } ?>
                                    </select>
                                    <span class="error"><?php echo form_error('urole'); ?></span>
                                </div>              
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First Name </label>
                                    <input type="text" class="form-control" id="ufirst_name"  name="ufirst_name" placeholder="Enter First Name" value="<?php echo set_value('ufirst_name'); ?>" onkeypress="return isalpha(event);">  
                                    <span class="error"><?php echo form_error('ufirst_name'); ?></span>                     
                                </div>              
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="ulast_name"  name="ulast_name" placeholder="Enter Last Name" value="<?php echo set_value('ulast_name'); ?>" onkeypress="return isalpha(event);">
                                    <span class="error"><?php echo form_error('ulast_name'); ?></span>                     
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="uemail"  name="uemail" placeholder="Enter Email Address" value="<?php echo set_value('uemail'); ?>">  
                                    <span class="error"><?php echo form_error('uemail'); ?></span>
                                </div>              
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile No </label>
                                    <input type="text" class="form-control" id="umobile"  name="umobile" placeholder="Enter Mobile No" value="<?php echo set_value('umobile'); ?>" onkeypress="return isNumber(event);" onInput="checkLength();">  
                                    <span class="error"><?php echo form_error('umobile'); ?></span>                     
                                </div>              
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date Of Birth</label>
                                    <input type="Date" class="form-control" id="udob"  name="udob" value="<?php echo set_value('udob'); ?>">
                                    <span class="error"><?php echo form_error('udob'); ?></span>                     
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender:</label><br>
                                    <label class="radio-inline">
                                      <input type="radio" name="ugender" id="ugender1" value="1" <?php 
                                          if(set_radio('ugender', '1')){
                                            echo 'checked ';
                                          }else{
                                            echo 'checked';
                                          }
                                          ?>> male
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="ugender" id="ugender2" value="2"<?php 
                                          if(set_radio('ugender', '2')){
                                            echo 'checked ';
                                          }
                                          ?>> female
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="ugender" id="ugender3" value="3"
                                      <?php 
                                          if(set_radio('ugender', '3')){
                                            echo 'checked ';
                                          }
                                          ?>> other
                                    </label>
                                    <span class="error"><?php echo form_error('ugender'); ?></span>
                                </div>              
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="Password" class="form-control" id="upassword"  name="upassword" placeholder="Enter Password" value="<?php echo set_value('upassowrd'); ?>">  
                                    <span class="error"><?php echo form_error('upassword'); ?></span>
                                </div>              
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="Password" class="form-control" id="ucpassword"  name="ucpassword" value="" placeholder="Enter Confirm Password">
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>status</label>
                                    <select class="form-control" id="ustatus" name="ustatus">
                                      <option value="">select</option>
                                      <option value="1" <?php if($this->input->post('ustatus') == "1"){
                                            echo "selected";

                                          }?>>Active</option>
                                      <option value="0" <?php if($this->input->post('ustatus') == "0"){
                                            echo "selected";

                                          }?>>Deactive</option>
                                    </select>
                                    <span class="error"><?php echo form_error('ustatus'); ?></span>

                                </div>              
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Profile Pic</label>
                                    <input type="file" class="form-control" id="ufile"  name="ufile">  
                                </div>              
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Permission</h4>
                        </div>
                        <div id="permission_data_val"></div>
                        <div class="card-body" id="user_permission_show">
                                <!-- <label id="permission[]-error" class="errors" for="permission[]" style=""></label> -->
                            <button class="btn btn-primary" type="submit">Add User</button>
                            <a class="btn btn-outline-primary">cancel</a>
                        </div>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ADMIN_CUSTOM_JS; ?>user_add.js"></script>