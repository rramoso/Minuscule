<div class="container container-md box box-cut">
    <h2>Create an Advertisement</h2>
    <div class="row">
        <form name="create" action="javascript:create()">
            <div class="col s12">
                <div class="input-field">
                    <label for="input-title">Title</label>
                    <input id="input-title" type="text" name="title" required/>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <input id="input-date" name="publish" type="date" class="datepicker" required/>
                    <label for="input-date">Publish On</label>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <input id="input-time" name="publish_time" type="text" class="time" required/>
                    <label for="input-time">Publish At</label>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field">
                    <label for="input-duration">Duration (in hours)</label>
                    <input id="input-duration" class="form-control" type="number" name="duration" value="24"/>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col s12">
                <div class="input-field">
                    <label for="input-description">Description</label>
                    <input id="input-description" type="text" name="description" required/>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col s12">
                <div class="input-field">
                    <select name="categories[]" multiple required>
                        <option value="" disabled selected>Choose your option</option>
                        <?php foreach ($categories->result() as $category): ?>
                            <option value="<?= $category->id; ?>"><?= $category->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Categories</label>
                </div>
            </div>
            <div class="clearfix padd-sm"></div>
            <div class="col s12">
                <a class="btn right" href="javascript:void(0);" onclick="$('#modal').openModal()">Upload Images</a>
            </div>
            <div class="col s12">
                <div class="input-field">
                    <textarea name="content" class="editor" required></textarea>
                </div>
            </div>
            <div class="padd-md clearfix"></div>
            <div class="row">
                <div class="col s6 center-align">
                    <input class="btn materialize-red waves-ripple waves-effect" type="submit" value="Create">
                </div>
                <div class="col s6 center-align">
                    <a class="btn waves-ripple waves-effect" href="<?= site_url('manage'); ?>">Cancel</a>
                </div>
            </div>
        </form>
        <div id="modal" class="modal modal-right">
            <div class="modal-content">
                <div class="container">
                    <p>You may upload your images here, once uploaded, click and drag them into the editor below. You
                        can side them in the editor by double clicking to bring up the properties panel.</p>
                    <?= $uploader; ?>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">close</a>
            </div>
        </div>
    </div>

</div>
<script src="<?= site_url('assets/js/views/manage/create.js'); ?>"></script>