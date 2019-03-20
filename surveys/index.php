<?php
/**
 * demo_list_pager.php along with demo_view_pager.php provides a sample web application
 *
 * The difference between demo_list.php and demo_list_pager.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, demo_view_pager.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package nmPager
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 3.02 2011/05/18
 * @link http://www.newmanix.com/
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see demo_view_pager.php
 * @see Pager.php 
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 

get_header(); #defaults to theme header or header_inc.php
include 'surveys_sideber.php'; 
# SQL statement
//$sql = "select * from wn19_surveys";
$sql = 
"
select CONCAT(a.FirstName, ' ', a.LastName) AdminName, s.SurveyID, s.Title, s.Description, 
date_format(s.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded' from wn19_surveys s, " . PREFIX . "Admin a where s.AdminID=a.AdminID order by s.DateAdded desc
";
#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'Survey';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC280 Class Muffins are made with pure PHP! ' . $config->metaDescription;
$config->metaKeywords = 'Muffins,PHP,Fun,Bran,Regular,Regular Expressions,'. $config->metaKeywords;

//adds font awesome icons for arrows on pager
$config->loadhead .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

?>
<!--<h3 align="center"><?=smartTitle();?></h3>-->
<br><h3 align="center">Survey</h3><br>

<?php
#reference images for pager
//$prev = '<img src="' . $config->virtual_path . '/images/arrow_prev.gif" border="0" />';
//$next = '<img src="' . $config->virtual_path . '/images/arrow_next.gif" border="0" />';

#images in this case are from font awesome
$prev = '<i class="fa fa-chevron-circle-left"></i>';
$next = '<i class="fa fa-chevron-circle-right"></i>';

# Create instance of new 'pager' class
$myPager = new Pager(100,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));


	echo '<div class="row">';
	echo '<div class="col-lg-12">';
	echo '<div class="card">';
	echo '<div class="card-body">';


if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "survey";}else{$itemz = "surveys";}  //deal with plural
    echo '<h4 align="center" class="header-title mb-3">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</h4>';

  	echo '<div class="table-responsive">';
	echo '<table class="table mb-0">';
	echo '<thead class="thead-light">';
	echo '<tr>';
	echo '<th width="33%">Title</th>';
	echo '<th width="33%">Creator\'s Name</th>';
	echo '<th width="33%">Date Created</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
                        	
	while($row = mysqli_fetch_assoc($result))
	{# process each row
      	echo '<tr>';
      	echo '<td><a href="' . VIRTUAL_PATH . 'surveys/surveys_view.php?id=' . (int)$row['SurveyID'] . '">' . dbOut($row['Title']) . '</a></td>';
      	echo '<td>'.$row['AdminName'] . '</td>';
      	echo '<td>'.$row['DateAdded'] . '</td>';
      	echo '</tr>';

	}
  
  	echo '</tbody>';
  	echo '</table>';  
  	echo '</div>';
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
}else{#no records
    echo "<div align=center>There are currently no surveys</div>";	
}
@mysqli_free_result($result);

	echo '</div>';
	echo '</div>';
	echo '</div>'; 
	echo '</div>';

                  
get_footer(); #defaults to theme footer or footer_inc.php
?>
