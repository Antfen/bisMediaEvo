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
	
		<a href='../' class='home'>Home</a><a href='../videos' class='home'>Video Gallery</a><a href='../pictures' class='home'>Picture Gallery</a><a href='../files' class='home active'>File Download</a>
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
	
				$i=0;
				
				foreach (scandir('.') as $file){
					
					$fileext = explode('.',$file);
					$cnt = count($fileext)-1;
					$fileext = strtolower($fileext[$cnt]);
					
					$ignore = array('.','..');
					
					if (strpos($file, 'TRASH-') === false && !in_array($file, $ignore)){
						
						$fileext = explode('.',$file);
						$cnt = count($fileext)-1;
						$fileext = strtoupper($fileext[$cnt]);
						
						$size = filesize('../files/' .$file);
						$size = round(($size/1024)/1024,2);
						
						if ($i == 1){
							$odd = 'odd';
							$i=0;
						} else {
							$odd = '';
							$i=1;
						}
						
						$list .= "<tr class='".$odd."'><td><b><a href='" .$file. "' download>" .$file. "</a></b></td><td>" .$fileext. "</td><td>".$size."MB</td></tr>";
		
					}
				}
				
			} else {
			
				echo "<h1>Not logged in</h1>";
				
			}
		
		} 
		
		echo '<table id="files"><tr class="title"><td>Filename</td><td>File Type</td><td>Size</td></tr>' .$list. '</table>';

?>

</div>
</body>

</html>
