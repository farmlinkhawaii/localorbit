<?php global $data; ?>

<div class="control-group">
	<label class="control-label">Contact Name</label>
	<div class="controls">
		<input type="text" name="secondary_contact_name" value="<?=$data['secondary_contact_name']?>" />
	</div>
</div>

<div class="control-group">
	<label class="control-label">Contact E-mail</label>
	<div class="controls">
		<input type="text" name="secondary_contact_email" value="<?=$data['secondary_contact_email']?>" />
	</div>
</div>

<div class="control-group">
	<label class="control-label">Contact Telephone</label>
	<div class="controls">
		<input type="text" name="secondary_contact_phone" value="<?=$data['secondary_contact_phone']?>" />
	</div>
</div>

<div class="control-group">
	<label class="control-label">Market Profile</label>
	<div class="controls">
		<textarea rows="5" class="input-xxlarge" name="market_profile"><?=$data['market_profile']?></textarea>
	</div>
</div>

<div class="control-group">
	<label class="control-label">Market Policies</label>
	<div class="controls">
		<textarea rows="5" class="input-xxlarge" cols="60" name="market_policies"><?=$data['market_policies']?></textarea>
	</div>
</div>

<? 
$logo = image('profile',$data['domain_id']);
$has_custom = (strpos($logo,'default') === false);
?>

<div class="control-group">
	<label class="control-label" for="specimage">Profile</label>
	<div class="controls row">
		<div class="span3"><img class="pull-left img-polaroid" src="<?=$logo?>?_time_=<?=$core->config['time']?>" id="logo3" /></div>
		<div class="span5">
			<input type="file" name="profile" value="" />
			<input type="button" class="btn btn-mini" value="Upload File" onclick="core.ui.uploadFrame(document.marketForm,'uploadArea3','market.refreshLogo3({params});','app/market/save_logo3');" />
			<input type="button" id="removeLogo3"<?=(($has_custom)?'':' style="display:none;"')?> class="btn btn-mini btn-danger" value="Remove Image" onclick="core.doRequest('/market/remove_logo3','&domain_id=<?=$data['domain_id']?>')" />

			<p class="alert alert-info help-block note">Note: images can not be larger than 600 pixels wide by 500 pixels tall. For best results, use images that are exactly 600 pixels wide by 500 pixels tall.</p>
			<iframe name="uploadArea3" id="uploadArea3" width="300" height="20" style="color:#fff;background-color:#fff;overflow:hidden; border: 0;"></iframe>
		</div>
			
	</div>
</div>

<div class="control-group">
	<label class="control-label">Store Closed Note</label>
	<div class="controls">
		<textarea rows="5" class="input-xxlarge" name="closed_note"><?=$data['closed_note']?></textarea>
	</div>
</div>