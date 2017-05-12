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
                                <div class="row">
                                    <div class="col s10">
                                        <a href="<?= $blog->url; ?>">
                                            <?= $blog->name; ?>
                                        </a>
                                    </div>
                                    <div class="col s2">
                                        <i class="material-icons right">more_vert</i>
                                    </div>
                                </div>
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
                    <select name="category" class="black-text">
                        <option value="" disabled <?php !$saved ? 'selected' : false; ?>>Choose your option
                        </option>
                        <?php foreach ($categories->result() as $category): ?>
                            <option
                                value="<?= $category->id; ?>" <?= $saved->category_id == $category->id ? 'selected' : false; ?>><?= $category->name; ?></option>
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
                                    <input name="enable"
                                           type="checkbox" <?= $saved->enable_ads == 1 ? 'checked' : false; ?>>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="frequency">Ad Frequency<br/>(per day)</label>
                        </td>
                        <td>
                            <p class="range-field no-margin">
                                <input type="range" class="frequency" name="frequency" min="1" max="12"
                                       value="<?= $saved->frequency ? $saved->frequency : false; ?>"
                                />
                            </p>
                        </td>
                    </tr>
                </table>
                <div class="padd - sm"></div>
                <div class="center - align">
                    <input name="submit" class="save btn waves - effect waves - ripple" type="submit"
                           value="Save"/>
                </div>
            </div>
        </div>
    </div>
</form>