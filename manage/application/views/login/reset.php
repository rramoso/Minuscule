<div class="container container-sm ">
    <div class="margin-lg">
        <div class="col s12">
            <?php if ($user): ?>
                <h3>Reset Password</h3>
                <p>So you forgot your password? Well let's get it reset again. Be sure you choose something secure!</p>
                <p><strong>Requirements:</strong></p>
                <ul>
                    <li class="count">At least 8 characters</li>
                    <li class="alpha">Contains both upper and lowercase characters</li>
                    <li class="special">Contains a number and/or special character</li>
                </ul>
                <div class="padd-md"></div>
                <form action="<?= site_url('login/reset'); ?>" method="post" name="reset">
                    <input type="hidden" name="token" value="<?= $token; ?>"
                    <div class="input-field col s6">
                        <input id="register-password" name="password" type="password" class="validate" required>
                        <label for="register-password">Password</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="confirm-password" name="confirm-password" type="password" class="validate"
                               required>
                        <label for="confirm-password">Confirm Password</label>
                    </div>
                    <div class="row center">
                        <button class="btn waves-effect waves-light red" type="submit" name="action" disabled>Reset
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<script src="<?= site_url('assets/js/views/login/reset.js'); ?>"></script>