<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h1 class="card-title mb-4">
                    <?= $title ?>
                    <a class="btn btn-warning btn-xs btn-raised float-right" href="<?= $url_back ?>"> <i class="k-icon k-i-arrow-chevron-left"></i>Kembali</a>
                </h1>
                <hr />
                <?= $form?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>