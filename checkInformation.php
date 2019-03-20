<?
//require 'inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 

function checkArticleUrl($url){
  	$sql = "SELECT * FROM `Entries` WHERE `url` LIKE '".$url."'";
  	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	while ($row = $result->fetch_assoc()){
      	if($row['url'] != NULL){
      		return true;
        }else{
          	return false;
        }
    }
}

function checkFeedName($feedName){
  	$sql = "SELECT * FROM `Feed` WHERE `name` LIKE '".$feedName."'";
  	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	while ($row = $result->fetch_assoc()){
      	if($row['name'] != NULL){
      		return true;
        }else{
          	return false;
        }
    }
}

function checkFeedUrl($url){
  	$sql = "SELECT * FROM `Feed` WHERE `feed_url` LIKE '". $url ."'";
  	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	while ($row = $result->fetch_assoc()){
      	if($row['feed_url'] != NULL){
      		return true;
        }else{
          	return false;
        }
    }
}
?>