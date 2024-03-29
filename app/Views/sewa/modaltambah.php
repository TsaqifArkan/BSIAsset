<!-- Modal -->
<div class="modal fade" id="modalTambahSewa" tabindex="-1" aria-labelledby="judulModalSewa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModalSewa">Tambah Sewa Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('sewa/tambah', ['class' => 'formSewa']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                    <div class="invalid-feedback errorNama"></div>
                </div>
                <div class="form-group">
                    <label for="tglSewa">Tanggal Sewa</label>
                    <input type="date" class="form-control" id="tglSewa" name="tglSewa">
                    <div class="invalid-feedback errorTgl"></div>
                </div>
                <div class="form-group">
                    <label for="periodeSewa">Periode Sewa</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="periodeSewa" name="periodeSewa">
                        <div class="input-group-append">
                            <span class="input-group-text">bulan</span>
                        </div>
                        <div class="invalid-feedback errorPeriode"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="hargaSewa">Harga Sewa</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control" id="hargaSewa" name="hargaSewa">
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                        <div class="invalid-feedback errorHrg"></div>
                    </div>
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
    // Konfigurasi Modal Tambah Sewa di modaltambah.php
    $(document).ready(function() {
        $('#modalTambahSewa').on('shown.bs.modal', function() {
            $('#nama').focus();
        })
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
                        })
                        $('#modalTambahSewa').modal('hide');
                        // simulates similar behavior as an HTTP redirect
                        // window.location.replace("http://localhost:8080/sewa");
                        tableSewa();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    var tab = window.open('about:blank', '_blank');
                    tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                    tab.document.close(); // to finish loading the page
                }
            });
            return false;
        });
    });
</script>