<!-- Modal -->
<div class="modal fade mt-5" id="modalTambah" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModal">Tambah Aset Data</h5>
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
                    <div class="invalid-feedback errorNama">

                    </div>
                </div>
                <div class="form-group">
                    <label for="tglPerolehan">Tanggal Perolehan</label>
                    <input type="date" class="form-control" id="tglPerolehan" name="tglPerolehan">
                    <div class="invalid-feedback errorTgl">

                    </div>
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
                    </div>
                </div>
                <div class="form-group">
                    <label for="usiaTeknis">Usia Teknis (bulan)</label>
                    <input type="number" class="form-control" id="usiaTeknis" name="usiaTeknis">
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
                            $('.errorNama').html('');
                        }

                        if (response.error.tglPerolehan) {
                            $('#tglPerolehan').addClass('is-invalid');
                            $('.errorTgl').html(response.error.tglPerolehan);
                        } else {
                            $('#tglPerolehan').removeClass('is-invalid');
                            $('.errorTgl').html('');
                        }
                    } else {
                        $('#modalTambah').modal('hide');
                        // simulates similar behavior as an HTTP redirect
                        window.location.replace("http://localhost:8080/aset");
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