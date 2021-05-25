 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <section class="content">
        <?php
            $flash = $this->session->flashdata('message');
            if ($flash) {
                echo $flash;
            }
        ?>
        <form action="<?php echo base_url(); ?>user/changepassword" method="POST" id="change_password" name="change_password">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Manage Password</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                          <label id="cu_pass">Current Password</label>
                            <div class="input-group mb-3" id="c_pass">   
                                <input type="password" name="current_password" id="current_password" class="form-control">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span toggle="#password-field" data-id="current_password" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                  </div>
                                </div>                                
                            </div>
                            <span class="errors"><?php echo form_error('current_password'); ?></span>
                            <label id="current_password-error" class="errors" for="current_password" style="display:none;"></label>
                            <br>
                            <label>New Password</label>
                            <div class="input-group mb-3">                                
                                <input type="password" name="new_password" id="new_password" class="form-control">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span toggle="#password-field" data-id="new_password" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                  </div>
                                </div>
                            </div>
                            <span class="errors"><?php echo form_error('new_password'); ?></span>
                            <label id="new_password-error" class="errors" for="new_password" style="display:none"></label>
                            <br/>
                            <label>Confirm Password</label>
                            <div class="input-group mb-3">                                
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span toggle="#password-field" data-id="confirm_password" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                  </div>
                                </div>
                            </div>
                            <span class="errors"><?php echo form_error('confirm_password'); ?></span>
                            <label id="confirm_password-error" class="errors" for="confirm_password" style="display:none"></label>
                            <div class="btn-block">
                                <div class="row">
                                    <div class="col-8">
                                        <button type="submit" name="submit" class="btn btn-primary form-control">Change Password</button>
                                    </div>
                                    <div class="col-4">
                                        <a href="<?php echo base_url(); ?>user/dashboard" class="btn btn-dark form-control">Back</a>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </form>    
    </section>
</div>
<script>

active_deactive_block();

function active_deactive_block() {

	if($('input[name="register_type"]').val() == 1){

		$('input[name="current_password"]').attr('readonly', false);

	}

	else {
        $('#cu_pass').hide();
        $('#c_pass').hide();

		$('input[name="current_password"]').attr('readonly', true);
   }

}

</script>
<script src="<?php echo CUSTOM_CLIENT_JS; ?>change_password.js"></script>