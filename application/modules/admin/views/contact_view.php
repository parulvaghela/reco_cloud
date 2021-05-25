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
                        <h4 class="card-title">Contact List</h4>
                    </div>
                    <div class="card-body">
                        <div>
                         <div class="row">
                            <div class="col-xl-6 col-lg-16">
                             <select class="form-control" name="contact_status" id="contact_status">
                                 <option value="">All</option>
                                 <option value="1">Active</option>
                                 <option value="0">Deactive</option>
                             </select>
                         </div>   
                         </div>
                        <table id="contact_list_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo ADMIN_CUSTOM_JS; ?>contact_list.js"></script>