 <?php if(!is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../dashboard/'.$this->session->userdata('typeuser'),TRUE,301); ?>
 <?php }?>
<div class="container">
        <div class="card card-container">
        <form name="login" class="form-signin" method="post" id="new-password-form">
            
            <h2 class="form-signin-heading">Set New Password</h2>
             <div class="input-field col s6">
                <input id="password1" name="password1" type="password" class="form-control" placeholder="New Password"  class="validate" required>
            </div>
            <div class="input-field col s6">
                <input id="password2" name="password2" type="password" class="form-control" placeholder="Repeat New Password"  class="validate" required>
            </div>
            <div id="logerror"></div>
            <div class="row center">
                <input type="submit" value="New Password" class="btn btn-lg btn-primary btn-block" name="submit">
            </div>
        </form>
    </div>
</div>
<script>  
  $(document).ready(function(){
    $( "#new-password-form" ).validate({
            rules: {
                password1: {
                  required: true,
                  minlength: 4
              },
                password2: {
                  equalTo: "#password1"
                }
              }
          }); // form validation  
  });
</script>
<style type="text/css">
body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #35465c;
}

.error{
   color: red;
}
.forgot-password{
  color: white;
}
.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
  color: white;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}</style>