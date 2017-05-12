<div class="container">
    <h3>Blog Administration</h3>

    <div class="row">
        <?php foreach ($this->tumblr->getUserInfo()->user->blogs as $blog): ?>
            <?php if ($blog->admin): ?>
                <form name="blog-<?= $blog->name; ?>">
                    <input type="hidden" name="name" value="<?= $blog->name; ?>"/>

                    <div class="col s12 m4">
                        <div class="card white darken-1">
                            <div class="card-image">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <img class="activator" src="<?= $this->tumblr->getBlogAvatar($blog->name); ?>"/>
                                </div>
                            </div>
                            <div class="card-content black-text">
                            <span class="activator card-title black-text">
                                <a href="<?= $blog->url; ?>">
                                    <?= $blog->name; ?>
                                </a>
                                <i class="material-icons right">more_vert</i>
                            </span>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4">
                                    Settings
                                    <i class="material-icons right">close</i>
                                </span>

                                <div class="padd-sm"></div>
                                <label>Blog Genre</label>

                                <div class="input-field no-margin">
                                    <select name="category" multiple class="black-text">
                                        <option value="" disabled selected>Choose your option</option>
                                        <?php foreach ($categories->result() as $category): ?>
                                            <option value="<?= $category->id; ?>"><?= $category->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <table class="responsive-table no-padd">
                                    <tr>
                                        <td>
                                            <label>Enable Ads</label>
                                        </td>
                                        <td>
                                            <div class="switch">
                                                <label>
                                                    <input name="enable" type="checkbox">
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Ad Frequency<br/>(per day)</label>
                                        </td>
                                        <td>
                                            <p class="range-field no-margin">
                                                <input type="range" id="frequency" name="frequency" min="0" max="24"/>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                <div class="padd-sm"></div>
                                <div class="center-align">
                                    <a class="save btn waves-effect waves-ripple">Save</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>