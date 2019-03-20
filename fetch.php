<?php require 'inc_0700/config_inc.php'; ?>
<?php
if(isset($_POST["limit"], $_POST["start"], $_POST["feedId"]))
{
    //error_reporting(0);
  	if($_POST["feedDate"] !== 'Empty'){
    	$sql = "SELECT * FROM Entries WHERE category_feed_id = ".$_POST["feedId"]." AND published LIKE '%". date('Y-m-d',(int)substr($_POST["feedDate"], 0, 10)) ."%' ORDER BY id ASC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
    }else{
  		$sql = "SELECT * FROM Entries WHERE category_feed_id = ".$_POST["feedId"]." ORDER BY id ASC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
    }
    if(IDB::conn())
    {
        	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

            $rowFour = 0;
            $rowFourBack = 1;
            //echo $result;
            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result)){
                 	if($rowFour % 4 == 0)
                    {
                        echo '<div class="row">';
                    } 
					echo '<div class="col-md-6 col-xl-3">';
                    // project card     
                    echo '<div class="card d-block">';
                    // project-thumbnail
                    if($row['image_url'] !== 'None'){
                        echo '<img class="card-img-top" src="'. $row['image_url'] .'" height="200" alt="project image cap">';
                    }else{
                        echo '<img class="card-img-top" src="themes/Hyper/assets/images/projects/project-'.mt_rand(1,4).'.jpg" height="200" alt="project image cap">';
                    }
                    echo '<div class="card-img-overlay">';
                    echo '<div class="badge badge-secondary p-1">';
                  	
                  	if($row['is_read'] == 0){
                      echo '<i class="mdi mdi-star"></i>';
                    }else{
                      echo '<i class="mdi mdi-star" style="color:gold"></i>';
                    }
                  	
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="card-body position-relative">';
                    // project title
                    echo '<h4 class="mt-0">';
                    if(mb_strlen($row['title']) < 31 ){
                        echo '<a href="'. $row['url'] .'" class="text-title">'. $row['title'] .'</a><br><br><br>';
                    }elseif(mb_strlen($row['title']) < 62 ){
                        echo '<a href="'. $row['url'] .'" class="text-title">'. $row['title'] .'</a><br><br>';
                    }else{
                        echo '<a href="'. $row['url'] .'" class="text-title">'. iconv_substr($row['title'],0,80,'UTF-8') .'</a>';
                    }
      
                    echo '</h4>';
                    if(mb_strlen($row['summary']) < 76 ){
                        echo '<p class="text-muted font-13 mb-3">'.  $row['summary'] .'<a href="' . $row['url'] . '" class="font-weight-bold text-muted">view more</a>';
                        echo '<br><br>';
                    }else{
                        echo '<p class="text-muted font-13 mb-3">'.  iconv_substr($row['summary'],0,100,'UTF-8') .'<a href="' . $row['url'] . '" class="font-weight-bold text-muted">view more</a>';
                    }
                    
                    echo '</p>';
                    // project detail
                    echo '<p class="mb-3">';
                    echo '<span class="pr-2 text-nowrap">';
                    echo '<i class="mdi mdi-timetable"></i>';
                    echo '<b>'. date("D, d M Y", strtotime($row['published'] )).'</b>';
                    echo '</span>';
                    echo '<span class="text-nowrap">';
                    echo '<br><i class="mdi mdi-source-branch"></i>';
                    echo '<b>'. $row['author'] .'</b>';
                    echo '</span>';
                    echo '</p>';
                    echo '<a href="' . $row['url'] . '" target="view_window"><button id="button-id" type="button" class="btn btn-primary" value="' . $row['id'] . '" onclick="isReadFunction(this)">Read more</button></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                   	if($rowFourBack % 4 == 0)
                    {
                        echo '</div>'; 
                    } 
              
                    $rowFour ++;
                    $rowFourBack ++;
                }  
            }
        
            //echo '</div>';
			
    }
    else
    {
        echo '<p>Connection Problem...';
    }
}

?>

