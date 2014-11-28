<?php
	
	if (isset($_COOKIE['user'])){
		
		$user = $_COOKIE['user'];
	
		$json_string = '../data.json';
		$jsondata = file_get_contents($json_string);
		$user_data = json_decode($jsondata, true);
		
		for ($i = 0; $i < count($user_data); $i++){
			// echo $user_data[$i]['e']. ' ' .$user. '<br>';
			if ($user_data[$i]['e'] == $user){
				$perm = $user_data[$i]['pm'];
			}
		}	
		
		if ($perm == '2'){
			
			if (isset($_GET['p'])){
			
				$p = $_GET['p'];
				
				if (isset($_GET['f'])){
					
					$file = $_GET['f'];
					
					if ($p == 'delete' && $file != null){
						
						if (file_exists('../pictures/' .$file)){
							$file_path = '../pictures/' .$file;
							$file_trash = '../pictures/TRASH-' .$file;
						} else {
							$file_path = '../videos/' .$file;
							$file_trash = '../videos/TRASH-' .$file;
						}
						
						if (strpos($file, $user) !== false || $user == '3brxZlZdp2y1U'){
							rename($file_path, $file_trash);
							// echo 'Trashed!';
						}
					}
					
					if ($p == 'recover' && $file != null){
						
						if (file_exists('../pictures/' .$file)){
							$file_path = '../pictures/' .$file;
							$file_trash = str_replace('TRASH-','',$file);
							$file_trash = '../pictures/' .$file_trash;
						} else {
							$file_path = '../videos/' .$file;
							$file_trash = str_replace('TRASH-','',$file);
							$file_trash = '../videos/' .$file_trash;
						}
						
						if (strpos($file, $user) !== false || $user == '3brxZlZdp2y1U'){
							rename($file_path, $file_trash);
							echo 'Recovered!';
						}
					}
					
				}
				
				die();
				
			}
			
			$fileext = explode('.',$_FILES['file']['name']);
			$cnt = count($fileext)-1;
			$fileext = strtolower($fileext[$cnt]);
			
			$picformats = array('crw','cr2','cap','dcs','dcr','dng','drf','eip','erf','fff','iiq','k25','kdc','nef','nrw','rw2','rwz','sr2','srf','srw','jpg','jpeg','png','tff','bmp');
			$vidformats = array('mp4','ogg', 'webm');
			
			if (in_array($fileext, $picformats)){
				$uploaddir = '../pictures/';
			} elseif (in_array($fileext, $vidformats)){
				$uploaddir = '../videos/';
			} else {
				die();
			}
			
			$file_parse = str_replace(' ', '_', $_FILES['file']['name']);
			$uploadfile = $uploaddir . basename($user.'-'.$file_parse);
			
			echo '<pre>';
			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			    echo "File is valid, and was successfully uploaded.\n";
			} else {
			    echo "Possible file upload attack!\n";
			}
			
			echo 'Here is some more debugging info:';
			print_r($_FILES);
			
			print "</pre>";
			
		} else {
			
			die();
			
		}
		
	} else {
		
		die();
		
	}
		
?>