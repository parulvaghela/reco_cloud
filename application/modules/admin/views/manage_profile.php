<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">edit profile</li>
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
                    $flash = $this->session->flashdata('reg_error');
                    if ($flash) {
                        echo $flash;
                    }
                    $success = $this->session->flashdata('edit_success');
                    if (isset($success)) {
                        echo $success;
                    }
                    ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Profile</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form method="post" action="<?php echo base_url() ?>manage_profile" name="edit_admin_profile" enctype="multipart/form-data" id="edit_admin_profile">
                            <div class="card-body">
                                <div class="pkg_edit">
                                    <div class="form-group">
                                        <label for="efirst_name">First Name</label>
                                        <input type="text" class="form-control" id="efirst_name"  name="efirst_name" placeholder="Enter First Name" onkeypress="return isalpha(event);"  value="<?php
                                        if (isset($edit_data['first_name'])) {
                                            echo $edit_data['first_name'];
                                        }
                                        ?>">

                                        <label id="efirst_name-error" class="errors" for="efirst_name" style="display: none;"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="elast_name">Last Name</label>
                                        <input type="text" class="form-control" id="elast_name"  name="elast_name" placeholder="Enter last Name" onkeypress="return isalpha(event);" value="<?php
                                        if (isset($edit_data['last_name'])) {
                                            echo $edit_data['last_name'];
                                        }
                                        ?>">
                                        <label id="elast_name-error" class="errors" for="elast_name" style="display: none;"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_email">Email address</label>
                                        <input type="email" class="form-control" name="edit_email" id="edit_email" placeholder="Enter email" value="<?php
                                        if (isset($edit_data['email_id'])) {
                                            echo $edit_data['email_id'];
                                        }
                                        ?>">
                                        <span class="errors"> <?php
                                            if (form_error('edit_email')) {
                                                echo form_error('edit_email');
                                            }
                                            ?></span>
                                        <label id="edit_email-error" class="errors" for="edit_email" style="display: none;"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="ephone">Phone Number</label>
                                        <input type="text" class="form-control" name="ephone" id="ephone" placeholder="Phone Number" onkeypress="return isNumber(event);" onInput="checkLength()" value="<?php
                                        if (isset($edit_data['phone_no'])) {
                                            echo $edit_data['phone_no'];
                                        }
                                        ?>">
                                        <label id="ephone-error" class="errors" for="ephone" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <label for="edit_profile_pic">Profile Pic</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="hidden" name="image_hidden" value="<?php
                                                    if (isset($edit_data['profile_pic'])) {
                                                        echo $edit_data['profile_pic'];
                                                    }
                                                    ?>">
                                                    <input type="file" class="custom-file-input" id="edit_profile_pic" name="edit_profile_pic" accept="image/*">
                                                    <label class="custom-file-label" for="edit_profile_pic">Choose file</label>
                                                </div>
                                            </div>
                                            <label id="edit_profile_pic-error" class="errors" for="edit_profile_pic"  style="display: none;"></label>
                                            <?php if($edit_data['profile_pic'] != "") {
                                                ?>
                                                <img id="blah" style="height:100px;width: 200px;" src="<?php echo base_url() ?>uploads/profile/<?php echo $edit_data['profile_pic'] ?>" alt="your image" style="" value=""/>
                                            <?php }?>
                                        </div>
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
    <script src="<?php echo CUSTOM_JS; ?>manage_profile.js"></script>
<script>

</script>