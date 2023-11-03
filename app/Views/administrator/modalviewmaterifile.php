<!-- Modal -->
<div class="modal fade" id="modal-view" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="height:100%;">
        <div class="modal-content" style="min-height: 100%;">
            <div class="modal-header bg-primary-gradient">
                <h5 class="modal-title text-white" id="staticBackdropLabel">File Materi</h5>
            </div>
            <div class="modal-body">
                <iframe src="/assets/materi/<?= $file_materi ?>" frameborder="0" width="100%" height="100%"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i> &nbsp; Close</button>
            </div>
        </div>
    </div>
</div>