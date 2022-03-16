<!-- Modal -->
<div class="modal fade mt-5" id="modalEditSewa" tabindex="-1" aria-labelledby="judulModalSewa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModalSewa">Edit Sewa Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('sewa/edit', ['class' => 'formSewa']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama; ?>">
                    <div class="invalid-feedback errorNama"></div>
                </div>
                <div class="form-group">
                    <label for="tglSewa">Tanggal Sewa</label>
                    <input type="date" class="form-control" id="tglSewa" name="tglSewa" value="<?= $tglSewa; ?>">
                    <div class="invalid-feedback errorTgl"></div>
                </div>
                <div class="form-group">
                    <label for="periodeSewa">Periode Sewa</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="periodeSewa" name="periodeSewa" value="<?= $periodeSewa; ?>">
                        <div class="input-group-append">
                            <span class="input-group-text">bulan</span>
                        </div>
                    </div>
                    <div class="invalid-feedback errorPeriode"></div>
                </div>
                <div class="form-group">
                    <label for="hargaSewa">Harga Sewa</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control" id="hargaSewa" name="hargaSewa" value="<?= $hargaSewa; ?>">
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                        <div class="invalid-feedback errorHrg"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sisaWaktu">Sisa Waktu</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="sisaWaktu" name="sisaWaktu" value="<?= $sisaWaktu; ?>" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">hari</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jatuhTempo">Jatuh Tempo</label>
                    <input type="date" class="form-control" id="jatuhTempo" name="jatuhTempo" value="<?= $jatuhTempo; ?>" disabled>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSimpan">Update Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    // Konfigurasi Modal Edit Sewa di modaledit.php
    $(document).ready(function() {
        $('.formSewa').submit(function(e) {
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
                    $('.btnSimpan').html('Update Data')
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

                        if (response.error.tglSewa) {
                            $('#tglSewa').addClass('is-invalid');
                            $('.errorTgl').html(response.error.tglSewa);
                        } else {
                            $('#tglSewa').removeClass('is-invalid');
                            $('#tglSewa').addClass('is-valid');
                            $('.errorTgl').html('');
                        }

                        if (response.error.periodeSewa) {
                            $('#periodeSewa').addClass('is-invalid');
                            $('.errorPeriode').html(response.error.periodeSewa);
                        } else {
                            $('#periodeSewa').removeClass('is-invalid');
                            $('#periodeSewa').addClass('is-valid');
                            $('.errorPeriode').html('');
                        }

                        if (response.error.hargaSewa) {
                            $('#hargaSewa').addClass('is-invalid');
                            $('.errorHrg').html(response.error.hargaSewa);
                        } else {
                            $('#hargaSewa').removeClass('is-invalid');
                            $('#hargaSewa').addClass('is-valid');
                            $('.errorHrg').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData,
                        });
                        $('#modalEditSewa').modal('hide');
                        // simulates similar behavior as an HTTP redirect
                        // window.location.replace("http://localhost:8080/sewa");
                        tableSewa();
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