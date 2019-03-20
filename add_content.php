<?php include 'sideber.php'; ?>

<!-- default the language when the paga loaded-->


<div class="row">
  <div class="col-lg-2">
   <div class="card-body">
   </div>
</div>
<div class="col-lg-9 mt-3 mt-lg-0">
  <div class="card-body">
    <h4 class="header-title mb-3">Subscription</h4>

    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a href="#keyword" data-toggle="tab" aria-expanded="false" class="nav-link active">
          <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
          <span class="mdi mdi-google mdi-24px"> Keyword alerts</span>
        </a>
      </li>
                
      <li class="nav-item">
        <a href="#websites" data-toggle="tab" aria-expanded="true" class="nav-link">
          <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
            <span class="mdi mdi-webpack mdi-24px"> Websites</span>
        </a>
      </li>
    </ul>
    
    <div class="tab-content">
      <div class="tab-pane show active" id="keyword">
        <div class="row">
  			<div class="col-xs-12 col-sm-6 col-md-8">
            	<div class="form-group mb-3">
                  <label>&nbsp;&nbsp;What brand, company, or keyword do you want to follow?</label>
                  	<form>
				  		<input style="height:50px" type="text" id="bloodhound" class="form-control"  placeholder="keyword..." onkeydown="if(event.keyCode==13){return false;}">
                      <div id="load_data_m"></div>
						<div id="livesearch"></div>
					</form>
          		</div>
          	</div>
  			<div class="col-xs-6 col-md-4">
              <label>&nbsp;&nbsp;Resulits language</label>
              <form>
  			  		<select style="height:50px" class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="select" onchange="setLanguage(this.value)">
    					<option value="1" selected>English</option>
        	 			<option value="2">中文</option>
        		 		<option value="3">Français</option>
  					</select>
			  </form>

              <!--
            	<select style="height:50px" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
        	 		<option value="1" selected>English</option>
        	 		<option value="2">中文</option>
        		 	<option value="3">Français</option>
      	  		</select>
-->
          	</div>
		</div>
      </div> <!-- end col -->
                        
       <div class="tab-pane" id="websites">
          <p>Websites</p>
       </div>
     </div>
   </div>
</div>
</div>

<script>

function showResult(str){

  if(str.length==0){ 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if(window.XMLHttpRequest){
    //code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }else{  //code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function(){
    if(this.readyState==4 && this.status==200){
      document.getElementById("livesearch").innerHTML=this.responseText;
      	var myDivScript = document.getElementById("livesearch").getElementsByTagName("SCRIPT").item(0); 
	  	var newScript = document.createElement("SCRIPT"); 

		newScript.innerHTML = myDivScript.innerHTML; 

		document.getElementsByTagName("HEAD").item(0).appendChild(newScript); 
      //document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  
  xmlhttp.open("GET","live_search.php?q="+str,true);
  xmlhttp.send();
}
 
  
var showThekeyword, timer;

window.onload = function()
{
	//default language to English
  	defaultLanguage();
  	
  	showThekeyword = document.getElementById("bloodhound");
	showThekeyword.onkeyup = function()
	{
		if(timer) {
        	window.clearTimeout(timer);
			$('#load_data_m').html("<br><div class='d-flex justify-content-center'><div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>");
        }

		timer = window.setTimeout(function(){
          	showResult(showThekeyword.value); 
          	$('#load_data_m').html("");
        }, 500);
      	

	}
}

function setLanguage(str){
  setCookie("language", str, 365);
}

</script>
<script>
function getCookie(cname)
{
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i=0; i<ca.length; i++) 
  {
    var c = ca[i].trim();
    if (c.indexOf(name)==0) return c.substring(name.length,c.length);
  }
  return "";
}
function setCookie(cname,cvalue,exdays)
{
  var d = new Date();
  d.setTime(d.getTime()+(exdays*24*60*60*1000));
  var expires = "expires="+d.toGMTString();
  document.cookie = cname + "=" + cvalue + "; " + expires;
}
function remCookie(cname)
{
  document.cookie = cname + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}  
  
// default language
function defaultLanguage(){
  setCookie("language", 1,365);
}


</script>

<?php get_footer()?>