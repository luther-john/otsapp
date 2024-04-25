<?= $this->extend('template/admin_template') ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $totaloffices ?></h3>
                        <p>Total Offices</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $totaltickets ?></h3>
                        <p>Total Tickets</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $totalopen ?></h3>
                        <p>Total Open Tickets</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-door-open"></i>
                    </div>

                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $totalclosed ?></h3>
                        <p>Total Closed Tickets</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-door-closed"></i>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('javascripts') ?>
<script>

</script>
<?= $this->endSection() ?>