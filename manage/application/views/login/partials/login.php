<div id="login">
    <div id="login-container" class="center container container-sm animated fadeInUp">
        <form name="login" id="login-form">
            <div class="input-field col s12">
                <input id="user" name="user" type="text" class="validate" required>
                <label for="user">Username / Email</label>
            </div>
            <div class="input-field col s6">
                <input id="password" name="password" type="password" class="validate" required>
                <label for="password">Password</label>
            </div>
            <div class="row center">
                <button class="btn waves-effect waves-light red" type="submit" name="action">Login
                </button>
                <a href="#" class="forgot-password btn waves-effect waves-light grey">Forgot Password</a>
            </div>
        </form>
        <div class="clearfix padd-md">
            <hr/>
        </div>
        <p>Ready to get started? Register with</p>
        <a class="register" href="#" alt="login">
            <img class="tumblr-logo" src="<?= site_url('assets/images/logo-tumblr.png'); ?>"/>
        </a>
    </div>
</div>

<script>
    $(function () {
        $('a.forgot-password').click(function () {
            swal({
                title: "Forgot Password",
                text: "Lost your password? We've got your back.",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Remember your account email?"
            }, function (inputValue) {
                if (!validateEmail(inputValue)) {
                    swal.showInputError("Invalid email address.");
                    return false;
                }
                $.post("<?= site_url('login/forgot');?>", {email: inputValue}, function (data) {
                    switch (data.status) {
                        case 'success':
                            swal.close();
                            setTimeout(function () {
                                swal({title: "Success!", text: data.message, timer: 2000, showConfirmButton: true});
                            }, 300);
                        case 'error':
                            swal.showInputError(data.message);
                    }
                });
            })
        });
        $('a.register').click(function () {
            swal({
                title: "Invitation Code",
                text: "Gotten an invitation code from us?",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Let's get that code in here!"
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                }
                $.post("<?= site_url('login/invitation');?>", {code: inputValue}, function (data) {
                    switch (data.status) {
                        case 'success':
                            window.location.href = data.message;
                            break;
                        case 'error':
                            swal.showInputError(data.message);
                    }
                });
            });
        });
        function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    })
</script>