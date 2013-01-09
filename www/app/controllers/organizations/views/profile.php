<?php
global $data;
$tab_id = $core->view[0];

if (!isset($data))
	die ("This organizations/profile module can not be called directly.");


list($has_image,$webpath,$filepath) = $data->get_image();

if($data['allow_sell'] == 1)
{
	?>
	<div class="tabarea" id="orgtabs-a<?=$tab_id?>">
		<table class="form">
			<tr>
				<td class="value" colspan="2">
					<div id="imgContainer">
						<img id="orgImg" src="<?=$webpath?>" />
					</div>
					<div class="buttonset">
						<input type="file" name="new_image" value="" />
						<input type="button" class="button_secondary" value="Upload" onclick="core.ui.uploadFrame(document.organizationsForm,'uploadArea','org.refreshImage({params});','app/organizations/save_image');" />
						<input type="button" id="removeLogo" class="button_secondary" value="Remove Image" onclick="core.doRequest('/organizations/remove_image',{'org_id':<?=$data['org_id']?>});" /> 
					</div>
					Note: images can not be larger than 400 pixels wide by 400 pixels tall.<br />
					<iframe name="uploadArea" id="uploadArea" width="300" height="20" style="color:#fff;background-color:#fff;overflow:hidden;"></iframe>
				</td>
			</tr>
			<tr>
				<td class="label">&nbsp;</td>
				<td class="value"><?=core_ui::checkdiv('public_profile','Show my profile on Our Sellers page.',($data['public_profile'] == 1))?></td>
			</tr>
			<?=core_form::input_textarea('Short Who','short_profile',$data,array(
				'sublabel'=>'Please limit to 50 characters',
				'required'=>true,
				'rows'=>2,
				'cols'=>50,
				'info'=>'Customers can view this field when browsing the catalog. Additionally, you can override this on a per-product basis.',
			))?>

			<?=core_form::input_textarea('Long Who','profile',$data,array(
				'sublabel'=>'Your organization\'s story',
				'required'=>true,
				'rows'=>5,
				'cols'=>50,
				'info'=>'Customers can view this field when viewing your farm profile or a product. Additionally, you can override this on a per-product basis.',
			))?>
			<?=core_form::input_textarea('Short How','short_product_how',$data,array(
				'sublabel'=>'Please limit to 50 characters',
				'required'=>true,
				'rows'=>2,
				'cols'=>50,
				'info'=>'Every product has a description of how it is made. The value of this field will be used for your default Short How. Additionally, you can override this on a per-product basis.',
			))?>

			<?=core_form::input_textarea('Long How','product_how',$data,array(
				'sublabel'=>'Your products\' story',
				'required'=>true,
				'rows'=>5,
				'cols'=>50,
				'info'=>'Every product has a description of how it is made. The value of this field will be used for your default Long How. Additionally, you can override this on a per-product basis.',
			))?>
		</table>
	</div>
<?}?>