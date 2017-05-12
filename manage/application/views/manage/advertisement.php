<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="box margin-sm">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Title</th>
                            <th>Publish Date</th>
                            <th>Run Until</th>
                            <th>Active?</th>
                            <th>Published?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?= $advertisement->id; ?></td>
                            <td><?= $advertisement->name; ?></td>
                            <td><?= date('m/d/y h:i a', $advertisement->publish); ?></td>
                            <td><?= date('m/d/y h:i a', ($advertisement->publish + ($advertisement->duration * 3600))); ?></td>
                            <td><?= $advertisement->active ? 'true' : 'false'; ?></td>
                            <td><?= $advertisement->published ? 'true' : 'false'; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <?php if ($blogs): ?>
                    <div class="blogs">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover header-fixed">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Views</th>
                                    <th><?= $advertisement->name; ?> Reblogs [Today]</th>
                                    <th>Total Reblogs [Today]</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($blogs->result() as $blog): ?>
                                    <tr>
                                        <td><?= $blog->name; ?></td>
                                        <td>
                                            <?= $this->blog_model->advertisement_views($blog->id, $advertisement->id); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $reblogs = $this->blog_model->advertisement_reblogs($blog->id, $advertisement->id, true);
                                            echo $reblogs ? $reblogs->num_rows() : 0;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $reblogs = $this->blog_model->advertisement_reblogs($blog->id, false, true);
                                            echo $reblogs ? $reblogs->num_rows() : 0;
                                            ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm solar-green" href="<?= site_url("manage/reblog-single/{$advertisement->id}/{$blog->id}"); ?>"">Reblog</a>
                                            <a class="btn btn-sm red" href="<?= site_url("manage/unreblog/{$advertisement->id}/{$blog->id}"); ?>"">Un-Reblog</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>