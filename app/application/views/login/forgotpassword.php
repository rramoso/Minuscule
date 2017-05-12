 <?php if(!is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../dashboard/'.$this->session->userdata('typeuser'),TRUE,301); ?>
 <?php }?>
<div class="container">
        <div class="card card-container">
        <form name="login" class="form-signin" method="post" id="login-form">
            
            <h2 class="form-signin-heading">Email</h2>
            <div class="input-field col s12">
                <input id="email" name="email" type="text" class="form-control" placeholder="Email"class="validate" required>
                <label for="email"></label>
            </div>
            <div id="logerror"></div>
            <div class="row center">
                <input type="submit" value="Login" class="btn btn-lg btn-primary btn-block" name="submit">
            </div>
        </form>
    </div>
</div>
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