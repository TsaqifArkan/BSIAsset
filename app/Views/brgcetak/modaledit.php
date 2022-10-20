<!-- Modal -->
<div class="modal fade" id="modalEditBrgCtk" tabindex="-1" aria-labelledby="judulModalBrgCtk" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModalBrgCtk">Edit Data Barang Cetak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('brgcetak/edit', ['class' => 'formBrgCtk']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($nama); ?>">
                    <div class="invalid-feedback errorNama"></div>
                </div>
                <div class="form-group">
                    <label for="kode">Kode Barang</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="<?= esc($kode); ?>">
                    <div class="invalid-feedback errorKode"></div>
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="text" class="form-control" id="stok" name="stok" value="<?= esc($stok); ?>" disabled>
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
    // Konfigurasi Modal Edit Barang Cetak di modaledit.php
    $(document).ready(function() {
        $('.formBrgCtk').submit(function(e) {
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

                        if (response.error.kode) {
                            $('#kode').addClass('is-invalid');
                            $('.errorKode').html(response.error.kode);
                        } else {
                            $('#kode').removeClass('is-invalid');
                            $('#kode').addClass('is-valid');
                            $('.errorKode').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData,
                        })
                        $('#modalEditBrgCtk').modal('hide');
                        // simulates similar behavior as an HTTP redirect
                        // window.location.replace("http://localhost:8080/aset");
                        tableBrgCetak();
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