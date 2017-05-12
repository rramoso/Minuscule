 <?php if(!is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'https://'.site_url('index.php/dashboard/'.$this->session->userdata('typeuser')),TRUE,301); ?>
 <?php }?>


 <script src="assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>

 <div class="register-container full-height sm-p-t-30">
      <div class="container-sm-height full-height">
        <div class="row row-sm-height">
          <div class="col-sm-12 col-sm-height col-middle">
            <img src="../../assets/images/minuscule-full-trans.png" alt="logo" src="../../assets/images/minuscule-full-trans.png" width="400" height="70">
            <h4>MINUSCULE USES THE POWER OF DIGITAL MARKETING TO HELP TALENTED CONTENT CREATORS GROW.</h4>
            <p>
            </p>
            <form id="usersignup" class="p-t-15"  name="register" method="post" enctype="multipart/form-data">
              <h2 class="form-signup-heading">Sign Up</h2>
                  <div id="image-holder" class="placeholder">
                    <img src="<?php echo '../../assets/images/'.$gender.'-profile.png'?>" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                  </div>
                  
              <div>
                <label class="btn btn-default btn-file">
                      Browse <input id="avatar" name="avatar" type="file" hidden>
                  </label>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-default">
                        <label>Username</label>
                        <input name="newuser" id="newuser" type="text" class="form-control" placeholder="Username" autofocus>
                        <p id="userMessage"></p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group form-group-default">
                        <label>First Name</label>
                        <input name="firstname" id="firstname" type="text" class="form-control" placeholder="First Name" autofocus>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group form-group-default">
                        <label>Last Names</label>
                        <input name="lastname" id="lastname" type="text" class="form-control" placeholder="Last Name" autofocus>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-default">
                        <label>Email</label>
                        <input name="email" id="email" type="text" class="form-control" placeholder="Email" data-validation="email">
                        <p id="emailMessage"></p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-default">
                        <label>Phonenumber</label>
                        <input name="phonenumber" id="phonenumber" type="text" class="form-control" placeholder="Phonenumber" autofocus>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-default">
                        <label>Website</label>
                        <input name="website" id="website" type="text" class="form-control" placeholder="Website Link" autofocus>
                      </div>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-default">
                        <label>Password</label>
                        <input name="password1" id="password1" type="password" class="form-control" placeholder="Password">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group form-group-default">
                        <label>Repeat Password</label>
                        <input name="password2" id="password2" type="password" class="form-control" placeholder="Repeat Password">
                      </div>
                    </div>
                  </div>  
                <div class="row center">
                  <input type="submit" class="btn btn-primary btn-cons m-t-10" value="Continue" name="submit">
                  <a href="/app/index.php/login/view" class="btn btn-cons m-t-10">Log In</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
<div class="container">
  <div class="card card-container">
    
  </div>
</div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="js/signup.js"></script>
    <script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script>

  $.validate({
    modules : 'location, date, security, file',
    onModulesLoaded : function() {
      $('#country').suggestCountry();
    }
  });

  // Restrict presentation length
  $('#presentation').restrictLength( $('#pres-max-length') );

</script>
<script>
$(document).ready(function() {

        $('#newuser').keyup(username_verifier);
        $('#email').keyup(email_verifier);
        
        if( $('#userMessage').html() == '' && $('#emailMessage').html() == ''){
          $('input[name=submit]').attr('disabled', false);
        }else{
          $('input[name=submit]').attr('disabled', true);
        }
        var valid = true;
        $( "#usersignup" ).validate({
            rules: {
              email: {
                email: true,
                required: true
              },
                password1: {
                  required: true,
                  minlength: 4
              },
                password2: {
                  equalTo: "#password1"
                },
                newuser:{
                  required: true,
                  minlength: 4
                }
              }
          });
         
        $("#avatar").on('change', function() {
          //Get count of selected files
          var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var image_holder = $("#image-holder");
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
              //loop for each file selected for uploaded.
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
              }
            } else {
              alert("This browser does not support FileReader.");
            }
          } else {
            alert("Pls select only images");
          }
        });

      function username_verifier(){

        var username = $('#newuser').val();
        console.log("<?php echo base_url() ?>");
        if(username.length > 0 ){
          $.ajax({
                url: "<?php echo 'https://'.site_url('index.php/dashboard/usernameCheck/')?>" + username,
                type: 'GET',
                dataType: 'JSON'
           })
           .done(function(response){

                 if(response == 1){
                    $('#newuser').css('border', '3px #C33 solid'); 
                    $('#userMessage').css('color','red');
                    $('#userMessage').html('Username already taken! Choose another one');
                    $('input[name=submit]').attr('disabled', true);
                 }
                 else{
                  $('#newuser').css('border', '3px #090 solid');
                    $('#userMessage').html('');
                    $('input[name=submit]').attr('disabled', false);
                 }
           })
         }else{
          $('#newuser').css('border', 'none');
         }
      }
      function email_verifier(){

        var mail = $('#email').val();
        var email = mail.split('@')[0];
        var domain = mail.split('.')[1];
        var company = mail.split('.')[0].split('@')[1];
        console.log(email,company,domain);
        if(mail.length > 0 ){
          $.ajax({
                url: "<?php echo 'https://'.site_url('index.php/dashboard/emailCheck/')?>" + email+"/"+company+"/"+domain,
                type: 'GET',
                dataType: 'JSON'
           })
           .done(function(response){
                 if(response == 1){
                    $('#email').css('border', '3px #C33 solid'); 
                    $('#valid').val(0);
                    $('#emailMessage').css('color','red');
                    $('#emailMessage').html('Email already registered! Choose another one');
                        $('input[name=submit]').attr('disabled', true);
                 }
                 else{
                  $('#email').css('border', '3px #090 solid');
                  $('#valid').val(1);
                    $('#emailMessage').html('');
                    $('input[name=submit]').attr('disabled', false);

                 }
           })
         }else{
          $('#email').css('border', 'none');
         }
      }
       
      });
</script>
