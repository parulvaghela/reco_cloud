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
            <div class="col-xl-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Change Password</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form id="change_password_validate" name="change_password_validate" action="<?php echo base_url() ?>admin/change-password" method="post" novalidate="novalidate">
                                <?php
                                    $flash = $this->session->flashdata('old_password_error');
                                    if (isset($flash)) {
                                        echo $flash;
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="old_pass">Old Password</label>
                                    <input type="password" class="form-control input-default" id="old_pass" name="old_pass" placeholder="Old Password">
                                </div>
                                <div class="form-group">
                                    <label for="new_pass">New Password</label>
                                    <input type="password" class="form-control input-default"  id="new_pass" name="new_pass" placeholder="input-default">
                                </div>
                                <div class="form-group">
                                    <label for="con_pass">Confirm Password</label>  
                                    <input type="password" class="form-control input-default" id="con_pass" name="con_pass" placeholder="input-default">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ADMIN_CUSTOM_JS; ?>change_password.js"></script>