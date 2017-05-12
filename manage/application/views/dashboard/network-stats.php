<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

<div class="container box box-cut">
    <h1>Network Stats</h1>
    <p>View your current advertisement activity. Stats are up to date as of the last page reload
        (<?= date('m/d h:i:s a'); ?>)</p>
    <div class="clearfix padd-sm"></div>
    <div class="row">
        <?php if ($followers): ?>
            <div class="right-align">
                <a class="btn waves-effect" href="<?= site_url('dashboard/export-followers'); ?>">Export</a>
            </div>
            <div class="col s12 follower-count-table">
                <table class="table" width="100%">
                    <thead>
                    <tr>
                        <th>Blog Name</th>
                        <?php $cursor = 0; ?>
                        <?php foreach ($followers[0]['followers'] as $count): ?>
                            <th><?= date('m/d/y', $count->updated_at); ?></th>
                            <?php $cursor++; ?>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($followers as $follower): ?>
                        <tr>
                            <td><?= $follower['blog']->name; ?></td>
                            <?php foreach ($follower['followers'] as $count): ?>
                                <td><?= number_format($count->followers); ?></td>
                            <?php endforeach; ?>
                            <?php if (count($follower['followers']) < $cursor): ?>
                                <?php for ($i = count($follower['followers']); $i < $cursor; $i++): ?>
                                    <td>n/a</td>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <?php if ($hour || $day): ?>
            <div class="col s12">
                <div class="row">
                    <div class="col s12 chart">
                        <h2>Views per Hour (past day)</h2>
                        <?php if ($hour): ?>
                            <div class="col s12 m9">
                                <canvas id="hourChart"></canvas>
                            </div>
                            <div class="col s12 m3">
                                <div class="legend"></div>
                            </div>
                        <?php else: ?>
                            <p>Looks like there hasn't been any daily traffic yet...</p>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix padd-xl"></div>
                    <div class="col s12 chart">
                        <h2>Views per Day (past week)</h2>
                        <?php if ($day): ?>
                            <div class="col s12 m9">
                                <canvas id="dayChart"></canvas>
                            </div>
                            <div class="col s12 m3">
                                <div class="legend"></div>
                            </div>
                        <?php else: ?>
                            <p>Looks like there hasn't been any weekly traffic yet...</p>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix padd-xl"></div>
                </div>
            </div>
        <?php else: ?>
            <h4>Whoa there sparky. Looks like you don't have any data yet, you sure you have some blogs enabled.</h4>
        <?php endif; ?>
    </div>
</div>
<script>
  $(function () {
    $('.follower-count-table table').DataTable({
      searching: false,
      pageLength: 20,
    });
      <?php if ($hour): ?>
    var hourData = <?= isset($hour) ? $hour : []; ?>;
    var ctx = $("#hourChart").get(0).getContext("2d");
    var hourChart = new Chart(ctx).Line(hourData, {responsive: true});
    $("#hourChart").parents('.chart').find('.legend').html(hourChart.generateLegend());
      <?php endif; ?>
      <?php if ($day): ?>
    var dayData = <?= isset($day) ? $day : []; ?>;
    var ctx = $("#dayChart").get(0).getContext("2d");
    var dayChart = new Chart(ctx).Line(dayData, {responsive: true});
    $("#dayChart").parents('.chart').find('.legend').html(dayChart.generateLegend());
      <?php endif;?>
  })
</script>