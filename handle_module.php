<?php 
require 'inc_0700/config_inc.php';

function deleteFeeds($getFeedId){
	$sqlEntries = "DELETE FROM Entries WHERE category_feed_id=".$getFeedId."";
  	$sqlFeed = "DELETE FROM Feed WHERE id=".$getFeedId."";
  
  	$sqlFixEntriesIdAutou = "ALTER TABLE Entries AUTO_INCREMENT = 1";
    $sqlFeedIdAuto = "ALTER TABLE Feed AUTO_INCREMENT = 1";
  	mysqli_query(IDB::conn(),$sqlEntries) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	mysqli_query(IDB::conn(),$sqlFeed) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  
  	mysqli_query(IDB::conn(),$sqlFixEntriesIdAutou) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	mysqli_query(IDB::conn(),$sqlFeedIdAuto) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	
}


function isRead($id){
	$sqlIsId = "UPDATE `nmwdk`.`Entries` SET `is_read` = '1' WHERE `Entries`.`id` = ".$id."";
  	mysqli_query(IDB::conn(),$sqlIsId) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
}

if(isset($_POST['action'])) {
  deleteFeeds($_POST['action']);
}

if(isset($_POST['id'])) {
  isRead($_POST['id']);
}
?>