jQuery(document).ready(function($){

	$('#get_code_but').click( function(){
		get_code_but();
	} )

	$('input[name=option2]').change( function(){
	
		if( $('input[name=option2]:checked').val() == 'yes' ){
			console.log( '--'+$('input[name=option2]:checked').val() );
			$('#content_A').css('visibility', 'visible');
			$('#content_AA').css('visibility', 'visible');
			$('#sign_right').show();
		}else{
			$('#content_A').css('visibility', 'hidden');
			$('#content_AA').css('visibility', 'hidden');
			
			$('#sign_right').hide();
		}
	} )
	
	$('input[name=option3]').change( function(){
	
		if( $('input[name=option3]:checked').val() == 'yes' ){
			console.log( '--'+$('input[name=option2]:checked').val() );
			$('#content_AA').css('visibility', 'visible');
		}else{
			$('#content_AA').css('visibility', 'hidden');
		}
	} )
	
} );

function get_code_but(){
	
	var arr_param = new Array();

	if( jQuery('input[name=auto]:checked').val() == 1 )
		arr_param.push('autoplay=1');

	if( jQuery('input[name=theme]:checked').val() == 'light' )
		arr_param.push('theme=light');
	else
		arr_param.push('theme=dark');
	
	if( jQuery('input[name=keyb]:checked').val() == 1 )
		arr_param.push('disablekb=1');	
	
	if( jQuery('input[name=info]:checked').val() == 0 )
		arr_param.push('showinfo=0');
	
	if( jQuery('input[name=brand]:checked').val() == 1 )
		arr_param.push('modestbranding=1');
		
	if( jQuery('input[name=controls]:checked').val() == 0 )
		arr_param.push('controls=0');
	
	if( jQuery('input[name=ahide]:checked').val() == 0 )
		arr_param.push('autohide=0');
	else
		arr_param.push('autohide=1');
	

	if( jQuery('input[name=cbc]:checked').val() == 'white' )
		arr_param.push('color=white');
	
	if( jQuery('input[name=full]:checked').val() == 'true' ){
		var fullscreen = 'true';
		var allowfullscreen = 'allowfullscreen';
	}else{
		var fullscreen = 'false';
		var allowfullscreen = '';
	}	
	if( jQuery('input[name=loop]:checked').val() == 1 )
		arr_param.push('loop=1');
	else
		arr_param.push('loop=0');	
	
	if( jQuery('input[name=rel]:checked').val() == 0 )
		arr_param.push('rel=0');
		
	if( jQuery('input[name=border]:checked').val() == 1 )
		arr_param.push('modestbranding=1');	
	else	
		arr_param.push('modestbranding=0');	
	
	if( jQuery('input[name=hd]:checked').val() == 1 )
		arr_param.push('hd=1');
	
	// time processing
	var hours = jQuery('#hr').val();
	hours = parseInt(hours);
	
	var mins = jQuery('#minsec').val();
	
	var min_arr = mins.split(':');
	
	var mins = parseInt( min_arr[0] );
	var sec = parseInt( min_arr[1] );
	
	var total_sec = hours*(60*60) + mins*60 + sec;

	arr_param.push('start='+total_sec);
	
	
	
	
	// playlist patch
	if( jQuery('#plist').val() ){
		var pl_list = jQuery('#plist').val();
		var pl_list_ar = pl_list.split("\n");
		console.debug( pl_list_ar );
		var video_ids = new Array();
		
		for( k=0; k < pl_list_ar.length; k++ ){
			var this_val = pl_list_ar[k];
			var pars_arr = this_val.split('=');
			//var cur_len = pars_arr.length;

			video_ids.push( pars_arr[1] );
			
		}
		
		arr_param.push('playlist='+video_ids.join(',') );
		//console.log('--------'+pars_arr.join(','));
	} 
	
	var string_params = arr_param.join('&');
	console.debug( string_params );
	
	// getting vido ID
	
	var cur_str = jQuery('#video_id').val();
	var count = new Array();
	if( cur_str.match(/\?/g) )
		count = cur_str.match(/\?/g); 
	
	
	
	if( count.length > 0 ){
		var str_ar = cur_str.split('?');
		console.debug( str_ar );
		// var query = window.location.search.substring(1);
        var vars = str_ar[1].split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            if (pair[0] == 'v') {
                var vid_id = unescape(pair[1]);
            }
        }
		
	}else{
		var vid_id = jQuery('#video_id').val();
	}
	
	console.log('>>>>>>>'+ vid_id );
	
	var width = jQuery('#sizew').val();
	width = parseInt( width );
	var w_patch = jQuery('#sidem').val();
	w_patch = parseInt( w_patch );
	width = width + w_patch *30;
	
	console.log( width+'   '+w_patch );
	
	var height = jQuery('#sizeh').val();
	height = parseInt( height );
	var h_patch = jQuery('#topbot').val();
	h_patch = parseInt( h_patch );
	height = height + h_patch* 30;
	
	console.log( height +'  '+ h_patch );
	
	// table patches
	var prev_patch = '';
	var aft_patch = '';
	if( jQuery('input[name=option2]:checked').val() == 'yes' ){
		var prev_patch = '<table width="'+width+'" height="'+height+'" border="'+jQuery('#bordersize').val()+'" bordercolor="#'+jQuery('#backcolor').val()+'" BORDERCOLORDARK="black" BORDERCOLORLIGHT ="#'+jQuery('#backcolor').val()+'" align="center" bgcolor="#FFFFFF"><tr><td width="'+width+'" height="'+height+'" align="center" valign="middle" background="'+jQuery('#image').val()+'" bgcolor="#'+jQuery('#backcolor').val()+'"><table width="260" border="0" align="center"><tr><td width="250" align="center"><span><font size="'+jQuery('#titles').val()+'" face="'+jQuery('#font').val()+'" color="#'+jQuery('#titlec').val()+'">'+jQuery('#title').val()+'</font></span></td></tr></table>';
		
		var aft_patch = '<table width="300" border="0"><tr><td width="290" height="" align="center"><span><font size="'+jQuery('#descs').val()+'" face="'+jQuery('#font').val()+'" color="'+jQuery('#descc').val()+'">'+jQuery('#descrip').val()+'</font></span></td></tr><tr><td height="" align="center"></td></tr></table></td></tr></table><br>';
	
	}
	
	var out_str = prev_patch+'<object width="'+jQuery('#sizew').val()+'" height="'+jQuery('#sizeh').val()+'"><param name="movie" value="http://www.youtube.com/v/'+vid_id+'?'+string_params+'"></param><param name="allowFullScreen" value="'+fullscreen+'"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'+vid_id+'?'+string_params+'" type="application/x-shockwave-flash" allowfullscreen="true" width="'+jQuery('#sizew').val()+'" height="'+jQuery('#sizeh').val()+'" allowscriptaccess="always"></embed></object>'+aft_patch;
	
	var iframe = prev_patch+'<iframe width="'+jQuery('#sizew').val()+'" height="'+jQuery('#sizeh').val()+'" src="http://www.youtube.com/embed/'+vid_id+'?'+string_params+'" frameborder="0" '+allowfullscreen+'></iframe>'+aft_patch;
	
	jQuery('#out_code').val( out_str );
	jQuery('#out_code_frame').val( iframe );
	
	jQuery('#prev_cont').html( out_str );
	
}





