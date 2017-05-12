<form class="upload" action="javascript:void(0);" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col s8">
            <div class="file-field input-field">
                <input type="file" multiple>
                <div class="file-path-wrapper">
                    <input class="file-path" type="text" placeholder="Upload one or more files">
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="input-field center">
                <input class="btn" type="submit" value="Upload"/>
            </div>
        </div>
        <div class="clearfix padd-sm"></div>
        <div class="status"></div>
    </div>
</form>
<script src="<?= site_url('assets/js/views/file/uploader.js'); ?>"></script>