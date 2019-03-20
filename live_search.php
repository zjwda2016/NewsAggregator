<?php 
require 'inc_0700/config_inc.php';
require 'checkInformation.php'; 	
include 'capture_feed.php'; 


//setcookie ( "language", null, time () - 3600 * 24 * 365 );
//setcookie ( "data", null, time () - 3600 * 24 * 365 );

//Replace all characters except letters, numbers, spaces, and underscores
function replaceLetNumSpaUnd($string){
  	return preg_replace("/[^0-9a-zA-Z_\s]+/", "", $string);
}

function mergeSpaces($string){
	return preg_replace("/\s(?=\s)/","\\1",$string);
}

function replaceEmpty($str){
		$str = str_replace('　', ' ', $str); //Replace the full-width space with a half-width
		//$str = str_replace('  ', ' ', $str);    //Replace the consecutive spaces to one space
		$noe = false;   //Whether  characters that are not spaces
		for ($i = 0; $i < strlen($str); $i ++){ //Traversing the entire string
			if($noe && $str[$i] == ' '){
              $str[$i] = '+';   //Replace the space to +
            }elseif($str[$i] != ' '){
              $noe=true;    //The current character is not a space, define the $noe variable
            }
		}
		return $str;
}

if($_COOKIE['language'] == 1){
	$resultSpaces = mergeSpaces(replaceLetNumSpaUnd($_GET['q']));
	$result = replaceEmpty($resultSpaces);
}else{
  	$resultSpaces = mergeSpaces(($_GET['q']));
  	$result = urlencode(replaceEmpty($resultSpaces));
}



// test 
//echo 'lang: '.$_COOKIE['language'];
$lang = $_COOKIE['language'];

function getLanguageZone($language){
    switch ($language) :
      	case  1: return 'hl=en-US&gl=US&ceid=US:en';
        case  2: return 'hl=zh-CN&gl=CN&ceid=CN:zh-Hans';
        case  3: return 'hl=fr&gl=FR&ceid=FR%3Afr';
    endswitch;
}

$url = "https://news.google.com/rss/search?q=". $result."&". getLanguageZone($lang)."";
//echo $url;
echo '<br>';
//output the response
//echo $url;

?>
<!-- Portlet card -->
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-xs-3 col-sm-2">
            	<img src="themes/Hyper/assets/images/g-logo.png" alt="google logo" width="64" height="64">
          	</div>
  			
          	<div class="col-md-8">
            	<h5 class="card-title mb-0"><?php 
  						if($lang == 1){
  						echo ucwords($resultSpaces);
  					}else{
    					echo mergeSpaces(($_GET['q']));
  					}
                  ?></h5>
                <p><font size="3" color="#dbdbdb">news.google.com</font></p>
              	<p><font size="2"><?php 
  						if($lang == 2){
  							echo '在世界顶级新闻出版物中提及 ' . mergeSpaces(($_GET['q'])).' 的是:';
  						}else{
                          echo 'Track mentions of ' . $resultSpaces.' across the world\'s top news publications';
    					
  					}
                  ?> </font></p>
          	</div>
          <div class="col col-lg-2">
            <!--<button type="button" class="btn btn-outline-primary">Follow</button>-->
            
            	<div class="btn-group">
                  <?php 
                      if(checkFeedUrl($url) == true){
         		 			echo '<button type="button" class="btn btn-outline-success">Following</button>';
        			  }else{
          		 	  		echo '<button type="button" class="btn btn-outline-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Follow</button>';
        			  }
                  ?>    
  					<div id="demolist" class="dropdown-menu">
					<?php
						$sqlCategory = "SELECT * FROM `Category`";
						$resultCategory = mysqli_query(IDB::conn(),$sqlCategory) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));                      

						if(mysqli_num_rows($resultCategory) > 0){
  							while($row = mysqli_fetch_assoc($resultCategory)){
  								echo '<li><a class="mdi mdi-signal-variant dropdown-item" id="link" href="#'.$row['id'].'">&nbsp;&nbsp;'.$row['category_name'].'&nbsp;&nbsp;&nbsp;&nbsp;</a></li>';
                            }
                        }
                      ?>
    			
    					<div class="dropdown-divider"></div>
    						<a class="mdi mdi-shape-rectangle-plus dropdown-item" href="#">&nbsp;&nbsp;NEW FEED&nbsp;&nbsp;&nbsp;&nbsp;</a>
  						</div>
					</div>
          		</div>
      		
		</div>
      <div id="cardCollpase1" class="collapse pt-3 show">
    <?php showTheFeed($url); ?>
               	</div>
    </div>
</div> <!-- end card-->


<script>
var feedUrl = <?php echo json_encode($url) ?>;

$('#demolist li').on('click', "a", function(){
  //$('#datebox').val($(this).text());
  var categoryId = $(this).attr('href').replace('#','');
  
  $.ajax({
            url:"follow_feed.php",
            method:"POST",
            data:{categoryId:categoryId,feedUrl:feedUrl},
            cache:false,
            success:function(data)
            {
                alert(data);
            }
    });
  alert("Subscription successfully");
  location.reload();

});
 
</script>
