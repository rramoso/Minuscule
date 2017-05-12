<div class="container">
    <div class="row">
        <h2>Advertisements</h2>
        <div class="col s12 m6">
            <div class="box margin-sm">
                <h4>Running</h4>
                <?php if ($running): ?>
                    <ul class="collection">
                        <?php foreach ($running as $advertisement): ?>
                            <li class="collection-item"><?= $advertisement->slug; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>There are no currently running ads.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="box margin-sm">
                <h4>Upcoming</h4>
                <?php if ($upcoming): ?>
                    <ul class="collection">
                        <?php foreach ($upcoming->result() as $advertisement): ?>
                            <li class="collection-item"><?= $advertisement->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>There are no currently upcoming ads.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <h2 class="left">All Advertisements</h2>
        <span class="right">
            <a class="btn waves-ripple materialize-red margin-md"
               href="<?= site_url('manage/create'); ?>">Create</a>
        </span>
        <div class="clearfix"></div>
        <div class="box box-cut margin-md">
            <table class="bordered striped responsive-table">
                <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Publish Date</th>
                <th>Created</th>
                <th>Actions</th>
                </thead>
                <tbody>
                <?php foreach ($advertisements->result() as $advertisement): ?>
                    <tr id="ad-<?= $advertisement->id; ?>">
                        <td><?= $advertisement->id; ?></td>
                        <td><?= $advertisement->name; ?></td>
                        <td><?= $advertisement->description; ?></td>
                        <td><?= date('m/d/y h:i a', $advertisement->publish); ?></td>
                        <td><?= date('m/d/y h:i a', $advertisement->created); ?></td>
                        <td class="row">
                            <div class="col s8">
                                <a class="btn btn-sm solar-green" href="<?= site_url("manage/advertisement/{$advertisement->id}"); ?>">Manage</a>
                                <div class="padd-xs clearfix"></div>
                                <a class="btn btn-sm red" href="javascript:void(0);"
                                   onclick="javascript:remove(<?= $advertisement->id; ?>);">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= site_url('assets/js/views/manage/index.js'); ?>"></script>
