<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="application/javascript; charset=UTF-8">
	<script type='text/javascript' src='http://code.jquery.com/jquery-latest.js'></script>
	<title>Gallery</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type='text/javascript'>
	
		$(document).ready(function(){
		
			var str = 'uPloader_2';
		
			$.getJSON('crypt.php?callback=?','str='+str,function(res){
				var s_crypt = JSON.parse(res.session_crypt);
			//	console.log(s_crypt);
			});
			
			user = getCookie('user');
			
			if (user != ''){
				
				$('#login').remove();
				$('#content').load('content.php');			
			
			}
			
		});	
		
		function login(){
	
			var email = $('#email').val();
			var password = $('#password').val();
						
			$.getJSON('crypt.php?callback=?','str='+email,function(res){
				var e_crypt = JSON.parse(res.session_crypt);
				// console.log(e_crypt);
				$.getJSON('crypt.php?callback=?','str='+password,function(res){
					var p_crypt = JSON.parse(res.session_crypt);
					// console.log(p_crypt);
					
					$.getJSON('data.json', function(data){
					
						
						for(var i=0; i < data.length; i++){
						
							if (data[i].e == e_crypt && data[i].p == p_crypt){
								setCookie('user', e_crypt, 30);
								location.reload();
							} else {
								$('#email').css('background','#E68881');
								$('#password').css('background','#E68881');
							}	
						
						}
						
					
					});
					
				});
				
			});
		
		}	
		
		function logout(){
		
			setCookie('user', '', 1);
			location.reload();
		
		}
		
		function addUpload(){
			alert('Upload');
		}
		
		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*60*60*24));
			var expires = "expires="+d.toUTCString();
			document.cookie = cname + "=" + cvalue + "; " + expires;
		}
		
		function getCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(';');
			for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
			}
			return "";
		}
		
	
	</script>
	
	
	
</head>
<body>

	<div id='wrapper'>
	
		<div style="max-width:491px;margin:35px auto 0 auto;height:auto;" id='header'>
			<img src='bis_and_society_logos.jpg' width="491" height="95">		
		</div>
	
		<div id='login'>
		<p>...</p>
			<input type='text' id='email' placeholder='username'>
			<input type='password' id='password' placeholder='password'>
			<button onClick='login();' id='button-login'>Login</button>
		</div>
	
		<div id='content'>
		
		</div>
		
	</div>

</body>
</html>


