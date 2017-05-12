<div class="container">
    <div class="row">
        <div class="col s12">
            <h2>Blog Management</h2>
            <div class="box margin-sm">
                <div class="table-responsive">
                    <table class="striped highlight">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($blogs): ?>
                            <?php foreach ($blogs->result() as $blog): ?>
                                <tr>
                                    <td><?= $blog->id; ?></td>
                                    <td><?= $blog->name; ?></td>
                                    <td><?= $categories[$blog->category_id]; ?></td>
                                    <td>
                                        <a href="<?= site_url("blog/edit/{$blog->id}"); ?>">edit</a>
                                        <a class="confirm" href="<?= site_url("blog/delete/{$blog->id}"); ?>">delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= site_url('/assets/js/views/blog/all.js'); ?>"></script>