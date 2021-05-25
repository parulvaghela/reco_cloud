  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1 class="m-0">Dashboard</h1>

          </div><!-- /.col -->

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user/dashboard">Home</a></li>

              <li class="breadcrumb-item active">Dashboard</li>

            </ol>

          </div><!-- /.col -->

        </div><!-- /.row -->

      </div><!-- /.container-fluid -->

    </div>

    <!-- /.content-header -->



    <!-- Main content -->

    <section class="content">
    <?php
        $flash = $this->session->flashdata('reg_error');
        if ($flash) {
            echo $flash;
        }
        ?>
      <div class="container-fluid">

            <!-- Small boxes (Stat box) -->

            <div class="row">

                <div class="col-lg-3 col-6">

                    <!-- small box -->

                    <div class="small-box bg-info">

                    <div class="inner">

                        <h3><?php echo isset($total_active)?$total_active:0; ?></h3>

                        <p>Active plan</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-bag"></i>

                    </div>

                    <a href="<?php echo base_url(); ?>user/current-plan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

                <!-- ./col -->

                <div class="col-lg-3 col-6">

                    <!-- small box -->

                    <div class="small-box bg-danger">

                    <div class="inner">

                        <h3><?php echo isset($total_expire)?$total_expire:0; ?></h3>



                        <p>Expire Plan</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-stats-bars"></i>

                    </div>

                    <a href="<?php echo base_url(); ?>user/current-plan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

                <!-- ./col -->

            </div>

            <!-- /.row -->

        </div>

        <!-- /.row (main row) -->

      </div><!-- /.container-fluid -->

    </section>

    <!-- /.content -->

  </div>

