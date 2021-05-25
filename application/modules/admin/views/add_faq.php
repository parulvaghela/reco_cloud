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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Faq</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form id="faq_validate" name="faq_validate" action="<?php echo base_url() ?>admin/add_faq" method="post" novalidate="novalidate">
                                <?php
                                    $flash = $this->session->flashdata('old_password_error');
                                    if (isset($flash)) {
                                        echo $flash;
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="old_pass">Question</label>
                                    <input type="text" class="form-control input-default" id="question" name="question" placeholder="Question" value="<?php echo set_value('question');?>">
                                    <?php echo form_error('question')?>
                                </div>
                                <textarea class="summernote" name="ansfaq" id="ansfaq"></textarea>
                                    <?php echo form_error('ansfaq')?>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ADMIN_CUSTOM_JS; ?>add_faq.js"></script>