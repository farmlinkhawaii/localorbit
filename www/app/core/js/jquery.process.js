(function($) {
	$.fn.process = function() {
		
		var a=0;
		var procId = $(this).attr('id');
		
		var lastSpan;
		$(this).children('span').each(function(){
			
			$(this).attr('id',procId+'_a'+a);
			if(a==0){
				$(this).prepend('<img id="'+procId+'_0" class="process_arrow" src="/lo3/img/process/start_on.png" />');
				$(this).addClass('process_step_on');
			}
			else if(a==1)
				$(this).prepend('<img id="'+procId+'_1" class="process_arrow" src="/lo3/img/process/middle_0.png" />');
			else
				$(this).prepend('<img id="'+procId+'_'+a+'" class="process_arrow" src="/lo3/img/process/middle_1.png" />');
			$(this).click(Function('','$.fn.process.changeSteps(\''+procId+'\','+a+');'));
			a++;
			lastSpan = $(this);
		});
		if(lastSpan){
		lastSpan.append('<img id="'+procId+'_end" class="process_arrow" src="/lo3/img/process/end_off.png" style="float:right;" />');
			$.fn.process.processes[procId] = {
				cur:0,
				last:a
			}
		}
		
		var a=0;
		$(this).children('div').each(function(){
			if(a==0)
				$(this).show();
			$(this).attr('id',procId+'_s'+a);
			a++;
		});

	};
	$.fn.process.processes={};
	
	$.fn.process.changeSteps=function(id,nbr){
		var cur = $.fn.process.processes[id].cur;
		if($('#'+id+'_s'+cur))
			$('#'+id+'_s'+cur).hide();
		$('#'+id+'_a'+cur).removeClass('process_step_on');
		if(cur==0){
			$('#'+id+'_'+cur).attr('src','/lo3/img/process/start_off.png');
		}else{
			$('#'+id+'_'+cur).attr('src','/lo3/img/process/middle_1.png');
		}
		$('#'+id+'_'+(cur + 1)).attr('src','/lo3/img/process/middle_1.png');
		$.fn.process.processes[id].cur = nbr;
		if($('#'+id+'_s'+nbr))
			$('#'+id+'_s'+nbr).show();
		
		$('#'+id+'_a'+nbr).addClass('process_step_on');
		if(nbr==0){
			$('#'+id+'_'+nbr).attr('src','/lo3/img/process/start_on.png');
		}else{
			$('#'+id+'_'+nbr).attr('src','/lo3/img/process/middle_2.png');
		}
		$('#'+id+'_'+(nbr + 1)).attr('src','/lo3/img/process/middle_0.png');
		if(nbr+1 == $.fn.process.processes[id].last)
			$('#'+id+'_end').attr('src','/lo3/img/process/end_on.png');
		else
			$('#'+id+'_end').attr('src','/lo3/img/process/end_off.png');

	}
})(jQuery);