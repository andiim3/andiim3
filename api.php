<?
header('Access-Control-Allow-Origin: *');

// Database config
$dbhost="localhost";
$dbname="";
$dbuser="root";
$dbpass="";
//$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// database end

function getRealIPAddr()
   {
       //check ip from share internet
       if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
       {
           $ip = $_SERVER['HTTP_CLIENT_IP'];
       }
       //to check ip is pass from proxy
       elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
       {
           $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
       }
       else
       {
           $ip = $_SERVER['REMOTE_ADDR'];
       }

       return $ip;
   }
function get_data($url)
{
  $ch = curl_init();
  $timeout = 60;
  $userAgents = array(
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36',
        'Mozilla/4.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A',
          'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/534.55.3 (KHTML, like Gecko) Version/5.1.3 Safari/534.53.10',
          'Mozilla/5.0 (iPad; CPU OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko ) Version/5.1 Mobile/9B176 Safari/7534.48.3',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; de-at) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1',
          'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; tr-TR) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; ko-KR) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; fr-FR) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.13 (KHTML, like Gecko) Chrome/24.0.1290.1 Safari/537.13',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.13 (KHTML, like Gecko) Chrome/24.0.1290.1 Safari/537.13',
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.13 (KHTML, like Gecko) Chrome/24.0.1284.0 Safari/537.13',
          'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.6 Safari/537.11',
          'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.6 Safari/537.11',
          'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.26 Safari/537.11',
          'Mozilla/5.0 (Windows NT 6.0) yi; AppleWebKit/345667.12221 (KHTML, like Gecko) Chrome/23.0.1271.26 Safari/453667.1221',
          'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.17 Safari/537.11',
          'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4'
    );
    $rand=rand(0,21);
    $userAgent=$userAgents[$rand];
  curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  curl_setopt($ch, CURLOPT_FAILONERROR, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_REFERER, 'https://google.com/');
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
function get_data_curl($url)
{
  $ch = curl_init();
  $timeout = 3600;
  $userAgent = 'Chrome';
  curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_FAILONERROR, false);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_REFERER, 'https://play.google.com');
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

if(isset($_GET['img'])){
    $apikey="";
    if(isset($_GET['limit'])){$limit=$_GET['limit'];$raw="no";}else{$limit=1;$raw="yes";}
    if(isset($_GET['format'])){$format=$_GET['format'];}else{$format="gif";}
    $q=urlencode($_GET['img']);
    if($format!="loopedmp4"){
        $url="https://api.tenor.com/v1/search?q=$q&key=$apikey&limit=$limit&media_filter=basic";
    }else{
        $url="https://api.tenor.com/v1/search?q=$q&key=$apikey&limit=$limit";
    }
    //apilog("Tenor img", "$_GET[img]", "format:$format;limit:$limit;");
    if($raw=="no"){
        header('content-type: application/json; charset=utf-8');
        echo get_data_curl($url);
    }else{
        $data=json_decode(get_data_curl($url), true);
        if($format=="url"){
            if(isset($data['results'][0]['media'][0]['gif']['url'])){
                echo $data['results'][0]['media'][0]['gif']['url'];
            }else{
                  echo file_get_contents("https://andiim3.com/api/?gif=$q&format=url");
            }
        }
        if($format=="gif"){
            if(isset($data['results'][0]['media'][0]['gif']['url'])){
                header('Content-Type: image/gif');
                echo file_get_contents($data['results'][0]['media'][0]['gif']['url']);
            }else{
                header('Content-Type: image/gif');
                echo file_get_contents("https://andiim3.com/api/?gif=$q");
            }
        }
        if($format=="png"){
            if(isset($data['results'][0]['media'][0]['mp4']['preview'])){
                header('Content-Type: image/png');
                echo file_get_contents($data['results'][0]['media'][0]['mp4']['preview']);
            }else{
                  if(isset($data['status'])){
                    echo "Status: ".$data['status'];
                  }else{echo "NotAvailable";}
            }
        }
        if($format=="mp4"){
            if(isset($data['results'][0]['media'][0]['gif']['url'])){
                header('Content-Type: video/mp4');
                echo file_get_contents($data['results'][0]['media'][0]['mp4']['url']);
            }else{
                  if(isset($data['status'])){
                    echo "Status: ".$data['status'];
                  }else{echo "NotAvailable";}
            }
        }
        if($format=="loopedmp4"){
            if(isset($data['results'][0]['media'][0]['loopedmp4']['url'])){
                header('Content-Type: video/mp4');
                echo file_get_contents($data['results'][0]['media'][0]['loopedmp4']['url']);
            }else{
                  if(isset($data['status'])){
                    echo "Status: ".$data['status'];
                  }else{echo "NotAvailable";}
            }
        }
    }
}
if(isset($_GET['tenor'])){
    $apikey="";
    if(isset($_GET['limit'])){$limit=$_GET['limit'];$raw="no";}else{$limit=1;$raw="yes";}
    if(isset($_GET['format'])){$format=$_GET['format'];}else{$format="gif";}
    $q=urlencode($_GET['tenor']);
    if($format!="loopedmp4"){
        $url="https://api.tenor.com/v1/search?q=$q&key=$apikey&limit=$limit&media_filter=basic";
    }else{
        $url="https://api.tenor.com/v1/search?q=$q&key=$apikey&limit=$limit";
    }
    //apilog("Tenor img", "$_GET[img]", "format:$format;limit:$limit;");
    if($raw=="no"){
        header('content-type: application/json; charset=utf-8');
        echo get_data_curl($url);
    }else{
        $data=json_decode(get_data_curl($url), true);
        if($format=="url"){
            if(isset($data['results'][0]['media'][0]['gif']['url'])){
                echo $data['results'][0]['media'][0]['gif']['url'];
            }else{
                  echo "nourl";
            }
        }
        if($format=="gif"){
            if(isset($data['results'][0]['media'][0]['gif']['url'])){
                header('Content-Type: image/gif');
                echo file_get_contents($data['results'][0]['media'][0]['gif']['url']);
            }else{
                  if(isset($data['status'])){
                    echo "Status: ".$data['status'];
                  }else{echo "UnknownError";}
            }
        }
        if($format=="png"){
            if(isset($data['results'][0]['media'][0]['mp4']['preview'])){
                header('Content-Type: image/png');
                echo file_get_contents($data['results'][0]['media'][0]['mp4']['preview']);
            }else{
                  if(isset($data['status'])){
                    echo "Status: ".$data['status'];
                  }else{echo "UnknownError";}
            }
        }
        if($format=="mp4"){
            if(isset($data['results'][0]['media'][0]['gif']['url'])){
                header('Content-Type: video/mp4');
                echo file_get_contents($data['results'][0]['media'][0]['mp4']['url']);
            }else{
                  if(isset($data['status'])){
                    echo "Status: ".$data['status'];
                  }else{echo "UnknownError";}
            }
        }
        if($format=="loopedmp4"){
            if(isset($data['results'][0]['media'][0]['loopedmp4']['url'])){
                header('Content-Type: video/mp4');
                echo file_get_contents($data['results'][0]['media'][0]['loopedmp4']['url']);
            }else{
                  if(isset($data['status'])){
                    echo "Status: ".$data['status'];
                  }else{echo "UnknownError";}
            }
        }
    }
}
if(isset($_GET['gif'])){
    $apikey="";
    if(isset($_GET['limit'])){$limit=$_GET['limit'];$raw="no";}else{$limit=1;$raw="yes";}
    if(isset($_GET['format'])){$format=$_GET['format'];}else{$format="";}
    $q=urlencode($_GET['gif']);
    //apilog("Giphy gif", "$_GET[gif]", "limit:$limit;");
    $url="https://api.giphy.com/v1/gifs/search?api_key=$apikey&q=$q&limit=$limit&offset=0&rating=r&lang=en";
    $data=json_decode(get_data_curl($url), true);
    $ret=array();
    if($raw=="no"){
        //print_r($data);
        header('content-type: application/json; charset=utf-8');
        $i=0;
        if(isset($data['data'][$i]['images']['original']['url'])){
            while($i<$limit){
                $gif=$data['data'][$i]['images']['original']['url'];
                $gif=str_replace("media1","i",$gif);
                $gif=str_replace("media2","i",$gif);
                $gif=str_replace("media3","i",$gif);
                $gif=str_replace("media4","i",$gif);
                $gif=str_replace("media5","i",$gif);
                $gif=str_replace("media6","i",$gif);
                $gif=str_replace("media7","i",$gif);
                $gif=str_replace("media8","i",$gif);
                $gif=str_replace("media9","i",$gif);
                $gif=str_replace("media0","i",$gif);
                $ret['data'][$i]['gif']=$gif;
                $ret['data'][$i]['url']=$data['data'][$i]['url'];
                $ret['data'][$i]['size']=$data['data'][$i]['images']['original']['size'];
                $ret['data'][$i]['looping']=$data['data'][$i]['images']['looping']['mp4'];
                $ret['data'][$i]['mp4']=$data['data'][$i]['images']['original']['mp4'];
                $ret['data'][$i]['mp4_size']=$data['data'][$i]['images']['original']['mp4_size'];
                $ret['data'][$i]['import_datetime']=$data['data'][$i]['import_datetime'];
                $ret['data'][$i]['title']=$data['data'][$i]['title'];
                $i++;
            }
        }
        $return=json_encode($ret);
        echo $return;
        //print_r($ret);
    }else{
        if(isset($data['data'][0]['images']['original']['url'])){
            $gif=$data['data'][0]['images']['original']['url'];
            $gif=str_replace("media1","i",$gif);
            $gif=str_replace("media2","i",$gif);
            $gif=str_replace("media3","i",$gif);
            $gif=str_replace("media4","i",$gif);
            $gif=str_replace("media5","i",$gif);
            $gif=str_replace("media6","i",$gif);
            $gif=str_replace("media7","i",$gif);
            $gif=str_replace("media8","i",$gif);
            $gif=str_replace("media9","i",$gif);
            $gif=str_replace("media0","i",$gif);
            if($format=="url"){
                if($gif){
                    echo $gif;
                }else {
                    //echo file_get_contents("https://andiim3.com/api/?img=$q&format=url");
                }
            }else{
                if($gif){
                    header('Content-Type: image/gif');
                    echo file_get_contents($gif);
                }else {
                    //header('Content-Type: image/gif');
                    //echo file_get_contents("https://andiim3.com/api/?img=$q");
                }
            }
        }
    }
}
if(isset($_GET['go'])){
	header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Pragma: no-cache');
	$src= basename($_GET['go']);
	header('Content-Disposition: attachment; filename="'.$src.'"');
	header('Content-type: application/vnd.android.package-archive');
	header("Location: $_GET[go]");
}
	
if(isset($_GET['data'])){
	header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Pragma: no-cache');
	
	$src= basename($_GET['data']);
	/*
	if(strpos($src, 'png')){header('Content-type: image/png');}elseif(strpos($src, 'apk')){
	header('Content-Disposition: attachment; filename="'.$src.'"');
	header('Content-type: application/vnd.android.package-archive');
	}else{
		header('content-type: application/json; charset=utf-8');
	}
	*/
    
	echo get_data($_GET['data']);
}
if(isset($_GET['get'])){
	header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Pragma: no-cache');	
	$src= basename($_GET['get']);	
	//apilog("andiim3 data downloader ", "$_GET[get]", "basename:$src;");
	header('Content-Disposition: attachment; filename="'.$src.'"');
	echo get_data($_GET['get']);
}

if(isset($_GET['imglama'])){
    if(isset($_GET['n'])){$n=$_GET['n'];}else{$n=1;}
    
    $url=urlencode($_GET['img']);
    if(strpos($_GET['imglama'], 'http')){$src=$_GET['imglama'];}
    $jpg = strpos($src, 'jpg');
    if ($jpg === false) {
       	$jpeg = strpos($src, 'jpeg');
       	if ($jpeg === false) {
    	   $png = strpos($src, 'png');
    	   if ($png === false) {
    		   $gif = strpos($src, 'gif');
    		   if ($gif === false) {
    			   $gif = strpos($src, 'gif');
    			} else {
    			   $image = @imagecreatefromjpeg($src);
    			}
    		} else {
    		   $image = @imagecreatefrompng($src);
    		}
    	} else {
    	   $image = @imagecreatefromjpeg($src);
    	}
    } else {
       $image = @imagecreatefromjpeg($src);
    }
    if((isset($_GET['notext']))&&($_GET['notext']!="yes")){
        if($_GET['txt']==""){$outtext=$_GET['imglama']." - andiim3.com";}else{$outtext=$_GET[txt];}
        $y=@imagesy($image)-30;
        $x=(@imagesx($image) - 7.5 * strlen($outtext)) / 2;
    
        $color = @imagecolorallocate($image, 110, 110, 110);
        @imagestring($image, 20, $x, $y, $outtext, $color);
        $color = @imagecolorallocate($image, 2, 167, 247);
        $X=$X-1;
        $y=$y-1;
        @imagestring($image, 20, $x, $y, $outtext, $color);
    }
    header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Pragma: no-cache');
    @header('Content-type: image/png');
    @imagepng($image);
    @imagedestroy($image);
}
	
function short($url){
    $username="";
    $apikey="";
    $txt="http://api.bitly.com/v3/shorten?login=$username&apiKey=$apikey&longUrl=$url&format=txt";
    $contents = @file_get_contents($txt);
    return $contents;
}

if((isset($_GET['tipe']))&&($_GET['tipe']=="shorten")){

$longurl=urlencode($_GET['url']);
$username="";
$apikey="";
$txt="http://api.bitly.com/v3/shorten?login=$username&apiKey=$apikey&longUrl=$longurl&format=txt";
$json="http://api.bitly.com/v3/shorten?login=$username&apiKey=$apikey&longUrl=$longurl&format=json";

$contents = @file_get_contents($json);
if (isset($contents) && is_string($contents))
      {
		  header('content-type: application/json; charset=utf-8');
          echo $contents;
      
      } else {
          $contents = @file_get_contents($txt);
          $ar=array();
          $data=array();
          $ar['status_code']="200";
          $data['url']=$contents;
          $data['hash']="";
          $data['global_hash']="";
          $data['long_url']=$_GET['url'];
          $data['new_hash']="";
          $ar['data']=$data;
          $ar['status_txt']="OK, via text method";
          $return=json_encode($ar);
          header('content-type: application/json; charset=utf-8');
          echo $return;
      }

}


   
 function stringInsert($str,$insertstr,$pos)
	{
    $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
    return $str;
	}

   


function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
{
      $result = false;

      $contents = get_data_curl($url);// @file_get_contents($url);

      // Check if we need to go somewhere else

      if (isset($contents) && is_string($contents))
      {
      preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);

      if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
      {
      if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
      {
      return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
      }

      $result = false;
      }
      else
      {
      $result = $contents;
      }
      }

      return $contents;
}
?>