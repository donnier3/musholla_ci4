<?php foreach ($reply as $r) : ?>
    <li class="comment-children">
        <div class="comment-avatar">
            <img src="/assets/img/default.jpg" alt="">
        </div>
        <div class="comment-details">
            <h4 class="comment-author"><?= ucwords($r['nama']) ?></h4>
            <span><?= date('d M Y - H:i', strtotime($r['created_at'])) ?></span>
            <p class="comment-description">
                <?= ucwords($r['isi_reply']) ?>
            </p>
        </div>
    </li>
<?php endforeach ?>