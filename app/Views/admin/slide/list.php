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
    function deleteSlide(id) {
        kendo.confirm("Yakin ingin delete data ini?").then(function() {
            $.post("<?= base_url('admin/slide/delete') ?>", {
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
    function approve(slide_id){
      alert(slide_id)
    }
    function lihatSlide(slide_id){
      var win = window.open('<?= base_url()?>/', '_blank');
      win.focus();
    }
</script>
<?= $this->endSection() ?>
