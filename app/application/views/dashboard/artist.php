 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css"></script>
  

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="/app/index.php/dashboard/artist">Profile</a></li>
            <li><a href="/app/index.php/dashboard/uploadArtWork">Upload <span class="sr-only">(current)</span></a></li>
            <li><a ucfirst(>Categories</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="table-responsive">
            <div class="row placeholders">
              <div class="row artist-info">
                <div class="col-xs-6 col-sm-3 placeholder">
                  <?php if($avatar != '') {?>
                  <img src="<?php echo '../../assets/uploads/avatars/'. $avatar ?>" width="200" height="200"  alt="Generic placeholder thumbnail">
                  <?php }else{?>
                  <img src="<?php echo '../../assets/images/'.$gender.'-profile.png'?>" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                  <?php }?>
                  </div>
                <div>
                  <h1 class="nickname"> <?php echo ucfirst($nickname); ?> </h1>
                  <h4 class="name"><?php echo $artist_name ?> </h4>
                  <label>Social Net</label>
                  <p class = "manifesto"><?php echo $manifesto ?></p>
                </div>
              </div>
              <br><br><br>
              <h2 class="page-header">Your work:</h2>
              <div class="row">
                <?php 
                  foreach ($gallery as $image) { ?>
                    <div data-id="<?php echo $image->id ?>" class="col-xs-6 col-sm-3 placeholder" id="getInfo"data-toggle="modal" data-target="#myModal">
                      <div class="artwork">
                        <img src="../../assets/uploads/<?php echo $image->name ?>" style="height: 200px;"width="200px" height="200px" class="img-responsive" alt="Generic placeholder thumbnail">
                        <div class="crop image-description"><?php echo $image->description ?></div>
                      </div>
                    </div>
                  <?php } ?>
              </div>
          </div>

          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?php echo $nickname ?></h4>
        </div>
        <div id="work_image">

        </div>
        <div id="work_description" class="modal-body">
          
        </div>
      </div>
      
    </div>

<script type="text/javascript">
$(document).ready(function(){

    $(document).on('click', '#getInfo', function(e){
    e.preventDefault();
  
     var piece_id = $(this).data('id'); // get id of clicked row
      console.log($(this).data('id'));
     $('#dynamic-content').html(''); // leave this div blank
     $('#modal-loader').show();      // load ajax loader on button click
 
     $.ajax({
          url: "<?php echo 'https://'.site_url('index.php/dashboard/ajaxArtWork/')?>" + piece_id,
          type: 'GET',
          dataType: 'JSON'
     })
     .done(function(data){
          console.log(data); 
          $('#work_image').html("<img src='../../assets/uploads/"+data.name+"'>");
          $('#work_description').html(''); // blank before load.
          $('#work_description').html("<p>"+data.description+"</p>"); // load here
          // $('#modal-loader').hide(); // hide loader  
     })
     .fail(function(){
          alert('Error get data from ajax');
     });

    });
});
</script>
<style type="text/css">
  /*
 * Base structure
 */

/* Move down content because we have a fixed navbar that is 50px tall */
body {
  padding-top: 50px;
  background-color: #35465c;
}

.artwork{
  background-color: cadetblue;
   border-radius: 25px;
}
/*
 * Global add-ons
 */

.sub-header {
  padding-bottom: 10px;
  border-bottom: 1px solid #19212b;
}

/*
 * Top navigation
 * Hide default border to remove 1px line.
 */
.navbar-fixed-top {
  border: 0;
}

/*
 * Sidebar
 */
.crop {width:100px;overflow:hidden;height:50px;line-height:50px;}​
/* Hide for mobile, show later */
.sidebar {
  display: none;
}
@media (min-width: 768px) {
  .sidebar {
    position: fixed;
    top: 51px;
    bottom: 0;
    left: 0;
    z-index: 1000;
    display: block;
    padding: 20px;
    overflow-x: hidden;
    overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
    background-color: #f5f5f5;
  }
}
/* Sidebar navigation */
.nav-sidebar {
  margin-right: -21px; /* 20px padding + 1px border */
  margin-bottom: 20px;
  margin-left: -20px;
}
.nav-sidebar > li > a {
  padding-right: 20px;
  padding-left: 20px;
  color: white;
}
.nav-sidebar > .active > a,
.nav-sidebar > .active > a:hover,
.nav-sidebar > .active > a:focus {
  background-color: #428bca;
}
.sidebar{

  background-color: #2c3a4c;
}
.image-description{
  color:white;
}
/*
 * Main content
 */
.nickname{
  color: white;
}
.manifesto{
  color: antiquewhite;
}
.main {
  padding: 20px;
}
@media (min-width: 768px) {
  .main {
    padding-right: 40px;
    padding-left: 40px;
  }
}
.modal-title{
  text-align: center;
}
.modal-content{
  position: relative;
    overflow-y: auto;
    padding: 15px;
}
#work_image img{
  display:block;
  margin:auto;
}

.main .page-header {
  color: white;
  text-align: center;
  margin-top: 0;
  border-bottom: 1px solid #35465c;
}
.artist-info{
    background-color: cadetblue;
}

/*
 * Placeholder dashboard ideas
 */

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