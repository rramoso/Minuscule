<div class="container">
    <div class="row">
        <h2>Advertisements</h2>
        <div class="col s12 m6">
            <div class="box margin-sm">
                <h4>Running</h4>
                <?php if ($running): ?>
                    <ul class="collection">
                        <?php foreach ($running->result() as $advertisement): ?>
                            <li class="collection-item"><?= $advertisement->name; ?></li>
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
               href="<?= site_url('advertisement/create'); ?>">Create</a>
        </span>
        <div class="clearfix"></div>
        <div class="box box-cut margin-md">
            <table class="bordered striped responsive-table">
                <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Publish Date</th>
                <th>Created</th>
                <th>Actions</th>
                </thead>
                <tbody>
                <?php foreach ($advertisements->result() as $advertisement): ?>
                    <tr>
                        <td><?= $advertisement->name; ?></td>
                        <td><?= $advertisement->description; ?></td>
                        <td><?= date('m/d/y h:i a', $advertisement->publish); ?></td>
                        <td><?= date('m/d/y h:i a', $advertisement->created); ?></td>
                        <td class="row">
                            <a class="col s8 btn btn-sm solar-green" href="javascript:void(0);"
                               onclick="javascript:publish(<?= $advertisement->id; ?>);">Publish</a>
                            <br/>
                            <a class="col s8 btn btn-sm solar-green" href="javascript:void(0);"
                               onclick="javascript:reblog(<?= $advertisement->id; ?>);">Reblog</a>
                            <br/>
                            <a class="col s8 btn btn-sm solar-green" href="javascript:void(0);"
                               onclick="javascript:unreblog(<?= $advertisement->id; ?>);">UnReblog</a>
                            <div class="padd-xs clearfix"></div>
                            <a class="col s8 btn btn-sm red" href="javascript:void(0);"
                               onclick="javascript:remove(<?= $advertisement->id; ?>);">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= site_url('assets/js/views/advertisement/index.js'); ?>"></script>