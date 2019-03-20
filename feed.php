<?php
//require 'inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
//require 'filtration.php';
require 'checkInformation.php'; 

header("Content-type: text/html; charset=utf-8");

/**
 * Delete the specified label
 *
 * @param array $tags     Deleted tag, array form
 * @param string $str     html string
 * @param bool $content   true Keep the contents of the tags
 * @return mixed
 */
/*
function checkUrl($url){
  	$sql = "SELECT * FROM `Entries` WHERE `url` LIKE '".$url."'";
  	$resultUrl = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
  	while ($row = $resultUrl->fetch_assoc()){
      	if($row['url'] != NULL){
      		return false;
        }else{
          	return true;
        }
    }
}*/
function getFeed($feedId, $categoryFeedId, $url){
	$file = file_get_contents($url);
	$result = new SimpleXMLElement($file);
	$image_url = '';
	$number = 1;
  
  	foreach($result->channel->item as $item){
  		echo '<br><br>Number: ' . $number ++. '<br><br>';
  		echo 'Title: ' . excludeString('-', $item->title, 'right') .'<br>';
  		echo 'Link: ' . $item->link .'<br>';
 		/* echo 'Guid: ' . $item->guid.'<br>';*/
 		 echo 'PubDate: ' . $item->pubDate.'<br>';
  
  		//$description =  trimSpace(stripHtmlTags(['p'], stripHtmlTags(['a', 'font'], $item->description, $content = true), $content = false));
  
  		if(strstr($item->description, '<ol>') && strstr($item->description, '<li>')){
    		$description =  strip_tags($item->description, '<ol><li>');
  		}else{
    		$description =  trimSpace(stripHtmlTags(['p'], stripHtmlTags(['a', 'font'], $item->description, $content = true), $content = false));
  		}
  
  		echo 'Description: ' . $description.'<br>';
  		echo 'Source: ' . $item->source.'<br>';
  		
      	if(isset($item->children('media', true)->content)){
  			echo 'Img: ' . $item->children('media', true)->content->attributes()['url'];
    		$image_url = $item->children('media', true)->content->attributes()['url'];
  		}else{
    		$image_url = 'None';
  		}
  
  		//$sql = "SELECT * FROM `Feed` WHERE `name` LIKE 'Google News - \"strawberry shortcake\"'";

 		// $sql = "SELECT `id` FROM `Feed` WHERE `name` LIKE 'Engadget RSS Feed'";

  
		//$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
	
      	//while ($row = $result->fetch_assoc()){
    		//echo '<br><br>ID:' . $row['id']."<br><br>";
  			//$feedId = $row['id'];
      		//The mysqli_real_escape_string() function escapes special characters in a string for use in an SQL statement.
  			$sqlFeed = "INSERT INTO `nmwdk`.`Entries` (`id`, `category_feed_id`, `feed_id`, `title`, `url`, `author`, `summary`, `content`, `published`, `updated`, `created_at`, `updated_at`, `is_read`, `is_favorite`, `image_url`) VALUES (NULL, '".$categoryFeedId."', '".$feedId."', '".mysqli_real_escape_string(IDB::conn(), excludeString('-', $item->title, 'right')). "', '" .$item->link."', '".mysqli_real_escape_string(IDB::conn(), $item->source)."', '".mysqli_real_escape_string(IDB::conn(), $description)."', '0', '".date('Y-m-d H:i:s',strtotime($item->pubDate))."', NOW(), NOW(), NOW(), '0', '0', '".$image_url."');";
  		
      		if(checkArticleUrl($item->link) == true){
         		 //echo 'old';
        	}else{
          		 mysqli_query(IDB::conn(),$sqlFeed) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
         		 //echo 'new';
        	}
		//}
	}
  	//release web server resources
	//@mysqli_free_result($result);
	//close connection to mysql
	//@mysqli_close(IDB::conn());
}

//getFeed(3, 49, 'https://news.google.com/rss/search?q=computer&hl=en-US&gl=US&ceid=US:en');
?>