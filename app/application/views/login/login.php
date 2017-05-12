 <?php if(!is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'https://'.site_url('index.php/dashboard/'.$this->session->userdata('typeuser')),TRUE,301); ?>
 <?php }?>
 
 <body class="fixed-header ">
    <div class="login-wrapper ">
      <!-- START Login Background Pic Wrapper-->
      <div class="bg-pic" >
        <!-- START Background Pic-->
        <img src="../../assets/images/starryNight.gif" data-src="../../assets/images/starryNightWater.gif" alt="" class="lazy">
        
        <!-- END Background Pic-->
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
          <h2 class="semi-bold text-white">
          Minuscule | A Creative Network</h2>
          <p class="small">
            Images displayed are solely for representation purposes only, All work copyright of respective owner, otherwise © 2017 Minuscle.
          </p>
        </div>
        <!-- END Background Caption-->
      </div>
      <!-- END Login Background Pic Wrapper-->
      <!-- START Login Right Container-->
      <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          <img src="../../assets/images/minuscule-full-trans.png" alt="logo" data-src="../../assets/images/minuscule-full-trans.png" width="350" height="50">
          
          <p class="p-t-35">Sign into your Minuscule account</p>
          <!-- START Login Form -->
          <form  method="post" id="login-form" name="login" class="p-t-15" role="form">
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Login</label>
              <div class="controls">
                <input id="user" name="user" type="text" class="form-control" placeholder="Username / Email"class="validate" required>
                
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Password</label>
              <div class="controls">
                <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <!-- START Form Control-->
            <div class="row">
              <div class="col-md-6 text-right">
                <a href="/app/index.php/login/forgotpassword" class="text-info small">Forgot password?</a>
              </div>
            </div>
            <!-- END Form Control-->
            <button class="btn btn-primary btn-cons m-t-10" type="submit">Sign in</button>
            <a href="/app/index.php/signup/view" class="btn btn-cons m-t-10">Sign Up</a>
              
          </form>
          <!--END Login Form-->
          <div class="pull-bottom sm-pull-bottom">
            <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
              <div class="col-sm-9 no-padding m-t-10">
                <p>
                  <small>
                  </small>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END Login Right Container-->
    </div>
    <!-- BEGIN VENDOR JS -->
    <script src="../../assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-bez/jquery.bez.min.js"></script>
    <script src="../../assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="../../assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script type="text/javascript" src="../../assets/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript" src="../../assets/plugins/classie/classie.js"></script>
    <script src="../../assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
    <script src="../../assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <script src="pages/js/pages.min.js"></script>
    <script>
    $(function()
    {
      $('#login-form').validate()
    })
    </script>
  </body>

