<?php
//require 'includes/config.php'; #provides configuration, pathing, error handling, db credentials 
require 'filtration.php'; 
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
function stripHtmlTags($tags, $str, $content = true)
{
    $html = [];
    // Whether to retain the text characters in the tag
    if($content){
        foreach ($tags as $tag) {
            $html[] = '/(<' . $tag . '.*?>(.|\n)*?<\/' . $tag . '>)/is';
        }
    }else{
        foreach ($tags as $tag) {
            $html[] = "/(<(?:\/" . $tag . "|" . $tag . ")[^>]*>)/is";
        }
    }
    $data = preg_replace($html, '', $str);
    return $data;
}

function trimSpace($str){
    $trimResult = array("&nbsp;");
    return str_replace($trimResult, '', $str);  
}

*/
//$file = file_get_contents("https://news.google.com/rss/search?q=computer&hl=en-US&gl=US&ceid=US:en");


function showTheFeed($url){
  	
  	$file = file_get_contents($url);
  	$result = new SimpleXMLElement($file);
  	$number = 0;
	echo '<ul style="list-style-type:disc;">';
	foreach($result->channel->item as $item){
  		$number ++;
  		echo '<li>' . excludeString('-', $item->title, 'right') .'</li>';
      	if($number == 3){
        	break;
        }
	}
  	echo '</ul>';
}

?>