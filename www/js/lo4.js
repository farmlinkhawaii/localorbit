core.lo4 = {};

core.lo4.initRemoveSigns=function(){
	$('.prodTotal_text > i.icon-remove-sign').click(function () {
		var jq = $(this);
		var idSplit = jq.parent().attr('id').split('_');
		$('.prodQty_'+idSplit[1]).val(0);
		jq.parent().hide();
		core.catalog.updateRow(idSplit[1], 0);
		//core.catalog.setQty(idSplit[1], 0, 0);
	});
}