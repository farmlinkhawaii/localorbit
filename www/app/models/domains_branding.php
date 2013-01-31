<?php
class core_model_domains_branding extends core_model_base_domains_branding
{
	function get_branding($data)
	{
		$branding = core::model('domains_branding')->collection()->filter('domain_id', '=', intval($core->data['domain_id']))->filter('is_temp', '=', 0)->row();

		if (empty($branding))
		{
			$branding = core::model('domains_branding');
		}

		$branding['domain_id'] = $data['domain_id'];
		$branding['header_font'] = $data['header_font'];
		$branding['text_color'] = hexdec($data['font_color']);
		$branding['background_color'] = hexdec($data['background_color']);
		$branding['background_id'] = $data['background_id']?$data['background_id']:null;

		return $branding;
	}

	function delete_all_temporary($domain_id)
	{
		core_db::query('delete from domains_branding where is_temp = 1 and domain_id = ' . $domain_id);
	}

	function save_temp($data)
	{
		$this->delete_all_temporary($data['domain_id']);
		$branding = core::model('domains_branding');
		$branding['domain_id'] = $data['domain_id'];
		$branding['header_font'] = $data['header_font'];
		$branding['text_color'] = hexdec($data['font_color']);
		$branding['background_color'] = hexdec($data['background_color']);
		$branding['background_id'] = $data['background_id']?$data['background_id']:null;
		$branding['is_temp'] = 1;
		$branding->save();
		return $branding;
	}
}
?>