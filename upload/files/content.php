<?php
	
	if (isset($_COOKIE['user'])){
		
		$user = $_COOKIE['user'];
	
		$json_string = 'data.json';
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
			echo "<div id='main-links'><a href='upload/'  class='main'>Upload/Manage</a><a href='videos/' class='main'>Video Gallery</a><a href='pictures/' class='main'>Picture Gallery</a><a href='javascript:void(0)' onClick='logout();' class='main'>Logout</a></div>";
		} elseif ($perm == '1'){
			echo "<div id='main-links'><a href='videos/' class='main'>Video Gallery</a><a href='pictures/' class='main'>Image Gallery</a><a href='javascript:void(0)' onClick='logout();' class='main'>Logout</a></div>";
		} else {
			echo "This user login has no permissions";
		}
		
	} else {
		die();
	}

?>
