
<div class="container">
  <div class="card card-container">
    <div  class="form-signup" >
      <div class="message">
        <h1><?php echo $title_message; ?></h1>
        <p><?php echo $body_message; ?></p>
      </div>
      <div class="row center">
        <a href="/app/index.php/signup/view" class="forgot-password btn waves-effect waves-light grey">Sign Up</a>
        <a href="/app/index.php/login/view" class="forgot-password btn waves-effect waves-light grey">Log In</a>
      </div>
    </div>
  </div>
</div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <script src="js/signup.js"></script>


    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

<style type="text/css">
body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #35465c;
}

.message{
  background-color: #485f7c;
  color: white;
}

.forgot-password{
  color: white;
}

.form-signup {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signup .form-signup-heading,
.form-signup .checkbox {
  margin-bottom: 10px;
  color: white;
  text-align: center;
}
.form-signup .checkbox {
  font-weight: normal;
}
.form-signup .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signup .form-control:focus {
  z-index: 2;
}
.form-signup input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signup input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.placeholder img {
  display: inline-block;
  border-radius: 50%;
  width: 200px;
  height: 200px;
  position:relative;
  display: block;
  margin-left: auto;
  margin-right: auto
}
.form-signup  label{

  display: block;
  margin-left: auto;
  margin-right: auto
}

.btn-file {
    position: relative;
    overflow: hidden;
    background-color:#FF5733;
    color:white;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background-color:#FF5733;
    cursor: inherit;
    display: block;
}
</style>