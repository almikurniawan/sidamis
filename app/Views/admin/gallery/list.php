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
    function deleteGallery(id) {
        kendo.confirm("Yakin ingin delete data ini?").then(function() {
            $.post("<?= base_url('admin/gallery/delete') ?>", {
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
    function approve(gallery_id){
      alert(gallery_id)
    }
    function lihatGallery(gallery_id){
      var win = window.open('<?= base_url()?>/gallery/detail/'+gallery_id, '_blank');
      win.focus();
    }
</script>
<?= $this->endSection() ?>
