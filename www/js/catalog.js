core.catalog={
	filters:{
		seller:0,
		cat1:0,
		cat2:0,
		priceType:0,
		cartOnly:0,
		dd:0
	},
	addressCoords:{
	},
	popupOn:0,
	popupType:0
};

core.catalog.resetFilters=function(){
	core.catalog.filters={
		seller:0,
		cat1:0,
		cat2:0,
		priceType:0,
		cartOnly:0,
		dd:0
	};
	$('.filtercheck').attr('checked','checked');
	$('.filter_subcat').removeClass('subheader_off');
	$('.filter').removeClass('active');
	$('#filter_list').empty();
	core.catalog.updateListing();
	$('#weekly_special').show();
}

core.catalog.hideSpecial=function(){
	//core.doRequest('/catalog/hide_special');
	$('#weekly_special').hide();
}

core.catalog.setFilter=function(type,id,parentId,updateListing){
	var newfilter;
	$('#weekly_special').hide();
	if(arguments.length <4)
		updateListing=true;
	switch(type){
		case 'cat1':
			core.catalog.filters.cat1 = (core.catalog.filters.cat1 == id)?0:id;
			// any change in cat1 state necessitates a change in the cat2 filter
			core.catalog.filters.cat2 = 0;
			$('.filter_subcat').removeClass('subheader_off');
			if(core.catalog.filters.cat1==0){
				$('.filtercheck').attr('checked',true);
				$('#filter_cat_'+id).removeClass('active');
				$('#filter_list .cat1_' + id).remove();
			}else{
				$('.filtercheck').attr('checked',false);
				$('#filtercheck_'+core.catalog.filters.cat1).attr('checked',true);
				$('#filter_list .cat1').remove();
				newfilter = $('<li class="cat1 cat1_' + id + '"><i class="icon-remove-sign"/>' + $('#filter_cat_'+id).attr('data-name') + '</li>').appendTo($('#filter_list'));
				$('.filter.category').removeClass('active');
				$('#filter_cat_'+id).addClass('active');
			}
			break;
		case 'cat2':
			core.catalog.filters.cat2 = (core.catalog.filters.cat2 == id)?0:id;
			if(core.catalog.filters.cat2 > 0){
				$('.filtercheck[id!=\'filtercheck_'+parentId+'\']').attr('checked',false);
				core.catalog.filters.cat1 = parentId;
				$('.filter_subcat_of_'+parentId).addClass('subheader_off');
				$('#filter_subcat_'+id).removeClass('subheader_off');
			}else{
				$('.filter_subcat').removeClass('subheader_off');
			}
			break;
		case 'seller':
			// change filter state. if this seller filter was already set, set state to 0 (off)
			core.catalog.filters.seller = (core.catalog.filters.seller == id)?0:id;
			if(core.catalog.filters.seller == 0){
				// if we were turning off the filter, turn all on
				$('.filter_org').removeClass('subheader_off');
				$('#filter_list .org_' + id).remove();
				$('#filter_org_'+id).removeClass('active');
			}else{
				// otherwise JUST turn on this selelr filter, turn the rest off
				$('.filter_org').addClass('subheader_off');
				$('#filter_org_'+id).removeClass('subheader_off');
				$('#filter_list .seller').remove();
				newfilter = $('<li class="seller org_' + id + '"><i class="icon-remove-sign"/>' + core.sellers[id][0].name+ '</li>').appendTo($('#filter_list'));
				$('.filter.seller').removeClass('active');
				$('#filter_org_'+id).addClass('active');
			}
			break;
		case 'pricetype':
			break;
		case 'dd':
			core.catalog.filters.dd = (core.catalog.filters.dd == id)?0:id;
			if(core.catalog.filters.dd == 0){
				// if we were turning off the filter, turn all on
				$('.filter_dd').removeClass('subheader_off');
				$('#filter_list .dd_' + id).remove();
				$('#filter_dd_'+id).removeClass('active');
			}else{
				updateListing = false;
				core.catalog.confirmDeliveryDateChange(true);
				//$('.prodDd').val(id);
			}
			break;
		case 'cartOnly':
			core.catalog.filters.cartOnly = (core.catalog.filters.cartOnly == 1)?0:1;
			$('#continueShoppingButton1,#continueShoppingButton2')[((core.catalog.filters.cartOnly == 1)?'show':'hide')]();
			$('#showCartButton1,#showCartButton2')[((core.catalog.filters.cartOnly == 0)?'show':'hide')](300);
			break;
	}

	if (newfilter) {
		newfilter.click(function () {
			var classes = $(this).attr('class').split(/\s+/);
			var id = classes[1].split('_')[1];
			core.catalog.setFilter(classes[0], id);
		});
	}
	//core.alertHash(core.catalog.filters);
	if(updateListing)
		core.catalog.updateListing();
}

core.catalog.modalPopup = function () {
	var text = $.trim($('#filter_dd_' + core.catalog.filters.dd).text());
	$('#modalDeliveryDate').text(text);
	$('#deliveryDateModal').modal();
}

core.catalog.confirmDeliveryDateChange = function (confirmed) {
	var fdds = core.catalog.filters.dd.split('_');
	if (confirmed)
	{
		$('.product-row').each(function () {
			var jq = $(this);
			var prodQtyJq = jq.find('.prodQty');
			var prodQty = $.trim(prodQtyJq.val());
			var prodId = $(this).attr('id').split('_')[1];
			var text = $.trim($('#filter_dd_' + core.catalog.filters.dd).text());
			if (prodQty !== '' && prodQty !== '0') {
				var dds = jq.find('.prodDdSet').val().split('_');
				var isValid = false;
				$.each(dds, function () {
					isValid = ($.inArray(this.toString(), fdds) >= 0);
					if (isValid) {
						return false;
					}
				});
				if (isValid) {
					jq.find('.dd_selector').text(text);
					jq.find('.prodDd').val(core.catalog.filters.dd);
					//core.catalog.updateRow(prodId, prodQtyJq.val());
				}
			} else {
				var dds = jq.find('.prodDdSet').val().split('_');
				var isValid = false;
				$.each(dds, function () {
					isValid = ($.inArray(this.toString(), fdds) >= 0);
					if (isValid) {
						return false;
					}
				});
				if (isValid) {
					jq.find('.dd_selector').text(text);
					jq.find('.prodDd').val(core.catalog.filters.dd);
				}
			}
		});
		var text = $.trim($('#filter_dd_' + core.catalog.filters.dd).text());
		$('.filter_dd').addClass('subheader_off');
		$('#filter_dd_'+core.catalog.filters.dd).removeClass('subheader_off');
		$('#filter_list .dd').remove();
		newfilter = $('<li class="dd dd_' + core.catalog.filters.dd + '"><i class="icon-remove-sign"/>' + text + '</li>').appendTo($('#filter_list'));
		$('.filter.dd').removeClass('active');
		$('#filter_dd_'+core.catalog.filters.dd).addClass('active');
		newfilter.click(function () {
			var classes = $(this).attr('class').split(/\s+/);
			var id = classes[1].split('_')[1];
			core.catalog.setFilter(classes[0], id);
		});
		core.catalog.updateListing();
	}
}

core.catalog.updateListing=function(){

	// loop through all categories and toggle off show if neceesary
	core.thingsToShow    = [];
	core.thingsToHide    = [];
	core.thingsToShowS   = [];
	core.thingsToHideS   = [];
	core.thingsToFadeIn  = [];
	core.thingsToFadeOut = [];
	var catsToShow={};

	// set all products to show
	for (var i = 0; i < core.products.length; i++){
		core.products[i].show = true;
	}

	// determine which products to show or hide
	prodVisible = false;
	for (var i = 0; i < core.products.length; i++){

		if(core.catalog.filters.cartOnly == 1){
			//alert(document.cartForm['prodQty_'+core.products[i].prod_id].value);
			if(document.cartForm['prodQty_'+core.products[i].prod_id]){
				if(
					parseInt(document.cartForm['prodQty_'+core.products[i].prod_id].value) == 0
					||
					document.cartForm['prodQty_'+core.products[i].prod_id].value == ''
					||
					isNaN(document.cartForm['prodQty_'+core.products[i].prod_id].value)
				){
					core.products[i].show = false;
					//alert('going to hide  '+core.products[i].prod_id);
				}else{
					//alert('going to keep showing '+core.products[i].prod_id);
				}
			}else{
				//alert('going to hide  '+core.products[i].prod_id);
				core.products[i].show = false;
			}
		}else{
			// apply seller filter
			if(core.catalog.filters.seller > 0 && core.products[i].org_id != core.catalog.filters.seller)
				core.products[i].show = false;
			// apply the cat1 filter if necessary
			if(core.catalog.filters.cat1 > 0 && (!core.lo3.inArray(core.products[i].category_ids,core.catalog.filters.cat1)))
				core.products[i].show = false;
			// apply the cat2 filter if necessary
			if(core.catalog.filters.cat2 > 0 && (!core.lo3.inArray(core.products[i].category_ids,core.catalog.filters.cat2)))
				core.products[i].show = false;

			if(core.catalog.filters.dd !== 0 && !(core.catalog.matchesDeliveryDay(core.catalog.filters.dd, core.products[i]))) {
				core.products[i].show = false;
			}
		}


		// add this element to the list of things to hide
		if(core.products[i].show){

			// remember the fact that there is at least one prod visible. Used for no product msgs
			prodVisible = true;

			// add this product an its catgories to the list of things to show
			core.thingsToShow.push('#product_'+core.products[i].prod_id);
			catsToShow[core.products[i].category_ids[1]] = true;

			// if there are many levels to this product hierarchy, use the 4th index for the sub cat
			// (0== base cat, 1 == root cat, 2 == 1st sub cat, 3 == 2nd sub cat)
			// otherwise, use the 3rd index.
			if(core.products[i].category_ids.length > 3)
				catsToShow[core.products[i].category_ids[3]] = true;
			else
				catsToShow[core.products[i].category_ids[2]] = true;
		}else{
			core.thingsToHide.push('#product_'+core.products[i].prod_id);
		}
	}

	// determine which categories to show or hide
	for(var key in core.categories){
		for (var i = 0; i < core.categories[key].length; i++){
			core.categories[key][i].show = true;
			if(key == 2){
				core['thingsTo'+((catsToShow[core.categories[key][i].cat_id])?'Show':'Hide')].push('#start_cat1_'+core.categories[key][i].cat_id);
				core['thingsTo'+((catsToShow[core.categories[key][i].cat_id])?'Show':'Hide')].push('#end_cat1_'+core.categories[key][i].cat_id);
			}else{
				core['thingsTo'+((catsToShow[core.categories[key][i].cat_id])?'Show':'Hide')].push('#start_cat2_'+core.categories[key][i].cat_id);
				core['thingsTo'+((catsToShow[core.categories[key][i].cat_id])?'Show':'Hide')].push('#end_cat2_'+core.categories[key][i].cat_id);
			}


			// only affect showing of subcats
			if(key != 2){
				// if this cat does NOT belong to the cat1 fitler, just hide it
				if(core.catalog.filters.cat1 > 0 && core.catalog.filters.cat1 != core.categories[key][i]['parent_id']){
					core.categories[key][i].show=false;
				}
			}
			core['thingsTo'+((core.categories[key][i].show)?'ShowS':'HideS')].push('#filter_subcat_'+core.categories[key][i].cat_id)
		}
	}

	// if there are no products at all visible,
	if(!prodVisible){
		// if its because the cart filter is on but there are no products in cart, use one msg.
		if(
			core.catalog.filters.cartOnly == 1
			&& core.catalog.filters.seller==0
			&& core.catalog.filters.cat1==0
			&& core.catalog.filters.cat2==0
			&& core.catalog.filters.priceType==0
		){
			core.thingsToHide.push('#no_prods_msg');
			core.thingsToShow.push('#cart_empty_msg');
		}
		// otherwise, use the other msg
		else{
			core.thingsToShow.push('#no_prods_msg');
			core.thingsToHide.push('#cart_empty_msg');
		}
	}else{
		core.thingsToHide.push('#no_prods_msg');
		core.thingsToHide.push('#cart_empty_msg');
	}

	// perform all changes
	core.catalog.popupOff();
	$(core.thingsToShow.join(',')).show();
	$(core.thingsToHide.join(',')).hide();
	$(core.thingsToShowS.join(',')).show(300);
	$(core.thingsToHideS.join(',')).hide(300);
	$(core.thingsToFadeIn.join(',')).fadeIn(300);
	$(core.thingsToFadeOut.join(',')).fadeOut(100);



	//core.ui.scrollTop();
}

core.catalog.matchesDeliveryDay=function(deliveryDays, product) {
	var a = deliveryDays.split('_').sort();
	var b = product.dd_ids.split(',').sort();
	while( a.length > 0 && b.length > 0 )
	{
		if      (a[0] < b[0] ){ a.shift(); }
		else if (a[0] > b[0] ){ b.shift(); }
		else /* they're equal */
		{
		  return true;
		}
	}
	return false;
}

core.catalog.initCatalog=function(){
	core.addHandler('onrequest',core.catalog.closeAllPopups);
	core.prodIndex={};
	for (var i = 0; i < core.products.length; i++){
		core.products[i].show = true;
		core.products[i].category_ids = new String(core.products[i].category_ids).split(',');
		core.prodIndex[core.products[i]['prod_id']] = core.products[i];
		core.catalog.addressCoords[core.products[i].address+', '+core.products[i].city+', '+core.products[i].code+', '+core.products[i].postal_code] = true;
	}

	// build a cache of all the coordinates for the addresses for each product
	for(var key in core.catalog.addressCoords){
		core.ui.getLatLng(
			key,
			'core.catalog.setAddressCache(\''+core.base64_encode(key)+'\',gcResult);'
		);
	}

	// set show state for all categories
	for(var key in core.categories){
		for (var i = 0; i < core.categories[key].length; i++){
			core.categories[key][i].show = true;
		}
	}

	$('input.total_line').val(core.format.price(core.cart.total));
	if(new String(location.href).indexOf('cart') >= 0)
		core.catalog.setFilter('cartOnly');

	core.catalog.updateTotalViews();

	core.catalog.initRemoveSigns();

	var cmpnts = document.URL.split('#');
	var pair = cmpnts[cmpnts.length - 1].split('=');

	if (pair.length === 2) {
		$(document).ready( function () {
			core.catalog.setFilter(pair[0], pair[1], true);
		});
	}
}

core.catalog.initRemoveSigns=function(){
	$('.prodTotal_text > i.icon-remove-sign').click(function () {
		var jq = $(this);
		var idSplit = jq.parent().attr('id').split('_');
		$('.prodQty_'+idSplit[1]).val(0);
		jq.parent().hide();
		core.catalog.updateRow(idSplit[1], 0);
		//core.catalog.setQty(idSplit[1], 0, 0);
	});
}

core.catalog.updateTotalViews = function () {
	$('.prodTotal_text span.value').each(function () {
		var value = $(this).text();
		if (value.length > 0) {
			$(this).parent().show();
		}
	});
};

core.catalog.setAddressCache=function(address,gcResult){
	if(gcResult && gcResult[0]){
		core.catalog.addressCoords[core.base64_decode(address)] = [
			gcResult[0].geometry.location.lat(),
			gcResult[0].geometry.location.lng()
		];
	}else{
		core.catalog.addressCoords[core.base64_decode(address)] = false;
	}
}

core.catalog.checkInventoryFailure=function(prodId, maximumQuantity, dd_id){
	core.log('failure...');
	$('.prodQty_'+prodId).val(parseFloat(maximumQuantity));
	$('#qtyBelowInv_'+prodId).html(((maximumQuantity)?'Only '+parseFloat(maximumQuantity):'Sorry none')+' are available.').fadeIn(300);
	core.catalog.updateRowContinue(prodId, maximumQuantity, dd_id);
}

core.catalog.doWeeklySpecial=function(prodId){
	core.catalog.updateRow(prodId,1);
	$('.prodQty_'+prodId).val(1);
	$('#weekly_special').fadeOut('fast');
}

core.catalog.updateRowContinue=function(prodId, newQty, dd_id) {
	//alert('ok, all set to update the ui: '+prodId+'/'+newQty+'/'+dd_id);
	
	// loop through all the products
	var priceId = -1;
	var lowestMin = 100000000000000;
	var rowTotal = 100000000000000;
	
	//core.alertHash(core.prices[prodId])
	
	for (var i = 0; i < core.prices[prodId].length; i++){
		
		// reformat the min qty to zero if it came across as an object (nulls can do this)
		if(typeof(core.prices[prodId][i]['min_qty']) == 'object')
			core.prices[prodId][i]['min_qty'] = 0;

		// reformat the price if necessary
		core.prices[prodId][i]['price'] =parseFloat(new String(core.prices[prodId][i]['price']).replace('$','').replace(' ',''));

		// if this is a valid price,
		if(newQty >= parseFloat(core.prices[prodId][i]['min_qty']) &&  core.prices[prodId][i]['price'] > 0){
			//alert('examining '+core.prices[prodId][i]['price_id']+': '+core.prices[prodId][i]['price']);
			// then calculate the row total based on this price
			var possibleRow = parseFloat(core.prices[prodId][i]['price']) * newQty;

			// if this is lower than our previous best, use this price
			if(possibleRow < rowTotal){
				rowTotal = possibleRow;
				priceId = core.prices[prodId][i]['price_id'];
			}
		}


		if(core.prices[prodId][i]['min_qty'] > 0 && core.prices[prodId][i]['min_qty'] < lowestMin){
			lowestMin = core.prices[prodId][i]['min_qty'];
		}
	}

	// if we we found a valid price,
	if(priceId > 0){
		//alert('lowest is: '+priceId+' / '+rowTotal);
		//alert();
		core.catalog.setQty(prodId,newQty,rowTotal);
		$('#qtyBelowMin_'+prodId).html('<br />');
		core.catalog.sendNewQtys();
	}else{
		//alert('here')
		if(newQty > 0){
			//alert('You must order '+prodId+' at least '+parseFloat(lowestMin))
			$('#qtyBelowMin_'+prodId).html('You must order at least '+parseFloat(lowestMin)).show();
		}
		$('.prodTotal_'+prodId).val(0);
		core.catalog.setQty(prodId,0,0);
		core.catalog.sendNewQtys();
	}
}

core.catalog.updateRow=function(prodId,newQty,dd){
	if(newQty == '')
		newQty = 0;
	var newQty = new String(newQty).replace(/[^0-9\.]+/g, '');
	var newQty = parseInt(newQty);
	dd = dd | $('#prodDd_' + prodId).val() | core.catalog.filters.dd;
	$('#qtyBelowInv_'+prodId).hide();
	core.doRequest('/catalog/check_inventory', '&prod_id=' + prodId +'&newQty=' + newQty +'&dd_id='+dd);
}

core.catalog.setQty=function(prodId,newQty,rowTotal){
	var found=false;
	//loop through the cart products
	for (var i = 0; i < core.cart.items.length; i++){
		// if we found it, then update its row total and quantity
		if(core.cart.items[i].prod_id == prodId){
			core.cart.items[i].qty_ordered = newQty;
			core.cart.items[i].row_total = rowTotal;
			found = true;
		}
	}

	// if we never found it in the above loop, then it's a new product
	// to the cart. Just push it on.
	if(!found){
		core.cart.items.push({
			'prod_id':prodId,
			'qty_ordered':newQty
		});
	}

	// show the total
	$('.prodTotal_'+prodId).val(core.format.price(rowTotal));
	$('.prodQty_'+prodId).val(newQty===0?'':newQty);
	$('.prodTotal_'+prodId+'_text .value').text(core.format.price(rowTotal));
	if (rowTotal === 0) {
		$('.prodTotal_'+prodId+'_text').hide();
	} else {
		$('.prodTotal_'+prodId+'_text').show();
	}
}

core.catalog.sendNewQtys=function(){
	var items=[];
	var data = '';
	for (var i = 0; i < core.cart.items.length; i++){
		data += '&prod_'+core.cart.items[i].prod_id+'='+core.cart.items[i].qty_ordered + ';' + $('#prodDd_' + core.cart.items[i].prod_id).val();
		items.push(core.cart.items[i].prod_id);
	}
	data += '&items='+items.join('_');
	core.doRequest('/cart/update_quantity',data);
}

core.catalog.handleCartResponse=function(itemHash){
	core.cart = itemHash;
	$('input.total_line').val(core.format.price(core.cart.total));
}


core.catalog.popupWho=function(prodId,refObj){
	var seller = core.sellers[core.prodIndex[prodId]['org_id']][0];
	var p_who  = core.prodIndex[prodId]['product_who'];
	var html = '<table><tr><td>';
	if(seller.has_image){
		html += '<img style="float:left;margin: 0px 8px 8px 0px;" src="/img/organizations/cached/'+seller.org_id+'.120.100.jpg" />';
	}
	html += '<span class="product_name">'+seller['name']+'</span><br />&nbsp;<br />';
	if(p_who != null && p_who != '')
		html += '<span class="farm_name">Who:</span> '+ p_who
		;
	else if(seller['profile']+'' != 'undefined' && seller['profile']+'' != 'null' && seller['profile']+'' != '')
		html += '<span class="farm_name">Who:</span> '+ seller['profile'];
	html += '<br />&nbsp;<br /></td></tr></table>';
	core.catalog.popupShow(refObj,html,'Who');
}

core.catalog.popupWhat=function(prodId,refObj){
	var seller = core.sellers[core.prodIndex[prodId]['org_id']][0];
	var prod = core.prodIndex[prodId];
	var html = '<table><tr><td>';
	if(typeof(prod.pimg_id) != 'object'){
		html += '<img class="catalog" style="float:left;margin: 0px 8px 8px 0px;" src="/img/products/cache/'+prod.pimg_id+'.'+prod.width+'.'+prod.height+'.200.150.'+prod.extension+'" />';
	}
	html += '<span class="product_name">'+prod['name'];
	if(prod['single_unit'] != ''){
		html += ' ('+prod['single_unit']+')'
	}
	html += '</span><br />';
	html += '<span class="farm_name">from '+prod['org_name']+'</span><br />&nbsp;<br />';
	html += '<span class="what_section">What: </span>'+prod['description']+'<br />&nbsp;<br />';
	html += '<span class="what_section">How: </span>'+((prod['how'] == '')?seller['product_how']:prod['how']);
	html += '</td></tr></table>';

	core.catalog.popupShow(refObj,html,'What');
}

core.catalog.popupWhere=function(prodId,refObj){
	var seller = core.sellers[core.prodIndex[prodId]['org_id']][0];
	//core.alertHash(core.prodIndex[prodId]);
	var latitude = parseFloat(core.prodIndex[prodId]['latitude']);
	var longitude = parseFloat(core.prodIndex[prodId]['longitude']);
	//core.alertHash(core.prodIndex[prodId]);

	core.ui.map('whereMap','#shop_popup_content',440,300,8);
	// look for the address in our cache
	if(!isNaN(latitude) && !isNaN(longitude)){
		//alert('got coords: '+latitude+'/'+longitude);
		core.ui.mapCenterByCoord('whereMap',latitude,longitude);
		core.ui.mapAddMarkerByCoord('whereMap',latitude,longitude,core.base64_encode('<h1>'+seller.name+'</h1>'),'/img/default/farm_bubble.png');
	}else{
		console.log('no coords');
		// if we dont' find it, set the map to the city
		core.ui.mapCenterByAddress('whereMap',core.prodIndex[prodId].city);
		core.ui.mapAddMarkerByAddress('whereMap',core.prodIndex[prodId].city,core.base64_encode('<h1>'+seller.name+'</h1>'));
	}
	core.catalog.popupShow(refObj,'','Where');
	//var pos = $(refObj).offset();
	//$('#shop_popup').hide().css('top',(pos.top + 15)+'px').css('left',(pos.left - 340)+'px').mouseleave(core.catalog.popupOff).fadeIn('fast');
}

core.catalog.popupShow=function(refObj,content,type){
	//console.log('show called');
	var pos = $(refObj).offset();
	if(content != '')
		$('#shop_popup_content').html(content);

	//console.log('step 1');

	if(core.catalog.popupOn == 0 || (core.catalog.popupOn==1 && core.catalog.popupType != type))
		$('#shop_popup').hide().css('top',(pos.top + 18)+'px').css('left',(pos.left - 340)+'px').fadeIn("slow");

	core.catalog.popupType = type;
	core.catalog.popupOn = 1;

	$('#shop_popup').mouseleave(function(){core.catalog.popupOn=0;window.setTimeout(core.catalog.popupOff,500);}).mouseenter(function(){core.catalog.popupOn=1;});
	//console.log('step 2');
	$(refObj).mouseleave(function(){core.catalog.popupOn=0;window.setTimeout(core.catalog.popupOff,500);}).mouseenter(function(){core.catalog.popupOn=1;});
	//console.log('step 3');
	//$(refObj).mouseleave(core.catalog.popupOff);
	//$('#shop_popup').hide().css('top',(pos.top + 15)+'px').css('left',(pos.left - 340)+'px');
	//.mouseleave(core.catalog.popupOff).fadeIn('fast');
	/*
	$("#shop_popup").fadeIn("slow");
	$('#'+id).mouseenter(function(){
		if(core.catalog.popupFlag != type){
			core.catalog.popupFlag = 0;
			$('#shop_popup').hide();
		}
		core.catalog.popupFlag=type;
	});

	$('#shop_popup').mouseenter(function(){
		core.catalog.popupFlag=type;
	});*/
	//core.catalog.setupPopup(refObj.getAttribute('id'));
}

core.catalog.popupOff=function(refObj){
	if(core.catalog.popupOn == 0)
		$('#shop_popup').fadeOut('fast');
}

core.catalog.closeAllPopups=function(args){

	core.catalog.popupOff();
}

core.catalog.setupPopup=function(id){
	$("#"+id).mouseenter(function(){
		clearTimeout($(this).data('timeoutId'));
		$("#shop_popup").fadeIn("slow");
	}).mouseleave(function(){
		var someElement = $(this);
		var timeoutId = setTimeout(function(){
			$("#shop_popup").fadeOut("slow");
		}, 650);
		//set the timeoutId, allowing us to clear this trigger if the mouse comes back over
		someElement.data('timeoutId', timeoutId);
	});
}

core.catalog.popupLoginRegister=function(idx){
	var refObj = document.getElementById(((core.catalog.filters.cartOnly==1)?'continueShoppingButton':'showCartButton')+idx);
	var pos = $(refObj).offset();
	$('#edit_popup').css( {
		'left': (pos.left - 100)+'px',
		'top': (pos.top - 30)+'px'
	});
	core.doRequest('/catalog/popup_login_register',{});
}

//core.catalog.initCatalog();