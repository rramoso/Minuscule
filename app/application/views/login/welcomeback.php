 <?php if(!is_null($this->session->userdata('typeuser'))){?>
 <?php header("Location:".'../../dashboard/'.$this->session->userdata('typeuser'),TRUE,301); }?>
  <div class="container">
  <div class="card card-container">
      <form class="form-signup" method="post" name="typeuser">

        
        <div class="btn-group" data-toggle="buttons">
          <div class="box">
            <label><h1>Welcome back!</h1></label>
            <p>There has been some changes since last time you were here. So for the best experience of Miniscule, please tell us what type of user you plan to be.</p>
          </div>
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
    </div> <!-- /container -->

    <script src="//code.jquery.com/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script src="js/signup.js"></script>


    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

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
body {
  padding-top: 40px;
  background-color: #35465c;

}
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


.box{

  margin-bottom: 30px;
  margin-top: 30px;
  padding-left: 10px;
  padding-right: 10px;
  height:18em;
  border: 1px solid #ccc;
  background-color: rgba(179, 179, 179, 0.48);
}  

.box p{
  color: #d9edf7;
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
color:gray;
text-align:center;
background-color: #19212b;
}
input[type=checkbox] {
display: none;
}
#original_content,
#adheres_tumblr{
  display: inline;
}
input:checked + label {
border: solid 1px green;
color: green;
}

input:checked + label:before {
content: "\2713";
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
label{
  color: white;
}
#radio{
  margin-left: 25px;
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
.placeholders {
  margin-bottom: 30px;
  text-align: center;
}
.placeholders h4 {
  margin-bottom: 0;
}
.placeholder {

    padding-left: 20px;
    padding-right: 0px;
  margin-top: 20px;
  margin-bottom: 20px;
}
.placeholder img {
  display: inline-block;
  border-radius: 50%;
}
</style>