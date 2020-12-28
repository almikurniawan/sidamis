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
    function deleteTentang(id) {
        kendo.confirm("Yakin ingin delete data ini?").then(function() {
            $.post("<?= base_url('admin/tentang/delete') ?>", {
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
    function approve(tentang_id){
      alert(tentang_id)
    }
    function lihatTentang(parameter){
      res = parameter.split("/");
      var tentang_tipe=res[1];
      var win = window.open('<?= base_url()?>/tentang/index/'+tentang_tipe, '_blank');
      win.focus();
    }
</script>
<?= $this->endSection() ?>
