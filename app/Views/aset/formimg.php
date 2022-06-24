<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php //dd($aset);
//dd($id);
?>

<div class="container" style="max-width: 512px;">
    <div class="row">
        <div class="col">
            <div class="card mb-3 border-bottom-primary shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Foto Aset</h6>
                </div>
                <div class="card-body">

                    <form action="/aset/editImg" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <!-- menyimpan nama file gambar_aset lama -->
                        <input type="hidden" name="oldAssetImage" value="<?= esc($aset['gambar_aset']); ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id; ?>">

                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col">
                                    <img src="/img/<?= esc($aset['gambar_aset']); ?>" alt="" class="img-thumbnail d-block m-auto rounded img-preview" style="height:200px; width:200px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="uploadPict">Foto Aset</label>
                                    <div class="custom-file">
                                        <!-- validation disini -->
                                        <input type="file" class="custom-file-input <?= ($validation->hasError('asetPict')) ? 'is-invalid' : ''; ?>" id="uploadPict" name="asetPict" onchange="previewImg()">
                                        <label class="custom-file-label" for="uploadPict">Choose a file..</label>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('asetPict'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group text-center">
                            <a href="<?= base_url('aset'); ?>" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary btnSimpan">Update Data</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>