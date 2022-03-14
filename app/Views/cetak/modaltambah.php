<!-- Modal -->
<div class="modal fade mt-5" id="modalTambahCetak" tabindex="-1" aria-labelledby="judulModalCetak" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModalCetak">Tambah Barang Cetak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('cetak/tambah', ['class' => 'formCetak']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                    <div class="invalid-feedback errorNama"></div>
                </div>
                <div class="form-group">
                    <label for="hargaSatuan">Harga Satuan</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control" id="hargaSatuan" name="hargaSatuan">
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                        <div class="invalid-feedback errorHrg"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="keluar">Keluar</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="keluar" name="keluar">
                        <div class="input-group-append">
                            <span class="input-group-text">(pcs)</span>
                        </div>
                        <div class="invalid-feedback errorKeluar"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="masuk">Masuk</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="masuk" name="masuk">
                        <div class="input-group-append">
                            <span class="input-group-text">(pcs)</span>
                        </div>
                        <div class="invalid-feedback errorMasuk"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" cols="10" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSimpan">Tambah Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    // Konfigurasi Modal Tambah Barang Cetak di modaltambah.php
    $(document).ready(function() {
        $('#modalTambahCetak').on('shown.bs.modal', function() {
            $('#nama').focus();
        })
        $('.formCetak').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('.btnSimpan').attr('disable', 'disabled');
                    $('.btnSimpan').html('<i class="fa-solid fa-spin fa-fw fa-spinner"></i>')
                },
                complete: function() {
                    $('.btnSimpan').removeAttr('disable');
                    $('.btnSimpan').html('Tambah Data')
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('#nama').addClass('is-valid');
                            $('.errorNama').html('');
                        }

                        if (response.error.hargaSatuan) {
                            $('#hargaSatuan').addClass('is-invalid');
                            $('.errorHrg').html(response.error.hargaSatuan);
                        } else {
                            $('#hargaSatuan').removeClass('is-invalid');
                            $('#hargaSatuan').addClass('is-valid');
                            $('.errorHrg').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData,
                        });
                        $('#modalTambahCetak').modal('hide');
                        // simulates similar behavior as an HTTP redirect
                        // window.location.replace("http://localhost:8080/sewa");
                        tableCetak();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>