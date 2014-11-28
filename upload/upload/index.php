<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="application/javascript; charset=UTF-8">
	<script type='text/javascript' src='http://code.jquery.com/jquery-latest.js'></script>
	<script type='text/javascript' src='../dropzone.js'></script>
	<link rel="stylesheet" type="text/css" href="../style.css" />
	<title>Gallery Upload</title>
	<script>
	
	$(document).ready(function(){
		
		if ($('#drop').length > 0){
			$("#drop").dropzone({ url: "action.php" });
		}
		
	});
	
	function deleteFile(file){
		
		var filename = file.replace('___', '.');
		console.log(filename);
		$('#'+file).fadeOut('slow');
		$('#blank').load('action.php?p=delete&&f='+filename);
	}
	
	function recoverFile(file){
		
		var filename = file.replace('___', '.');
		console.log(filename);
		$('#'+file).css('background','white');
		$('#'+file+' .dz-size').text('Recovered!');
		$('#blank').load('action.php?p=recover&&f='+filename);
	}
	
	</script>
</head>
<body>

	<div id='wrapper'>
	
		<div id='header'>
			<img src='../banner.jpg'>		
		</div>
	
		
		<a href='../' class='home'>Home</a><a href='../videos' class='home'>Video Gallery</a><a href='../pictures' class='home'>Picture Gallery</a>
		
	
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
			 
		if ($perm == '2'){
			
			echo "<h1>Event Gallery Upload</h1><p>Drag and drop your pictures and videos into the box below. Dragging multiple files will upload them as a batch.
			<p>Supported image formats jpg, jpeg, png, tff, bmp. Please upload Videos in MP4 format.</p><div id='drop' class='dropzone'></div>";
			echo "<h1>Manage Your Uploads</h1><p>You can view file information and also delete your files from here. Please contact the site admin to recover incorrectly deleted files<div class='dropzone'><b>Pictures</b><div class='clear'></div>";
			
			foreach (scandir('../pictures') as $file){
			
				$fileext = explode('.',$file);
				$cnt = count($fileext)-1;
				$fileext = strtolower($fileext[$cnt]);
				
				$picformats = array('crw','cr2','cap','dcs','dcr','dng','drf','eip','erf','fff','iiq','k25','kdc','nef','nrw','rw2','rwz','sr2','srf','srw','jpg','jpeg','png','tff','bmp');
				
				if (strpos($file, $user) !== false && strpos($file, 'TRASH-') === false || in_array($fileext,$picformats) && $user == '3brxZlZdp2y1U'){
					
					$file_parse = str_replace($user. '-', '', $file);
					$file_id = str_replace('.', '___', $file);
					$size = filesize('../pictures/' .$file);
					$size = round(($size/1024)/1024,2);
					
					if (strpos($file, 'TRASH-') !== false){
						$trash = ' grey';
						$delete = '<a href="javascript:void(0)" onClick="recoverFile(\'' .$file_id. '\');">Recover</a>';
					} else {	
						$trash = '';
						$delete = '<a href="javascript:void(0)" onClick="deleteFile(\'' .$file_id. '\');">Delete</a>';
					}
					
					echo '<div id="' .$file_id. '" class="dz-preview dz-processing dz-image-preview dz-success' .$trash. '">
					<div class="dz-details">
						<div class="dz-filename">' .$file_parse. '<br><br>' .$size. 'MB</div>
						<div class="dz-size" data-dz-size>' .$delete. '</div>
						<img data-dz-thumbnail src="../pictures/' .$file. '" alt="' .$file_parse. '"></div></div>';
				}
				
			}
			
			echo "<div class='clear'></div><b>Videos</b><div class='clear'></div>";
			
			foreach (scandir('../videos') as $file){
			
				$fileext = explode('.',$file);
				$cnt = count($fileext)-1;
				$fileext = strtolower($fileext[$cnt]);
				
				$vidformats = array('mp4','webm','mov');
				
				if (strpos($file, $user) !== false && strpos($file, 'TRASH-') === false || in_array($fileext,$vidformats) && $user == '3brxZlZdp2y1U'){
					
					$file_parse = str_replace($user. '-', '', $file);
					$file_id = str_replace('.', '___', $file);
					$size = filesize('../videos/' .$file);
					$size = round(($size/1024)/1024,2);
					
					if (strpos($file, 'TRASH-') !== false){
						$trash = ' grey';
						$delete = '<a href="javascript:void(0)" onClick="recoverFile(\'' .$file_id. '\');">Recover</a>';
					} else {	
						$trash = '';
						$delete = '<a href="javascript:void(0)" onClick="deleteFile(\'' .$file_id. '\');">Delete</a>';
					}
					
					echo '<div id="' .$file_id. '" class="dz-preview dz-processing dz-image-preview dz-success' .$trash. '">
					<div class="dz-details">
						<div class="dz-filename">' .$file_parse. '<br><br>' .$size. 'MB</div>
						<div class="dz-size" data-dz-size>' .$delete. '</div>
						</div></div>';
				}
				
			}
			
			echo "<div class='clear'></div><b>Files</b><div class='clear'></div>";
			
			foreach (scandir('../files') as $file){
			
				$fileext = explode('.',$file);
				$cnt = count($fileext)-1;
				$fileext = strtolower($fileext[$cnt]);
				
				if (strpos($file, $user) !== false && strpos($file, 'TRASH-') === false || $user == '3brxZlZdp2y1U'){
					
					$file_parse = str_replace($user. '-', '', $file);
					$file_id = str_replace('.', '___', $file);
					$size = filesize('../videos/' .$file);
					$size = round(($size/1024)/1024,2);
					
					if (strpos($file, 'TRASH-') !== false){
						$trash = ' grey';
						$delete = '<a href="javascript:void(0)" onClick="recoverFile(\'' .$file_id. '\');">Recover</a>';
					} else {	
						$trash = '';
						$delete = '<a href="javascript:void(0)" onClick="deleteFile(\'' .$file_id. '\');">Delete</a>';
					}
					
					echo '<div id="' .$file_id. '" class="dz-preview dz-processing dz-image-preview dz-success' .$trash. '">
					<div class="dz-details">
						<div class="dz-filename">' .$file_parse. '<br><br>' .$size. 'MB</div>
						<div class="dz-size" data-dz-size>' .$delete. '</div>
						</div></div>';
				}
				
			}

			echo '</div>';
			
		} else {
			echo "<h1>Event Gallery Upload</h1>You do not have permission to view this page";
		}
		
	} else {
		die();
	}

?>

		</div>
		
	</div>
	<div id='blank'></div>
</body>
</html>
