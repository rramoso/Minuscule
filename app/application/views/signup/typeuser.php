 <?php if(!is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../dashboard/'.$this->session->userdata('typeuser'),TRUE,301); }?>
 
  <script src="assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>

 <div class="register-container full-height sm-p-t-30">
      <div class="container-sm-height full-height">
        <div class="row row-sm-height">
          <div class="col-sm-12 col-sm-height col-middle">
            <img src="../../assets/images/minuscule-full-trans.png" alt="logo" src="../../assets/images/minuscule-full-trans.png" width="400" height="70">
            <p>
            </p>
            <form class="p-t-15" method="post" name="typeuser">
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary active">
                  <input onchange="showDiv(this)" autocomplete="off" type="radio" name="usertype" value="artist">Artist
                </label>     
                <label id="radio"class="btn btn-primary active">
                  <input  onchange="showDiv(this)" autocomplete="off" type="radio" name="usertype" value="curator">Curator
                </label>
              </div>
                
              <br>
              <br>
              <br>
              <div id="artist_div" style="display: none;">

                <label>Artist Nickname:</label>
                <input name="artist_nickname" id="artist_nickname" type="text" class="form-control" placeholder="Artist Nickname" autofocus>
                <br>
                <label>Artist Categories:</label>
                <table class="tableSection">
                  <tbody>
                  <?php foreach ($categories as $category) { ?>
                    
                      <tr>
                        <td>
                          <input type="checkbox" id="check_list[<?php echo $category->name ?>]" name="check_list[<?php echo $category->name ?>]" value="<?php echo $category->id ?>"/>
                          <label class="category" for="check_list[<?php echo $category->name ?>]"><?php echo $category->name ?></label>
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                </table>
                
                <br>

                <label>Artist Manifesto:</label>
                <textarea class="form-control" rows="5" id="artist_manifesto" name="artist_manifesto"></textarea>
              
              </div>
              <div id="curator_div" style="display: none;">
                <label>Website Name:</label>
                <input name="curator_website" id="curator_website" type="text" class="form-control" placeholder="Curator Website" autofocus>
                <br>
                <label>
                <input name="original_content" type="checkbox" id="original_content"> Press here to state that my blog features more original uploads than reblogs.</label>
                <label><input name="adheres_tumblr" type="checkbox" id="adheres_tumblr"> Press here to state that my blog adheres fully to the Tumblr and that I have never, and will never, use any service to falsely increase any blog metrics.</label>

              </div>
              <br>
              <br>
              <input class="btn btn-lg btn-primary btn-block" type="submit" value="Continue" name="submit">
            </form>
      </div>
    </div>
  </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="js/signup.js"></script>
    <script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
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
    <script src="../../pages/js/pages.min.js"></script>
<script>
function showDiv(elem){
   if(elem.value == 'artist'){
      document.getElementById('artist_div').style.display = "block";
      document.getElementById('curator_div').style.display = "none";
  }
  else{
      document.getElementById('curator_div').style.display = "block";
      document.getElementById('artist_div').style.display = "none";
  }
}
</script>
  </body>
</html>
<style type="text/css">

 table.tableSection {
        display: table;
        width: 100%;
    }
    table.tableSection thead, table.tableSection tbody {
        float: left;
        width: 100%;
    }
    table.tableSection tbody {
        overflow: auto;
        height: 150px;
    }
    table.tableSection tr {
        width: 100%;
        display: table;
        text-align: left;
    }
.category {
display:block;
border:solid 1px gray;
line-height:40px;
height:40px;
width: 250px;
border-radius:40px;
-webkit-font-smoothing: antialiased; 
margin-top:10px;
font-family:Arial,Helvetica,sans-serif;
color:white;
text-align:center;
background-color: #19212b;
}

input[type=checkbox] {
display: none;
}
input:checked + label {
border: solid 1px green;
color: green;
}

input:checked + label:before {
content: "\2713";
}
</style>