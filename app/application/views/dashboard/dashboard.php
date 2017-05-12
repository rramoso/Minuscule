 <?php if($this->session->userdata('typeuser') == 'artist'){ ?>
 <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
  
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        <img src="../../assets/images/minuscule-logo-trans.png" alt="logo" class="brand" data-src="../../assets/images/minuscule-logo-trans.png" width="78" height="22">
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30 ">
            <a href="/app/index.php/dashboard/artist" class="detailed">
              <span class="title">Profile</span>
            </a>
            <span class="icon-thumbnail">P</span>
          </li>
          <li class="">
            <a href="/app/index.php/dashboard/uploadArtWork" class="detailed">
              <span class="title">Upload</span>
            </a>
            <span class="icon-thumbnail">U</span>
          </li>
          <li class="">
            <a href="/app/index.php/dashboard/categories" class="detailed">
              <span class="title">Categories</span>
            </a>
            <span class="icon-thumbnail">C</span>
          </li>
          
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container ">
      <!-- START HEADER -->
      <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <div class="container-fluid relative">
          <!-- LEFT SIDE -->
          <div class="pull-left full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
            <div class="header-inner">
              <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
                <span class="icon-set menu-hambuger"></span>
              </a>
            </div>
            <!-- END ACTION BAR -->
          </div>
          <div class="pull-center hidden-md hidden-lg">
            <div class="header-inner">
              <div class="brand inline">
                <img src="../../assets/images/minuscule-logo-trans.png" alt="logo" data-src="../../assets/images/minuscule-logo-trans.png" width="50" height="22">
              </div>
            </div>
          </div>
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table hidden-xs hidden-sm">
          <div class="header-inner">
            <div class="brand inline" style="margin-left: 78px;">
              <img src="../../assets/images/minuscule-full-trans.png" alt="logo" data-src="../../assets/images/minuscule-full-trans.png" width="350" height="50">
            </div>
          </div>
        </div>
        
        <div class=" pull-right">
          <!-- START User Info-->
          <div class="visible-lg visible-md m-t-10">
            <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
              <span class="semi-bold"><?php echo $user_name ?> </span>
            </div>
            <div class="dropdown pull-right">
              <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline m-t-5">
                <?php if($avatar != '') {?>
                  <img src="<?php echo '../../assets/uploads/avatars/'. $avatar ?>" alt="Generic placeholder thumbnail" width="32" height="32">
                  <?php }else{?>
                  <img src="<?php echo '../../assets/images/'.$gender.'-profile.png'?>" width="32" height="32" class="img-responsive" alt="Generic placeholder thumbnail">
                  <?php }?>
                </span>
              </button>
              <ul class="dropdown-menu profile-dropdown" role="menu">
                <!--  -->
                <li class="bg-master-lighter">
                  <a href="/app/index.php/dashboard/logout" class="clearfix">
                    <span class="pull-left">Logout</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- END User Info-->
        </div>
      </div>
      <!-- END HEADER -->

<?php } else {?>
 <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        <img src="../../assets/images/minuscule-logo-trans.png" alt="logo" class="brand" data-src="../../assets/images/minuscule-logo-trans.png" width="78" height="22">
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30 ">
            <a href="/app/index.php/dashboard/curator" class="detailed">
              <span class="title">Artist</span>
              <span class="title">Database</span>
            </a>
            <span class="icon-thumbnail">AD</span>
          </li>
          <li class="">
            <a href="/app/index.php/dashboard/favorites" class="detailed">
              <span class="title">Favorites</span>
            </a>
            <span class="icon-thumbnail">F</span>
          </li>
          <li class="">
            <a href="/app/index.php/dashboard/categories" class="detailed">
              <span class="title">Categories</span>
            </a>
            <span class="icon-thumbnail">C</span>
          </li>
          
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container ">
      <!-- START HEADER -->
      <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <div class="container-fluid relative">
          <!-- LEFT SIDE -->
          <div class="pull-left full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
            <div class="header-inner">
              <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
                <span class="icon-set menu-hambuger"></span>
              </a>
            </div>
            <!-- END ACTION BAR -->
          </div>
          <div class="pull-center hidden-md hidden-lg">
            <div class="header-inner">
              <div class="brand inline">
                <img src="../../assets/images/minuscule-logo-trans.png" alt="logo" data-src="../../assets/images/minuscule-logo-trans.png" width="50" height="22">
              </div>
            </div>
          </div>
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table hidden-xs hidden-sm">
          <div class="header-inner">
            <div class="brand inline" style="margin-left: 78px;">
              <img src="../../assets/images/minuscule-full-trans.png" alt="logo" data-src="../../assets/images/minuscule-full-trans.png" width="350" height="50">
            </div>
          </div>
        </div>
        
        <div class=" pull-right">
          <!-- START User Info-->
          <div class="visible-lg visible-md m-t-10">
            <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
              <span class="semi-bold"><?php echo $user_name ?> </span>
            </div>
            <div class="dropdown pull-right">
              <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline m-t-5">
                <?php if($avatar != '') {?>
                  <img src="<?php echo '../../assets/uploads/avatars/'. $avatar ?>" alt="Generic placeholder thumbnail" width="32" height="32">
                  <?php }else{?>
                  <img src="<?php echo '../../assets/images/'.$gender.'-profile.png'?>" width="32" height="32" class="img-responsive" alt="Generic placeholder thumbnail">
                  <?php }?>
                </span>
              </button>
              <ul class="dropdown-menu profile-dropdown" role="menu">
                <!-- <li><a href="#"><i class="pg-settings_small"></i> Settings</a>
                </li>
                <li><a href="#"><i class="pg-outdent"></i> Feedback</a>
                </li>
                <li><a href="#"><i class="pg-signals"></i> Help</a>
                </li> -->
                <li class="bg-master-lighter">
                  <a href="/app/index.php/dashboard/logout" class="clearfix">
                    <span class="pull-left">Logout</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- END User Info-->
        </div>
      </div>
      <!-- END HEADER -->
<?php }?>
      