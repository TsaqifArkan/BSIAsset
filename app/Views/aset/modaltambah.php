<!-- Modal -->
<div class="modal fade" id="modalTambahAset" tabindex="-1" aria-labelledby="judulModalAset" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModalAset">Tambah Aset Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('aset/tambah', ['class' => 'formAset']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                    <div class="invalid-feedback errorNama"></div>
                </div>
                <div class="form-group">
                    <label for="tglPerolehan">Tanggal Perolehan</label>
                    <input type="date" class="form-control" id="tglPerolehan" name="tglPerolehan">
                    <div class="invalid-feedback errorTgl"></div>
                </div>
                <div class="form-group">
                    <label for="hargaPerolehan">Harga Perolehan</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control" id="hargaPerolehan" name="hargaPerolehan">
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                        <div class="invalid-feedback errorHrg"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="usiaTeknis">Usia Teknis</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="usiaTeknis" name="usiaTeknis">
                        <div class="input-group-append">
                            <span class="input-group-text">bulan</span>
                        </div>
                        <div class="invalid-feedback errorUsia"></div>
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
    // Konfigurasi Modal Tambah Aset di modaltambah.php
    $(document).ready(function() {
        $('#modalTambahAset').on('shown.bs.modal', function() {
            $('#nama').focus();
        })
        $('.formAset').submit(function(e) {
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

                        if (response.error.tglPerolehan) {
                            $('#tglPerolehan').addClass('is-invalid');
                            $('.errorTgl').html(response.error.tglPerolehan);
                        } else {
                            $('#tglPerolehan').removeClass('is-invalid');
                            $('#tglPerolehan').addClass('is-valid');
                            $('.errorTgl').html('');
                        }

                        if (response.error.hargaPerolehan) {
                            $('#hargaPerolehan').addClass('is-invalid');
                            $('.errorHrg').html(response.error.hargaPerolehan);
                        } else {
                            $('#hargaPerolehan').removeClass('is-invalid');
                            $('#hargaPerolehan').addClass('is-valid');
                            $('.errorHrg').html('');
                        }

                        if (response.error.usiaTeknis) {
                            $('#usiaTeknis').addClass('is-invalid');
                            $('.errorUsia').html(response.error.usiaTeknis);
                        } else {
                            $('#usiaTeknis').removeClass('is-invalid');
                            $('#usiaTeknis').addClass('is-valid');
                            $('.errorUsia').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData,
                        })
                        $('#modalTambahAset').modal('hide');
                        // simulates similar behavior as an HTTP redirect
                        // window.location.replace("http://localhost:8080/aset");
                        tableAset();
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