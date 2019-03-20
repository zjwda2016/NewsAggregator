<?php
/**
 * admin_login.php is entry point (form) page to administrative area
 *
 * Works with admin_validate.php to process administrator login requests.
 * Forwards user to admin_dashboard.php, upon successful login.
 *
 * 6/4/12 - added session destroy after being passed from logout due to session var 
 * needed for feedback() 
 *
 * @package nmAdmin
 * @author Bill Newman <williamnewman@gmail.com>
 * @author David Wall <dwall@goodroadnetwork.com> 
 * @author Zach Johnson <zjohnson@goodroadnetwork.com> 
 * @version 2.1 2015/04/12
 * @link http://www.goodroadnetwork.com/ 
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see admin_validate.php
 * @see admin_dashboard.php
 * @see admin_logout.php
 * @see admin_only_inc.php     
 * @todo none
 */
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
$config->pageID = 'Admin Login';
$config->titleTag = 'Admin Login'; #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaRobots = 'no index, no follow';#never index admin pages  

//END CONFIG AREA ----------------------------------------------------------
if(startSession() && isset($_SESSION['admin-red']) && $_SESSION['admin-red'] != 'admin_logout.php')
{//store redirect to get directly back to originating page
	$admin_red = $_SESSION['admin-red'];
}else{//don't redirect to logout page!
	$admin_red = '';
}#required for redirect back to previous page
get_header(); #defaults to theme header or header_inc.php
?> 
<div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card">

                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center bg-primary">
                                <a href="index.html">
                                    <span><img src="assets/images/logo.png" alt="" height="18"></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Sign In</h4>
                                    <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                                </div>

                                <form role="form" action="<?=$config->adminValidate?>" method="post">

                                    <div class="form-group">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" type="email" id="em" name="em" id="emailaddress" required="" placeholder="Enter your email" autofocus required>
                                    </div>

                                    <div class="form-group">
                                        <a href="forgot-admin-password.php" class="text-muted float-right"><small>Forgot your password?</small></a>
                                      	<input type="hidden" name="red" value="' . $admin_red . '" />
                                        <input class="form-control" type="password" required="" id="pw" name="pw" placeholder="Enter your password" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                            <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary" type="submit"> Log In </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Don't have an account? <a href="pages-register.html" class="text-muted ml-1"><b>Sign Up</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
		<footer class="footer footer-alt">
            2019 © News Aggregator - p4.zjwda.org
        </footer>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
<?
//get_footer(); #defaults to theme footer or footer_inc.php

if(isset($_SESSION['admin-red']) && $_SESSION['admin-red'] == 'admin_logout.php')
{#since admin_logout.php uses the session var to pass feedback, kill the session here!
	$_SESSION = array();
	session_destroy();	
}
?>
