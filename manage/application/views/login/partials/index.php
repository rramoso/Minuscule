<div class="welcome-text">
    <div class="container">
        <div class="logo">
            <img src="<?= site_url('assets/images/minuscule-full-trans.png'); ?>">
        </div>
    </div>
</div>
<div class="padd-md clearfix"></div>
<?php if ($this->tumblr && $this->user->email && !$this->user->first_login): ?>
    <?php redirect('site/dashboard'); ?>
<?php elseif ($this->tumblr && $this->user->email): ?>
    <?= $first_login; ?>
<?php elseif ($this->tumblr && !$this->user->email): ?>
    <?= $register; ?>
<?php else: ?>
    <?= $login; ?>
<?php endif; ?>
</div>
<script src="<?= site_url('assets/js/views/site/index.js'); ?>"></script>