<!-- Modal -->
<div class="modal fade mt-5" id="modalEditUser" tabindex="-1" aria-labelledby="judulModalUser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModalUser">Edit Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('user/edit', ['class' => 'formUser']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <!-- menyimpan nama file user_image lama -->
                <input type="hidden" name="oldUserImage" value="<?= esc($profilePict); ?>">

                <div class="form-group">
                    <div class="row mb-3">
                        <div class="col">
                            <img src="/img/<?= esc($profilePict); ?>" alt="" class="img-thumbnail d-block m-auto rounded-circle img-preview" style="height:200px; width:200px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="profilePict">Profil Picture</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="profilePict" name="profilePict" onchange="previewImg()">
                                <label class="custom-file-label" for="profilePict"><?= esc($profilePict); ?></label>
                                <div class="invalid-feedback errorProfilePict"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= esc($username); ?>">
                    <div class="invalid-feedback errorUsername"></div>
                </div>
                <div class="form-group">
                    <label for="fullname">Fullname</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?= esc($fullname); ?>" placeholder="(opsional)">
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
    // Konfigurasi Modal Edit User di modaledit.php
    $(document).ready(function() {
        $('.formUser').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false, // Important!
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
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorUsername').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('#username').addClass('is-valid');
                            $('.errorUsername').html('');
                        }

                        if (response.error.profilePict) {
                            $('#profilePict').addClass('is-invalid');
                            $('.errorProfilePict').html(response.error.profilePict);
                        } else {
                            $('#profilePict').removeClass('is-invalid');
                            $('#profilePict').addClass('is-valid');
                            $('.errorProfilePict').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData,
                            willClose: function() {
                                $('#modalEditUser').modal('hide');
                                // simulates similar behavior as an HTTP redirect
                                window.location.replace("http://localhost:8080/user");
                            }
                        });
                        // tableSewa();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // cara dd() di Ajax
                    let w = window.open('about:blank');
                    w.document.open();
                    w.document.write(xhr.responseText);
                    w.document.close();
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>