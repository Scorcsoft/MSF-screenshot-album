<?php
	session_start();
	ini_set('session.gc_maxlifetime', 10);
	ini_set("session.cookie_lifetime",10);
	error_reporting(0);
	
	function getPass(){
		$pass = "admin";//your password here
		return $pass;
	}
	if ($_SESSION['login'] != 'y'){
		date_default_timezone_set('PRC');
		if (!isset($_GET['p'])){
			exit();
		}

		$pass = getPass();
		if ($_GET['p'] == $pass){
			$_SESSION['login'] = 'y';
		}
		else{
			exit();
		}
	}

	if(isset($_GET['a'])){
		if ($_GET['a'] == 'logout'){
			session_destroy();
			exit();
		}
	}


	$path = "/Users/brain"; //msf screenshot file path

	if (isset($_GET['path']) && is_dir($_GET['path'])){
		$path = $_GET['path'];
	}

	if (isset($_GET['img']) && is_file($path.'/'.$_GET['img'])){
		$tmp = explode(".",$_GET['img']);
		if (end($tmp) != "jpeg"){
			exit();
		}
        $img = $path.'/'.$_GET['img'];
        $info = getimagesize($img);
        $imgExt = image_type_to_extension($info[2], false); 
        $fun = "imagecreatefrom{$imgExt}";
        $imgInfo = $fun($img); 
        $mime = image_type_to_mime_type(exif_imagetype($img));
        header('Content-Type:'.$mime);
        $quality = 1;
        if($imgExt == 'png') $quality = 9;
        if(isset($_GET['q'])) $quality = 100;
        $getImgInfo = "image{$imgExt}";
        $getImgInfo($imgInfo, null, $quality);
        imagedestroy($imgInfo);
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>msf Screenshot</title>
	<meta charset="utf-8">
</head>
<body>
	<hr>
	<div style="text-align: center">
		<font style="user-select: none">
			Scorcsoft MSF Screenshot Album <font style="font-size: 8px">(共 <font id="n">0</font> 张图片)</font>
			<a style="color:#000000;font-size:14px;float:left;" href="?a=logout">退出登录</a>
		</font>
		<hr>
		<br>
		<div style="width: 80%;padding-left: 10%">
			<table id="imgTable" style="width: 100%;font-size: 12px;">
				<?php
					$file=scandir($path);
					$i = 1;//记录当前行已显示多少张图片
					$n = 1;//记录已显示多少张原图
					$l = 4;//控制每一行显示多少张图片
					$h = 2;//控制显示前多少张显示原图
					$image_list = [];
					foreach ($file as $key => $value) {
						$tmp = explode(".",$value);
						if (end($tmp) == "jpeg"){
							$a = filemtime($path.'/'.$value);
							$k = date("Y-m-d H:i:s",$a);
							$image_list[$a] = [$k,$value];
						}
					}
					$image = krsort($image_list,1);
					//print_r($image_list);
					foreach ($image_list as $value) {
						if ($i == 1){
							if ($n != 1){
								echo "\t\t\t\t";
							}
							echo "<tr>\n";
						}
							echo "\t\t\t\t\t<td>\n";
						if ($n <= $h){
							echo "\t\t\t\t\t\t<a id=\"a_".$value[1]."\" href=\"?img=".$value[1]."&q=\">\n";
							echo " \t\t\t\t\t\t\t<img id=\"img_".$value[1]."\" src=\"?img=".$value[1]."\" style=\"height:108px;\">\n";
						}
						else{
							echo "\t\t\t\t\t\t<a id=\"a_".$value[1]."\" href=\"javascript:loadImg('".$value[1]."')\">\n";
							echo "\t\t\t\t\t\t\t<img id=\"img_".$value[1]."\" src=\"load.jpg\" style=\"height:108px;\">\n";
						}

							echo "\t\t\t\t\t\t</a>\n\t\t\t\t\t\t<br>\n\t\t\t\t\t\t<font>".$value[0]."</font>\n";
							echo "\t\t\t\t\t</td>\n";

						if($i == $l){
							echo "\t\t\t\t</tr>\n";
							$i = 0;
						}

						$i++;
						$n++;
					}
					echo "\t\t\t\t</tr>\n";

					
				?>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		function loadImg(url){
			document.getElementById("img_" + url).src="?img=" + url;
			document.getElementById("a_" + url).href="?img=" + url + "&q=";
		}
		<?php echo 'document.getElementById("n").innerHTML = "'.($n-1).'";';?>
		
	</script>
</body>
</html>


