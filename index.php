
<?php include 'sideber.php'; 
$sqlEntries = "SELECT * FROM `Entries`";
$resultSqlEntries = mysqli_query(IDB::conn(),$sqlEntries) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
$rowEntriesCount = mysqli_num_rows($resultSqlEntries);

$sqlCategory = "SELECT * FROM `Category`";
$resultSqlCategory = mysqli_query(IDB::conn(),$sqlCategory) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
$rowCategoryCount = mysqli_num_rows($resultSqlCategory);

$sqlEntriesUnread = "SELECT * FROM `Entries` WHERE `is_read` = 0";
$resultSqlEntriesUnread = mysqli_query(IDB::conn(),$sqlEntriesUnread) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
$rowEntriesUnreadCount = mysqli_num_rows($resultSqlEntriesUnread);

$sqlFeed = "SELECT * FROM `Feed`";
$resultSqlFeed = mysqli_query(IDB::conn(),$sqlFeed) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
$rowFeedCount = mysqli_num_rows($resultSqlFeed);
?>

 <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                  <!--
                                    <div class="page-title-right">
                                      
                                        <form class="form-inline">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-light" id="dash-daterange">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-primary border-primary text-white">
                                                            <i class="mdi mdi-calendar-range font-13"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript: void(0);" class="btn btn-primary ml-2">
                                                <i class="mdi mdi-autorenew"></i>
                                            </a>
                                            <a href="javascript: void(0);" class="btn btn-primary ml-1">
                                                <i class="mdi mdi-filter-variant"></i>
                                            </a>
                                        </form>
										
                                    </div>
									-->
                                    <h4 class="page-title"><center>Welcome !</center></h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
						<div class="row">
  							<div class = "col-lg-2">
  							</div>
                            <div class="col-lg-8">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-book-multiple-variant widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Total</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $rowEntriesCount ?></h3>
                                              	<!--
                                                <p class="mb-0 text-muted">
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                                    <span class="text-nowrap">Since last month</span>  
                                                </p>
												-->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-book-plus widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">Unread</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $rowEntriesUnreadCount ?></h3>
                                              	<!--
                                                <p class="mb-0 text-muted">
                                                    <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p>
												-->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-rss-box widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">Category</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $rowCategoryCount ?></h3>
                                                <!--
                                              	<p class="mb-0 text-muted">
                                                    <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p>
												-->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-lg-6">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi mdi-rss widget-icon"></i>
                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Growth">Feed</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $rowFeedCount ?></h3>
                                              	<!--
                                                <p class="mb-0 text-muted">
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                                                    <span class="text-nowrap">Since last month</span>
                                                </p>
												-->
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row -->

                            </div> <!-- end col -->
          
                        </div>

<?php get_footer()?>