<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
       <div class="container-fluid">
           <div class="row mb-2">
               <div class="col-sm-6">
                   <h1 class="m-0">Email Setting</h1>
               </div><!-- /.col -->
               <div class="col-sm-6">
                   <ol class="breadcrumb float-sm-right">
                       <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Home</a></li>
                       <li class="breadcrumb-item active">email setting</li>
                   </ol>
               </div><!-- /.col -->
           </div><!-- /.row -->
       </div><!-- /.container-fluid -->
   </div>
   <section class="content">
       <div class="container-fluid">
           <div class="row">
               <!-- left column -->
               <div class="col-md-12">
                   <!-- general form elements -->
                    <?php
                       $success = $this->session->flashdata('email_update_success');
                       if (isset($success)) {
                           echo $success;
                       }
                       ?>
                   <div class="card card-primary">
                       <div class="card-header">
                           <h3 class="card-title">Email Setting</h3>
                       </div>
                       <!-- /.card-header -->
                       <!-- form start -->
                       <form method="post" action="<?php echo base_url() ?>admin/email_setting" name="email_setting_validate" id="email_setting_validate">
                           <br>
                           <div class="card-body">
                                <div class="pkg_edit">
                                <div class="form-group">
                                   <label for="name">Name</label>
                                   <input type="text" class="form-control" id="name"  name="name" placeholder="Enter Name" onkeypress="return isalpha(event);"  value="<?php
                                   if (isset($get_email_setting_data['name'])) {
                                       echo $get_email_setting_data['name'];
                                   }
                                   ?>" >
                                    <?php echo form_error('name');?>
                               </div>
                               <div class="form-group">
                                   <label for="email">Email address</label>
                                   <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php
                                   if (isset($get_email_setting_data['smtp_user'])) {
                                       echo $get_email_setting_data['smtp_user'];
                                   }
                                   ?>">
                                    <?php echo form_error('email');?>
                               </div>
                               <div class="input-group mb-3">
                                    <label for="password">Password</label>
                                    <div class="inp_field">
                                    <input type="password" class="form-control" id="password"  name="password" placeholder="Enter Password" value="<?php echo key_decrypt($get_email_setting_data['smtp_pass']); ?>">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span toggle="#password-field" data-id="password" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                        </div>
                                    </div> 
                                    </div>
                                    <?php echo form_error('password');?>
                                    <label id="password-error" class="errors" for="password" style="display:none;"></label>
                                </div>
                               </div>         
                            </div>
                           <!-- /.card-body -->
                           <div class="card-footer">
                               <button type="submit" class="btn btn-primary">Submit</button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
           <!-- /.row -->
       </div><!-- /.container-fluid -->
   </section>

</div>

<script src="<?php echo CUSTOM_JS; ?>email_setting.js"></script>

<script>

</script>