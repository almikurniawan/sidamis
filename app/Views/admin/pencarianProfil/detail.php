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
                <div id="tabstrip">
                    <ul>
                        <li class="k-state-active">
                            Profile Ruta
                        </li>
                        <li>
                            Anggota Ruta
                        </li>
                    </ul>
                    <div>
                        <?= $form ?>
                    </div>
                    <div>
                        <?= $grid_anggota ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#tabstrip").kendoTabStrip({
            animation: {
                open: {
                    effects: "fadeIn"
                }
            }
        });
    });

    function detailArt(art_id){
        showForm(1000, 700, '_newpop', '<?= base_url("admin/pencarianProfilRuta/detailArt")?>/'+art_id);
    }
</script>
<?= $this->endSection() ?>