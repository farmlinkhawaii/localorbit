jQuery(function($){
	$(document).ready(function($) {

	// colorpicker field
	$('.ts-color-picker').each(function(){
		var $this = $(this),
			id = $this.attr('rel');

		$this.farbtastic('#' + id);
	});
	$('.ts-color-select').click(function(){
		$parent = $(this).parent();
		$(this).siblings('.ts-color-picker').toggle();
		$('.ts-color-select', $parent).toggle();
		return false;
	});
		
	//upload image
	jQuery('.ms-upload-button').live( 'click', function(){
		
		var inputID = $(this).prev().attr('id'), postID = $('#post_ID').val();
			
		window.send_to_editor = function(html) 
		
		{
			imgurl = jQuery('img',html).attr('src');
			jQuery('#' + inputID).val(imgurl);
			tb_remove();
		}
		
		tb_show('', 'media-upload.php?post_id='+ postID +'&amp;type=image&amp;TB_iframe=true');
		return false;
	
	});
	
	//toggle open/close slide
	$(".ts-ms-toggle").live( 'click', function(){
	
		var msbody = $(this).parent();
		msbody.toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
		
	});	
	
	//add new slide
	$(".ts-ms-add-new").live('click', function(){
	
		var mscontainer = $(this).prev();
		var mscontainerID = mscontainer.attr('id');
		var mssecurity = mscontainer.find('input.ms_nonce').attr('id');
		
		var numArr = $('#'+mscontainerID  +' li').map(function() { 
			var str = this.id;
			str = str.substring(str.length - 2, str.length);
			str = parseFloat(str);
			return str;			
		}).get();
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var data = {
			action: 'add_new_meta_slide',
			id: mscontainerID,
			num: newNum,
			security: mssecurity
		};
	
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajaxurl, data, function(response) {
		
			mscontainer.append(response);
			
		});
		
		return false;
	
	});
	
	
	//delete slide
	$(".ts-ms-delete").live('click', function(){
		
		var $trash = $(this).parent().parent();
		$trash.fadeOut(500,function(){ $(this).remove(); });
		return false;
	
	});
	
/*=====================================
 CHANGE EACH THEME
=======================================*/
	$("[name=ts_slide_type]").change(function(){
		var name = 'ts_slide_type';
		var value = $(this).val();
		var postid = $(this).attr('postid');
		
		var data = {
			action: 'content_for_filter_select',
			name: name,
			postid: postid,
			value: value,
		};
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajaxurl, data, function(response) {
			$(".ts_filterselect").html(response);
			//mscontainer.append(response);
		});
		return false;
	});
		$("[name=ts_slide_type]").load(function(){
		var name = 'ts_slide_type';
		var value = $(this).val();
		var postid = $(this).attr('postid');
		alert(postid);
		var data = {
			action: 'content_for_filter_select',
			name: name,
			postid: postid,
			value: value,
		};
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajaxurl, data, function(response) {
			
			$(".ts_filterselect").html(response);
			//mscontainer.append(response);
		});
		return false;
	});
	//sort slides
	
	
	
	
/*=====================================
END CHANGE EACH THEME
=======================================*/
	ts_sortms();
	function ts_sortms() {	
		jQuery('.meta-slides').each( function() {
			var id = jQuery(this).attr('id');
			$('#'+ id).sortable({
				placeholder: "placeholder",
				opacity: 0.6
			});
		});	
	}
	
	}); //end doc ready
}); //end main function