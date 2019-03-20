<?php
require 'inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
require 'filtration.php';
require 'feed.php';
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');
function getFeedTitle($url){ 
	$file = file_get_contents($url);

	$result = new SimpleXMLElement($file);

	foreach($result->channel as $item){
  
  		$leftString = excludeString('-', $item->title, 'left');
  		$rightString = excludeString('-', $item->title, 'right');
  		$newTitle = $leftString . ' - ' . $rightString;
  		return $newTitle;
	}
}

function getFeedDescription($url){
  	$file = file_get_contents($url);

	$result = new SimpleXMLElement($file);
	
  	foreach($result->channel as $item){
      	$description = $item->description;
    }

  	return $description;
}

function getFeedLastBuildDate($url){
  	$file = file_get_contents($url);

	$result = new SimpleXMLElement($file);
	
	foreach($result->channel as $item){
      	$lastBuildDate = date('Y-m-d H:i:s',strtotime($item->lastBuildDate));
    }
  	return $lastBuildDate;
}


function writeFeedInDatabase($categoryId, $name, $url, $description, $lastBuildDate){
  
	$sql = "INSERT INTO `nmwdk`.`Feed` (`id`, `category`, `name`, `feed_url`, `website_url`, `description`, `created_at`, `updated_at`, `last_modified`, `subscriptions_count`) VALUES (NULL, '".$categoryId."', '".$name."', '".$url."', '".parse_url($url, PHP_URL_HOST)."', '".$description."', '".$lastBuildDate."', NOW(), NOW(), '0');";
  	mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
}


function createTable($categoryId){
  
  $entries = 'entries' . $categoryId;
  $sql = "CREATE TABLE IF NOT EXISTS `".$entries."` (
  `id` int(11) NOT NULL,
  `feed_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `url` text NOT NULL,
  `author` text,
  `summary` text,
  `content` text,
  `published` timestamp NOT NULL,
  `updated` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_favorite` tinyint(1) NOT NULL DEFAULT '0',
  `image_url` text
) ENGINE=InnoDB AUTO_INCREMENT=1779 DEFAULT CHARSET=utf8mb4;"; 
}

function dropTable($categoryId){
  $entries = 'entries' . $categoryId;
  $sql = "DROP TABLE `".$entries."`";
}

//$uurl = "https://news.google.com/rss/search?q=computer&hl=en-US&gl=US&ceid=US:en";  
//echo getFeedTitle($uurl). '<br>';
//echo getFeedDescription($uurl). '<br>';
//echo getFeedLastBuildDate($uurl). '<br>';
//echo parse_url($uurl, PHP_URL_HOST);

$categoryId = $_POST['categoryId'];
$uurl = $_POST['feedUrl'];

function findCategoryFeedId($uurl){
	$sql = "SELECT * FROM `Feed` WHERE `feed_url` LIKE '".$uurl."'";
  	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	while ($row = $result->fetch_assoc()){
      	return $row['id'];
    }
}
writeFeedInDatabase($categoryId, getFeedTitle($uurl), $uurl, getFeedDescription($uurl), getFeedLastBuildDate($uurl));
getFeed($categoryId, findCategoryFeedId($uurl), $uurl);


function followTheFeed($iddd){
  echo $iddd;
}
   
//echo $categoryid = $_GET['categoryid'];
//writeFeedInDatabase(3, getFeedTitle($uurl), $uurl, getFeedDescription($uurl), getFeedLastBuildDate($uurl));
?>