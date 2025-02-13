   <div id="main-wrapper">
       <!-- ============================================================== -->
       <!-- Topbar header - style you can find in pages.scss -->
       <!-- ============================================================== -->
       <header class="topbar">
           <nav class="navbar top-navbar navbar-expand-md navbar-dark">
               <div class="navbar-header">
                   <!-- This is for the sidebar toggle which is visible on mobile only -->
                   <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                   <a class="navbar-brand d-block d-md-none" href="#">
                       <!-- Logo icon -->
                       <b class="logo-icon">
                           <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                           <!-- Dark Logo icon -->
                           <img src="assets/images/logos/logo-icon.png" alt="homepage" class="dark-logo" />
                           <!-- Light Logo icon -->
                           <img src="assets/images/logos/logo-light-icon.png" alt="homepage" class="light-logo" />
                       </b>
                       <!--End Logo icon -->
                       <!-- Logo text -->
                       <span class="logo-text">
                           <!-- dark Logo text -->
                           <img src="assets/images/logos/logo-text.png" alt="homepage" class="dark-logo" />
                           <!-- Light Logo text -->
                           <img src="assets/images/logos/logo-light-text.png" class="light-logo" alt="homepage" />
                       </span>
                   </a>
                   <div class="d-none d-md-block text-center">
                       <a class="sidebartoggler waves-effect waves-light d-flex align-items-center side-start" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                           <i class="mdi mdi-menu"></i>
                           <span class="navigation-text ml-3"> SWIFT</span>
                       </a>
                   </div>
                   <!-- ============================================================== -->
                   <!-- End Logo -->
                   <!-- ============================================================== -->
                   <!-- ============================================================== -->
                   <!-- Toggle which is visible on mobile only -->
                   <!-- ============================================================== -->
                   <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
               </div>
               <!-- ============================================================== -->
               <!-- End Logo -->
               <!-- ============================================================== -->
               <div class="navbar-collapse collapse" id="navbarSupportedContent">
                   <!-- ============================================================== -->
                   <!-- toggle and nav items -->
                   <!-- ============================================================== -->
                   <ul class="navbar-nav float-left mr-auto">
                       <!-- ============================================================== -->
                       <!-- Logo -->
                       <!-- ============================================================== -->
                       <li class="nav-item border-right">
                           <a class="nav-link navbar-brand d-none d-md-block" href="#">
                               <!-- Logo icon -->
                               <b class="logo-icon">
                                   <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                   <!-- Dark Logo icon -->
                                   <img src="images/swift_logo.png" alt="homepage" height="60" width="60" class="dark-logo" />
                                   <!-- Light Logo icon -->
                                   <img src="images/swift_logo.png" alt="homepage" height="60" width="60" class="light-logo" />
                               </b>
                               <!--End Logo icon -->
                               <!-- Logo text -->
                               <span class="logo-text">
                                   <!-- dark Logo text -->
                                   <img src="images/logo_name.png" alt="homepage" id="logo_name" height="25" class="dark-logo" />
                                   <!-- Light Logo text -->
                                   <img src="images/logo_name.png" height="25" id="logo_name" class="light-logo" alt="homepage" />
                               </span>
                           </a>
                       </li>

                   </ul>
                   <!-- ============================================================== -->
                   <!-- Right side toggle and nav items -->
                   <!-- ============================================================== -->
                   <ul class="navbar-nav float-right">

                       <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <img src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31">
                               <span class="ml-2 user-text font-medium"><?php echo $_SESSION['name'];
                                                                        if (!empty($_SESSION['depname']) && $_SESSION['depname'] != '') { ?> ( <?php echo $_SESSION['depname']; ?> ) <?php } ?></span><span class="fas fa-angle-down ml-2 user-text"></span>
                           </a>
                           <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                               <div class="d-flex no-block align-items-center p-3 mb-2 border-bottom">
                                   <div class=""><img src="assets/images/users/1.jpg" alt="user" class="rounded" width="80"></div>
                                   <div class="ml-2">
                                       <h4 class="mb-0"><?php echo $_SESSION['name']; ?></h4>
                                       <p class=" mb-0 text-muted"><?php echo $_SESSION['uname']; ?></p>
                                       <!-- <a href="javascript:void(0)" class="btn btn-sm btn-danger text-white mt-2 btn-rounded" style="background: #ff8507;border: 1px solid #ff8507;">Change Password</a> -->
                                       <a href="javascript:void(0)" data-toggle="modal" data-target="#change_username" class="btn btn-sm btn-danger text-white mt-2 btn-rounded" style="background: #176FF3;border: 1px solid #176FF3;">Change Email Id</a>
                                   </div>
                               </div>
                               <div class="dropdown-divider"></div>
                               <a class="dropdown-item" href="logout"><i class="fa fa-power-off mr-1 ml-1"></i> Logout</a>
                           </div>
                       </li>
                       <!-- ============================================================== -->
                       <!-- User profile and search -->
                       <!-- ============================================================== -->
                   </ul>
               </div>
           </nav>
       </header>
       <!-- ============================================================== -->
       <!-- End Topbar header -->
       <!-- ============================================================== -->

       <div class="modal fade" id="change_username" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-lg">
               <div class="modal-content">

                   <div class="modal-header">
                       <h4 class="modal-title" id="myModalLabel2">Login / Email Id Change (lntecc to Ltts) - One Time Option</h4>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                       </button>

                   </div>
                   <div class="modal-body">

                       <div class="form-group">
                           <label class="control-label">Old Email Id</label>
                           <input type="text" id="old_uname" class="form-control element" placeholder="Old Username" value="<?php echo $_SESSION['uname']; ?>" readonly><br>
                       </div>
                       <div class="form-group">
                           <label class="control-label">New Email Id</label>
                           <div class="input-group">
                               <input type="text" id="c_uname" class="form-control element" placeholder="New Username"><br>
                               <div class="input-group-btn">
                                   <button class="btn btn-warning element" type="button" id="send_otp" onclick="send_otp();">
                                       Send OTP
                                   </button>
                               </div>
                           </div>
                       </div>
                       <div id="otp_cont">
                           <div class="form-group">
                               <label class="control-label">OTP</label>
                               <input type="text" id="otp" class="form-control element" placeholder="Otp">
                           </div>
                       </div>
                       <center>
                           <p class="passError bg-danger"></p>
                       </center>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                       <button type="button" class="btn btn-primary" onclick="change_uname();">Confirm</button>
                   </div>

               </div>
           </div>
       </div>