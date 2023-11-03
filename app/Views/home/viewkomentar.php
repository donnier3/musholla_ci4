<div class="title-box-d">
    <h3 class="title-d">Komentar (<?= $hitung ?>)</h3>
</div>
<?php if ($hitung == 0) { ?>
    <h4 class="mt-3 mb-5 text-center">{Jadilah Yang Pertama Memberikan Komentar}</h4>
<?php } ?>
<div class="box-comments">
    <ul class="list-comments">
        <?php foreach ($komentar as $k) : ?>
            <li>
                <div class="d-flex col-lg-12">
                    <div class="comment-avatar justify-content-lg-start">
                        <img src="/assets/img/default.jpg" alt="">
                    </div>
                    <div class="comment-details justify-content-lg-around col-lg-10">
                        <div>
                            <h4 class="comment-author"><?= ucwords($k['nama']) ?></h4>
                            <span><?= date('d M Y - H:i', strtotime($k['created_at'])) ?></span>
                            <p class="comment-description">
                                <?= ucwords($k['komentar']) ?>
                            </p>
                        </div>
                    </div>
                    <div class="justify-content-lg-end align-content-right col-lg-2">
                        <button class="btn btn-sm btn-secondary btnReply" id="<?= $k['id_komentar'] ?>"><i class="fa fa-reply"></i> Reply</button>
                    </div>
                </div>
            </li>
            <?php foreach ($reply as $r) :
                if ($r['id_komentar'] == $k['id_komentar']) {
            ?>
                    <li class="comment-children">
                        <div class="d-flex col-lg-12">
                            <div class="comment-avatar justify-content-lg-start">
                                <img src="/assets/img/default.jpg" alt="">
                            </div>
                            <div class="comment-details justify-content-lg-around col-lg-10">
                                <div>
                                    <h4 class="comment-author"><?= ucwords($r['nama']) ?></h4>
                                    <span><?= date('d M Y - H:i', strtotime($r['created_at'])) ?></span>
                                    <p class="comment-description">
                                        <?= ucwords($r['komentar']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
            <?php }
            endforeach ?>
        <?php endforeach ?>
    </ul>
</div>

<script>
    function getreply() {
        let id_komentar = $('#id_komentar').val();
        $.ajax({
            url: "/home/getreply",
            data: {
                id_komentar: id_komentar
            },
            dataType: "json",
            success: function(response) {
                $('.view-reply').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            iconColor: '#ffffff',
            background: '#2eca6a',
            customClass: {
                title: 'text-white',
            },
            timer: 3000
        });

        // getreply();

        // $('.btnSave').on('click', function(e) {
        $('.frmreply').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnSave').attr('disabled', true);
                    $('.btnSave').html('<i class="fas fa-spin fa-spinner"></i> &nbsp; Sending..');
                },
                complete: function() {
                    $('.btnSave').attr('disabled', false);
                    $('.btnSave').html('<i class="fas fa-paper-plane"></i> &nbsp; Send Message');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errNama').html(response.error.nama);
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errEmail').html(response.error.email);
                        }
                        if (response.error.komentar) {
                            $('#komentar').addClass('is-invalid');
                            $('.errKom').html(response.error.komentar);
                        } else {
                            $('#komentar').removeClass('is-invalid');
                            $('.errKom').html(response.error.komentar);
                        }
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: response.sukses
                        });
                        $(".frmreply")[0].reset();
                        getkomentar();
                        // getreply();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>