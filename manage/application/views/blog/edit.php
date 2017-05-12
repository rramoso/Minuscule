<div class="container">
    <div class="row">
        <div class="col s8 offset-s2">
            <div class="box box-cut">
                <form name="blog-<?= $blog->name; ?>" method="post" action="<?= site_url('blog/update'); ?>">
                    <input type="hidden" name="id" value="<?= $blog->id; ?>">
                    <div class="row">
                        <div class="col s12 center-align">
                            <h2>
                                <a href="<?= $blog->url; ?>">
                                    <?= $blog->name; ?>
                                </a>
                            </h2>
                        </div>
                    </div>
                    <div class="padd-sm"></div>
                    <div class="row">
                        <div class="col s6">
                            <label>Blog Genre</label>
                            <div class="input-field no-margin">
                                <select name="category" class="black-text">
                                    <option value="" disabled <?php !$blog ? 'selected' : false; ?>>Choose your option
                                    </option>
                                    <?php foreach ($categories->result() as $category): ?>
                                        <option value="<?= $category->id; ?>" <?= $blog->category_id == $category->id ? 'selected' : false; ?>><?= $category->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col s6">
                            <label for="frequency">Ad Frequency<br/>(per day)</label>
                            <p class="range-field no-margin">
                                <input type="range" class="frequency" name="frequency" min="1" max="12" value="<?= $blog->frequency ? $blog->frequency : false; ?>"/>
                            </p>
                        </div>
                        <div class="col s12">
                            <label>Enable Ads</label>
                            <div class="switch">
                                <label>
                                    <input name="enable" type="checkbox" <?= $blog->enable_ads == 1 ? 'checked' : false; ?>>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="padd-sm"></div>
                    <div class="row">
                        <div class="col s6">
                            <div class="center-align">
                                <input name="submit" class="save btn waves-effect waves-ripple" type="submit" value="Save"/>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="center-align">
                                <a class="btn red" href="<?= site_url('blog/all'); ?>" title="">Back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box box-cut">
                <div class="row">
                    <div class="col s12 center-align">
                        <h2>Follower Counts</h2>
                    </div>
                    <div class="col s12 follower-counts text-black">
                        <table class="table table-responsive">
                            <tr>
                                <th>Week</th>
                                <th>Count</th>
                            </tr>
                            <?php foreach ($followers as $follower): ?>
                                <?php foreach ($follower['followers'] as $instance): ?>
                                    <tr>
                                        <td><?= date('m/d/y',$instance->updated_at);?></td>
                                        <td><?= $instance->followers; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= site_url('assets/js/views/blog/edit.js'); ?>"></script>