<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container" style="max-width: 512px;">
    <div class="row">
        <div class="col">
            <div class="card mb-3 border-bottom-primary shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Upload File Barang Sewa</h6>
                </div>
                <div class="card-body">

                    <form action="/sewa/uploadFile" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <!-- menyimpan nama file gambar_sewa lama -->
                        <input type="hidden" name="oldSewaImage" value="<?= esc($sewa['gambar_sewa']); ?>">
                        <!-- menyimpan nama file file_sewa lama -->
                        <input type="hidden" name="oldSewaPDF" value="<?= esc($sewa['file_sewa']); ?>">

                        <input type="hidden" name="id" id="id" value="<?= $id; ?>">

                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col">
                                    <img src="/img/<?= esc($sewa['gambar_sewa']); ?>" alt="" class="img-thumbnail d-block m-auto rounded img-preview" style="height:200px; width:200px;">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="uploadPict">Foto Barang Sewa</label>
                                    <div class="custom-file">
                                        <!-- validation disini -->
                                        <input type="file" class="custom-file-input <?= ($validation->hasError('sewaPict')) ? 'is-invalid' : ''; ?>" id="uploadPict" name="sewaPict" onchange="previewImg()">
                                        <label class="custom-file-label" for="uploadPict">Choose a file..</label>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('sewaPict'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <label for="uploadPDF">Berkas Perjanjian Sewa</label>
                                    <div class="custom-file">
                                        <!-- validation disini -->
                                        <input type="file" class="custom-file-input <?= ($validation->hasError('sewaPDF')) ? 'is-invalid' : ''; ?>" id="uploadPDF" name="sewaPDF" onchange="previewLabelFile()">
                                        <label class="custom-file-label" for="uploadPDF">Upload a PDF here..</label>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('sewaPDF'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group text-center">
                            <a href="<?= base_url('sewa'); ?>" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary btnSimpan">Update Data</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>