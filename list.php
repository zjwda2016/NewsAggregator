<?php include 'sideber.php'; ?>
<?php
if(isset($_GET["feedid"]) || isset($_GET["categoryid"])){
	$getFeedId = $_GET["feedid"];
	$getCategoryId = $_GET["categoryid"];
  	$sqlFeedid = "SELECT * FROM `Category` WHERE `id` = ".$getCategoryId."";
  	$resultFeedid = mysqli_query(IDB::conn(),$sqlFeedid) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
    $resultFeedidd = mysqli_query(IDB::conn(),$sqlFeedid) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

  	$sqlFeedName = "SELECT * FROM `Feed` WHERE `id` = ".$getFeedId."";
  	$resultFeedName = mysqli_query(IDB::conn(),$sqlFeedName) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	$resultFeedNamee = mysqli_query(IDB::conn(),$sqlFeedName) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	//about auto scroll, count the nunber of row
  	if(isset($_GET["date"])){
    	$sqlCount = "SELECT * FROM `Entries` WHERE `category_feed_id` = '".$getFeedId."' AND published LIKE '%". date('Y-m-d',(int)substr($_GET["date"], 0, 10)) ."%' ORDER BY id ASC LIMIT ".$_GET["start"].", ".$_GET["limit"]."";
      	$resultSqlCount = mysqli_query(IDB::conn(),$sqlCount) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  		$rowCount = mysqli_num_rows($resultSqlCount);
    }
}

?>

<div class="row " >
	<div class="col-12">
    	<div class="page-title-box">
        	<div class="page-title-right">
            	<form class="form-inline">
                	<div class="form-group">
                    	<div class="input-group">
                          <!--
                        	<input type="text" class="form-control form-control-light" id="dash-daterange">
						-->
                          		<input type="text" name="chooseDate" class="form-control form-control-light" value="<?php if(isset($_GET["date"])){echo date('m-d-Y',(int)substr($_GET["date"], 0, 10));} ?>" />

                            	<div class="input-group-append">
                                	<span class="input-group-text bg-primary border-primary text-white">
                                   		<i class="mdi mdi-calendar-range font-13"></i>
                                    </span>
                                </div>
                        </div>
                   </div>
                   <!--<a href="javascript: void(0);" class="btn btn-primary ml-2">-->
                  	<a href="list.php?categoryid=<?php echo $_GET["categoryid"]; ?>&feedid=<?php echo $_GET["feedid"]; ?>" class="btn btn-primary ml-2">
                   		<i class="mdi mdi-autorenew"></i>
                   </a>
                  <!--
                   <a href="javascript: void(0);" class="btn btn-primary ml-1">
                   		<i class="mdi mdi-filter-variant"></i>
                   </a>
                  -->

  					<button class="btn btn-primary ml-1" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    						<i class="mdi mdi-filter-variant"></i>
 					</button>
  					
                  	<button type="button" class="btn btn-icon btn-danger ml-1" data-toggle="modal" data-target="#exampleModalCenter"> <i class="mdi mdi-window-close"></i> </button>
                  	
                  	<!-- Modal -->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  							<div class="modal-dialog modal-dialog-centered" role="document">
    							<div class="modal-content">
      								<div class="modal-header">
        								<h5 class="modal-title" id="exampleModalLongTitle">Remove <?php 
                                          if(isset($_GET["feedid"])){
               							  		while($row = mysqli_fetch_assoc($resultFeedName)){
													echo $row['name'];
               									}
                                          }
                                          ?> From <?php echo $_GET["feedid"] ?> feed?</h5>
        								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          									<span aria-hidden="true">&times;</span>
        								</button>
      								</div>
      								<div class="modal-body">
        								It will be removed from
                                      	<?php
               							if(isset($_GET["feedid"])){
               								while($row = mysqli_fetch_assoc($resultFeedid)){
												echo $row['category_name'];
               								}
               							}
          								?>
      								</div>
      								<div class="modal-footer">
        								<button type="button" class="btn btn-danger" onclick="removeFunction()">YES, REMOVE</button>
        								<button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
      								</div>
    							</div>
  							</div>
						</div>
                  
                </form>
             </div>
             <h2 class="page-title">
               <ol class="breadcrumb">
           	<?php
               if(isset($_GET["feedid"])){
               		while($row = mysqli_fetch_assoc($resultFeedidd)){
						echo '<li class="breadcrumb-item"><a href="javascript: void(0);">'.$row['category_name'].'</a></li>';
               		}
					//release web server resources
					@mysqli_free_result($resultFeedidd);
  					//close connection to mysql
               	}
          	?>
                 <?php
               if(isset($_GET["feedid"])){
               		while($row = mysqli_fetch_assoc($resultFeedNamee)){
						echo '<li class="breadcrumb-item active">'.$row['name'].'</li>';
               		}
					//release web server resources
					@mysqli_free_result($resultFeedNamee);
  					//close connection to mysql
                 	@mysqli_close(IDB::conn());
               }
          	?>
               </ol>
               
            </h2>
          </div>
    </div>
</div>

<?php if(isset($_GET["feedid"])){ ?>
	  <div id="load_data"></div>
      
      <div id="load_data_message"></div>
<?php } ?>
<script src="themes/Hyper/assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
  
//The JavaScript function below parses and returns the parameters of the url.
function getUrlVars(){
    	var vars = {};
    	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value){
        	vars[key] = value;
    	});
    	return vars;
}
function getUrlParam(parameter, defaultvalue){
  	var urlparameter = defaultvalue;
    if(window.location.href.indexOf(parameter) > -1){
        urlparameter = getUrlVars()[parameter];
    }
    return urlparameter;
}
var feedId = getUrlVars()["feedid"];
var categoryId = getUrlVars()["categoryid"];
var feedDate = getUrlParam('date','Empty');
var limit = 8;
var start = 0;

$(document).ready(function(){
    
    var action = 'inactive';
    String.prototype.isNullOrWhiteSpace = function() { return (!this || this.length === 0 || /^\s*$/.test(this)) }
    
    function load_country_data(limit, start)
    {
        $.ajax({
            url:"fetch.php",
            method:"POST",
            data:{limit:limit,start:start, feedId:feedId, feedDate:feedDate},
            cache:false,
            success:function(data)
            {
                $('#load_data').append(data);
                if(data.isNullOrWhiteSpace()<?php if(isset($_GET["date"])){echo '||' .$rowCount. '< 4';}?>)
                {
                    $('#load_data_message').html("<p class='text-center'><h2'>END OF FEED</h2></p>");
                    action = 'active';
                }else{
                    $('#load_data_message').html("<div class='d-flex justify-content-center'><div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>");
                    action = "inactive";
                }
            }
        });
    }

    if(action == 'inactive')
    {
        action = 'active';
        load_country_data(limit, start);
    }
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
        {
            action = 'active';
            start = start + limit;
            setTimeout(function(){
                load_country_data(limit, start);
            },300);
        }
    });
    
       
});
</script>

<script>
$(function(){
  	$('input[name="chooseDate"]').daterangepicker({
    	singleDatePicker: true,
  	}, function(date) {
    	window.location.href = 'list.php?categoryid='+ categoryId +'&feedid=' + feedId + '&date=' + date + '&start=' + start + '&limit=' + limit;
  	});
});
  
function removeFunction() {
  $.ajax({
           type: "POST",
           url: 'handle_module.php',
           data:{action:feedId},
           success:function(html) {
             alert("Success");
             window.location.href="index.php";
           }

      });
}
</script>
<script>
function isReadFunction(objButton) {
  var id = objButton.value;
  $.ajax({
           type: "POST",
           url: 'handle_module.php',
           data:{id:id},
           success:function(html) {
             location.reload();
           }

      });
}
</script>
<?php get_footer()?>