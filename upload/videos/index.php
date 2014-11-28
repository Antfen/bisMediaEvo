<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="application/javascript; charset=UTF-8">
	<script type='text/javascript' src='http://code.jquery.com/jquery-latest.js'></script>
	<!--<script type='text/javascript' src='../imgen.js'></script>-->
	<link rel="stylesheet" type="text/css" href="../style.css" />
	
	<title>Video Gallery</title>

</head>
<body>

	<div id='wrapper'>
	
		<div id='header'>
			<img src='../banner.jpg'>		
		</div>
	
		<a href='../' class='home'>Home</a><a href='../videos' class='home active'>Video Gallery</a><a href='../pictures' class='home'>Picture Gallery</a><a href='../files' class='home'>File Download</a>
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
		
				echo '<div id="gallery">';
				
				foreach (scandir('.') as $file){
					
					$fileext = explode('.',$file);
					$cnt = count($fileext)-1;
					$fileext = strtolower($fileext[$cnt]);
					
					$vidformats = array('mp4','ogg', 'webm');
					
					if (in_array($fileext, $vidformats) && strpos($file, 'TRASH-') === false){
						
						echo "<video src='" .$file. "' controls></video>";						
					}
				}
				
				echo '</div>';
				
			}  else {
			
				echo "<h1>Not logged in</h1>";
			
			}
			
		}

?>

</div>
</body>

</html>
