<div class="center">
    Welcome <?= $this->user->first_name . " " . $this->user->last_name; ?>! Now that you're logged in, we can
    get started.
    <div class="clearfix padd-md"></div>
    <a href="<?= site_url('blog/setup'); ?>" class="btn-floating btn-large waves-effect waves-light red">
        <i class="material-icons">keyboard_arrow_right</i>
    </a>
</div>