	

	$(window).load(function(){
		
		
		var user = getCookie('user');
	
		imgarr = [];
		
		$(".galimg").each(function (){
			var src = $(this).attr('src');
			imgarr.push(src);
		});
	
	});
	

	Object.prototype.getKeyByValue = function( value ) {
		for( var prop in this ) {
			if( this.hasOwnProperty( prop ) ) {
				if( this[ prop ] === value )
				currimg = prop;
			}
		}
	}
	
	function openPreview(image) {
		
		firstrun = getCookie("firstrun");
		
		sscontrol = "<a href='javascript:void(0)' onClick='startSlideshow();' id='play'>Play Slideshow</a><a href='"+image+"' id='play' download>Download</a>";
		var width = $(window).width();
		var height = $(window).height();

		$('#wrapper').append("<div id='preview' style='width: "+width+"px; height: "+height+"px;'><img src='"+image+"' onClick='closePreview();'><a href='javascript:void(0)' onClick='previous();' id='prev'></a>"+sscontrol+"<a href='javascript:void(0)' onClick='next();' id='next'></a></div>");
		
//		if (perm == '2'){
//			$('#preview').append('Delete');
//		}
		
		var imgheight = $('#preview img').height();
		var imgwidth = $('#preview img').width();

		var vmargin = (height - imgheight)/2;	
			
		$('#preview').css("padding-top", vmargin);
		imgarr.getKeyByValue(image);
			
		if(!firstrun){
			
			setCookie('firstrun', 'yes', '360');
			$('#wrapper').append("<div id='preview' class='tip' onClick='closeTip();'>Tap the screen on the right to goto to the next picture<br><br>Tap the screen on the left to goto the previous picture<br><br>Tap the image to go back to the gallery<br><br>Tap this message to remove it</div>");
			
		}
			
	}
	
	function closePreview(){
		$('#preview').remove();
	}
	
	function closeTip(){
		$('.tip').remove();
	}
	
	
	function next(){

		currimg++;
		if (currimg == imgarr.length-1){
			
			$('#preview').html("<img src='"+imgarr[currimg]+"' onClick='closePreview();'><a href='javascript:void(0)' onClick='previous();' id='prev'></a>"+sscontrol);
			$('#play').text('Replay Slideshow');
			$('#play').attr('onClick', 'startSlideshow();');
			sscontrol = "<a href='javascript:void(0)' onClick='startSlideshow();' id='play'>Play Slideshow</a><a href='"+image+"' id='play' download>Download</a>";	
			clearInterval(slideshow);
								
		} else {
			
			$('#preview').html("<img src='"+imgarr[currimg]+"' onClick='closePreview();'><a href='javascript:void(0)' onClick='previous();' id='prev'></a>"+sscontrol+"<a href='javascript:void(0)' onClick='next();' id='next'></a>");	
			
		}	

	}
	
	function previous(){

		currimg--;
		if (currimg == 0){
			$('#preview').html("<img src='"+imgarr[currimg]+"' onClick='closePreview();'><a href='javascript:void(0)' onClick='next();' id='next'></a>"+sscontrol);						
		} else {
			$('#preview').html("<img src='"+imgarr[currimg]+"' onClick='closePreview();'><a href='javascript:void(0)' onClick='previous();' id='prev'></a>"+sscontrol+"<a href='javascript:void(0)' onClick='next();' id='next'></a>");	
		}

	}
	
	function startSlideshow(){
		
		if(currimg == imgarr.length-1){
			currimg = 0;
		}
		
		$('#play').text('Stop Slideshow');
		$('#play').attr('onClick', 'stopSlideshow();');
		sscontrol = "<a href='javascript:void(0)' onClick='stopSlideshow();' id='play'>Stop Slideshow</a><a href='"+image+"' id='play' download>Download</a>";
		slideshow = setInterval(next, 5000);
		
	}
	
	function stopSlideshow(){
		
		$('#play').text('Play Slideshow');
		$('#play').attr('onClick', 'startSlideshow();');
		sscontrol = "<a href='javascript:void(0)' onClick='startSlideshow();' id='play'>Play Slideshow</a><a href='"+image+"' id='play' download>Download</a>";
		clearInterval(slideshow);	
		
	}
	
	
// cookies

	function setCookie(c_name,value,exdays){
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value;
	}

	function getCookie(c_name){
		var c_value = document.cookie;
		var c_start = c_value.indexOf(" " + c_name + "=");
		
		if (c_start == -1){
			c_start = c_value.indexOf(c_name + "=");
		}
		
		if (c_start == -1){
			c_value = null;
		} else {
			c_start = c_value.indexOf("=", c_start) + 1;
			var c_end = c_value.indexOf(";", c_start);
			if (c_end == -1){
				c_end = c_value.length;
			}
			c_value = unescape(c_value.substring(c_start,c_end));
		}
		return c_value;
	}
