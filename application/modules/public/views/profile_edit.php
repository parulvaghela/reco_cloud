<style>
     .avatar-preview {
        width: 100px;
        height: 100px;
        position: relative;
        /* border-radius: 100%; */
        /* border: 6px solid #F8F8F8; */
        border: 1px solid #04040445;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);

    }
    .avatar-preview div {
        width: 100%;
        height: 100%;
        /* border-radius: 100%; */
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        border: 0px solid #040404b8;
    }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Manage Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manage Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <?php
            $flash = $this->session->flashdata('profile_error');
            if ($flash) {
                echo $flash;
            }
        ?>
        <?php if($user_data != 0){ ?>
        <form action="<?php echo base_url(); ?>user/profile-edit" method="POST" id="manage_profile" name="manage_profile" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Manage Profile</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" value="<?php echo isset($user_data['first_name'])?$user_data['first_name']:''; ?>" class="form-control" onkeypress="return isalpha(event);">                            
                                <span class="errors"> <?php echo form_error('first_name'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="<?php echo isset($user_data['last_name'])?$user_data['last_name']:''; ?>" class="form-control" onkeypress="return isalpha(event);">
                                <span class="errors"> <?php echo form_error('last_name'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="text" name="email" id="email" value="<?php echo isset($user_data['email_id'])?$user_data['email_id']:''; ?>" class="form-control">
                                <span class="errors"> <?php echo form_error('email'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="phone_num">Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo isset($user_data['phone_no'])?$user_data['phone_no']:''; ?>" onkeypress="return isNumber(event);" onInput="checkLength()">
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="hidden" name="old_image" id="old_image" value="<?php echo $user_data['profile_pic']; ?>"> 
                                <input type="file" name="s_image" id="s_image_1_1" onchange="readURL(this, '_1_1')" accept="image/*" class="form-control">
                                <div class="uploadpreview"></div>						
                                <div class="avatar-preview">
                                <?php
                                $profile_pic = ""; 
                                if($user_data['register_type'] == 1)
                                {
                                    $profile_pic = BASE_URL.'uploads/profile/'.$user_data['profile_pic'];
                                }else{
                                    $profile_pic = $user_data['profile_pic'];
                                } ?>
                                    <?php
                                        // Variable to check
                                        $url = $profile_pic;
                                        // Validate url
                                        if (filter_var($url, FILTER_VALIDATE_URL)) { ?>
                                             <div id="imagePreview_1_1" style="background-image: url(<?php echo $profile_pic; ?>);"></div>
                                        <?php } else { ?>
                                            <div id="imagePreview_1_1" style="background-image: url(<?php echo base_url().'uploads/profile/'.$profile_pic; ?>);"></div>
                                       <?php }
                                        ?>
                                </div>
                            </div>
                            <div class="btn-block">
                                <div class="row">
                                    <div class="col-8">
                                        <button type="submit" name="edit_profile" class="btn btn-primary form-control">Submit</button>
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
        <?php } ?>
    </section>
</div>
<script src="<?php echo CUSTOM_CLIENT_JS; ?>profile_edit.js"></script>