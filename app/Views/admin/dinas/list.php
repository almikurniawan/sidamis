<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h1 class="card-title">
                    <?= $title ?>
                </h1>
                <hr/>
                <?= $search.$grid ?>
            </div>
        </div>
    </div>
</div>
<script>
    function deleteDinas(id) {
        kendo.confirm("Yakin ingin delete data ini?").then(function() {
            $.post("<?= base_url('admin/layanan/delete') ?>", {
                id: id
            }, function(result) {
                if (result.status) {
                    kendo.alert(result.message);
                    gridReload();
                } else {
                    kendo.alert(result.message);
                }
            }, 'json');
        }, function() {});
    }
    function approve(layanan_id){
      alert(layanan_id)
    }
    function lihatDinas(layanan_id){
      var win = window.open('<?= base_url()?>/', '_blank');
      win.focus();
    }
</script>
<?= $this->endSection() ?>
