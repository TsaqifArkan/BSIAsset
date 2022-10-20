<!-- Modal -->
<div class="modal fade" id="modalTambahTrans" tabindex="-1" aria-labelledby="judulModalTrans" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModalTrans">Tambah Transaksi Barang Cetakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('transaksi/tambah', ['class' => 'formTrans']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="id" value="<?= esc($brgcetakdata['id']); ?>">
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($brgcetakdata['nama']); ?>" disabled>
                    <!-- <div class="invalid-feedback errorNama"></div> -->
                </div>
                <div class="form-group">
                    <label for="kode">Kode Barang</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="<?= esc($brgcetakdata['kode']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="jmlTrans">Jumlah</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="jmlTrans" name="jmlTrans" min="1" placeholder="(minimal 1)">
                        <div class="input-group-append">
                            <span class="input-group-text">(pcs)</span>
                        </div>
                        <div class="invalid-feedback errorJmlTrans"></div>
                    </div>
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
                    <label for="jenisMutasi">Jenis Mutasi</label>
                    <div class="form-row justify-content-around">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="dkOption" id="debit" value="D">
                            <label class="form-check-label" for="debit">
                                Debit
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="dkOption" id="kredit" value="K">
                            <label class="form-check-label" for="kredit">
                                Kredit
                            </label>
                        </div>
                    </div>
                    <div class="text-danger errorJenisMutasi" style="font-size: 83%;"></div>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" cols="10" rows="3" placeholder="(opsional)"></textarea>
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
    // Konfigurasi Modal Tambah Data Transaksi di modaltambah.php
    $(document).ready(function() {
        $('#modalTambahTrans').on('shown.bs.modal', function() {
            $('#jmlTrans').focus();
        })
        $('.formTrans').submit(function(e) {
            e.preventDefault();
            // console.log(this);
            // console.log($(this).serialize());
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
                        // if (response.error.nama) {
                        //     $('#nama').addClass('is-invalid');
                        //     $('.errorNama').html(response.error.nama);
                        // } else {
                        //     $('#nama').removeClass('is-invalid');
                        //     $('#nama').addClass('is-valid');
                        //     $('.errorNama').html('');
                        // }

                        if (response.error.jmlTrans) {
                            $('#jmlTrans').addClass('is-invalid');
                            $('.errorJmlTrans').html(response.error.jmlTrans);
                        } else {
                            $('#jmlTrans').removeClass('is-invalid');
                            $('#jmlTrans').addClass('is-valid');
                            $('.errorJmlTrans').html('');
                        }

                        if (response.error.hargaSatuan) {
                            $('#hargaSatuan').addClass('is-invalid');
                            $('.errorHrg').html(response.error.hargaSatuan);
                        } else {
                            $('#hargaSatuan').removeClass('is-invalid');
                            $('#hargaSatuan').addClass('is-valid');
                            $('.errorHrg').html('');
                        }

                        if (response.error.jenisMutasi) {
                            $('.errorJenisMutasi').html(response.error.jenisMutasi);
                        } else {
                            $('.errorJenisMutasi').html('');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData,
                        });
                        $('#modalTambahTrans').modal('hide');
                        // simulates similar behavior as an HTTP redirect
                        // window.location.replace("http://localhost:8080/sewa");
                        tableTransaksi(response.idBrgCtk);
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