<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="application/javascript; charset=UTF-8">
	<script type='text/javascript' src='http://code.jquery.com/jquery-latest.js'></script>
	<script type='text/javascript' src='../imgen.js'></script>
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
	<title>Picture Gallery</title>

</head>
<body>

	<div id='wrapper'>
	
		<div id='header'>
			<img src='../banner.jpg'>		
		</div>
	
		<a href='../' class='home'>Home</a><a href='../videos' class='home'>Video Gallery</a><a href='../pictures' class='home active'>Picture Gallery</a><a href='../files' class='home'>File Download</a>
		<div class='clear'></div>
		<div id='content'>

<?php

		if (isset($_COOKIE['user'])){
		
			$user = $_COOKIE['user'];
		
			$json_string = '../data.json';
			$jsondata = file_get_contents($json_string);
			$user_data = json_decode($jsondata, true);
			
			echo "<pre>";
			//print_r($user);
			echo "</pre>";
			
			for ($i = 0; $i < count($user_data); $i++){
				// echo $user_data[$i]['e']. ' ' .$user. '<br>';
				if ($user_data[$i]['e'] == $user){
					$perm = $user_data[$i]['pm'];
				}
			}	
				
			if ($perm == '2' || $perm == '1'){
	
				$row = 0;
				
				foreach (scandir('.') as $file){
					
					$fileext = explode('.',$file);
					$cnt = count($fileext)-1;
					$fileext = strtolower($fileext[$cnt]);
					
					$picformats = array('jpg','jpeg','png','bmp','gif');
					
					if (in_array($fileext, $picformats) && strpos($file, 'TRASH-') === false){
						
						$rand = rand(0, 4);
		
						if ($rand == 1 && $row == 0 && $feature == 0){
		
							$list .= "<div class='img-container-big-l' onClick='openPreview(\"" .$file. "\");'><img src='" .$file. "' class='galimg'></div>\n";
							$row = -1;
							$feature = 1;
						
						//	$list .= "<div class='img-container' onClick='openPreview(\"" .$file. "\");'><img src='" .$file. "' class='galimg'></div>\n";
		
						} elseif ($rand == 2 && $row == 2 && $feature == 0){
		
						//	$list .= "<div class='img-container-big-r' onClick='openPreview(\"" .$file. "\");'><img src='" .$file. "' class='galimg'></div>\n";
						//	$row = -3;
						//	$feature = 1;
		
							$list .= "<div class='img-container' onClick='openPreview(\"" .$file. "\");'><img src='" .$file. "' class='galimg'></div>\n";
		
						} elseif ($rand == 3 && $row == 0 && $feature == 0){
		
							$list .= "<div class='img-container-wide' onClick='openPreview(\"" .$file. "\");'><img src='" .$file. "' class='galimg'></div>\n";
							$row = -1;
							
						} elseif ($rand == 4 && $row == 0 && $feature == 0 || $rand == 4 && $row == 1 && $feature == 0 || $rand == 4 && $row == 2 && $feature == 0){
							
							$list .= "<div class='img-container-double' onClick='openPreview(\"" .$file. "\");'><img src='" .$file. "' class='galimg'></div>\n";
							$row = -3;
							$feature = 1;
		
						} else {
		
							$list .= "<div class='img-container' onClick='openPreview(\"" .$file. "\");'><img src='" .$file. "' class='galimg'></div>\n";
		
						}
						
						if ($row == 3){
							$row = 0;
							$feature = 0;
						} else {
							$row++;
						}
								
					}
				}
				
			} else {
			
				echo "<h1>Not logged in</h1>";
				
			}
		
		} 
		
		echo '<div id="gallery">' .$list. '</div>';

?>

</div>
</body>

</html>
