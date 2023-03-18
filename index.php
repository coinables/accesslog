<?php
E_ALL & ~E_NOTICE;
//$conn = mysqli_connect("127.0.0.1", "root", "", "test");

function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }

$fn = fopen("test.txt","r");

$duplicateArray = [];
$duplicateURLs = [];
$countHits = 0;
$botCounter = 0;
 
  while(! feof($fn))  {
	$countHits++;
	$result = fgets($fn);
	if($countHits==1){
		$timeFrom = explode("[",$result);
		$timeFromEnd = explode("+",$timeFrom[1]);
		$startTime = $timeFromEnd[0];
	}
	
	$splitSpaces = explode(" ",$result);
	
	$ipp = $splitSpaces[0];
	
	//find type
	//] "GET 
	
	$splitType = explode('"',$result);
	
	
	if(str_contains($result,"?q=")){
		$splitGetQ = explode("?q=",$result);
		$splitGetQEnd = explode('"',$splitGetQ[1]);
		$txid = $splitGetQEnd[0];
		
		//echo $txid."<br>";
	
	}
	
	if(str_contains($result,"robots.txt")){
		$botCounter++;
		
		//echo $txid."<br>";
	
	}
	
	if(str_contains($result,"http")){
		$splitURL = explode("http",$result);
		$splitURLEnd = explode('"',$splitURL[1]);
		$url = $splitURLEnd[0];
		//echo $url."<br>";
		
		if(in_array($url,$duplicateURLs)){
			
		} else {
			array_push($duplicateURLs,$url);
		}
	}
		
	
	
	if(in_array($ipp,$duplicateArray)){
		//duplicate do nothing
	} else {
		//new IP echo out and add to array
		array_push($duplicateArray, $ipp);
		//echo $ipp."<br>";
	}
	
	
     
	
	
  }
  echo "From: ".$startTime."<br>";
  echo "<div style='display: inline-block; border: 2px solid #1e1e1e; margin: 2px; padding: 12px; font-size: 32px;'>".$countHits." Hits</div>";
  echo "<div style='display: inline-block; border: 2px solid #1e1e1e; margin: 2px; padding: 12px; font-size: 32px;'>".count($duplicateArray)." Unique Vistors</div>";
  echo "<div style='display: inline-block; border: 2px solid #1e1e1e; margin: 2px; padding: 12px; font-size: 32px;'>".$botCounter." Bots</div>";
  echo "<br><br>";
  echo "<table><tr><td>";
  echo "<table><tr><td><h4>IP Addresses</h4></td></tr>";
  foreach($duplicateArray as $thisIP){
	  echo "<tr><td>".$thisIP."</td></tr>";
  }
  echo "</table>";
  echo "</td><td style='vertical-align: top;'>";
   echo "<table><tr><td><h4>Pages</h4></td></tr>";
  foreach($duplicateURLs as $thisURL){
	  echo "<tr><td>http".$thisURL."</td></tr>";
  }
  echo "</table>";
  echo "</td></tr></table>";
  fclose($fn);
  
  
?>