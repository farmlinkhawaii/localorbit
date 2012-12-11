<?
# this library is used to draw form elements

class core_form
{
	public static function tab_switchers($tabset_name,$tab_list)
	{
		global $core;
		core_ui::tabset($tabset_name);
		$html = '<ul class="nav nav-tabs" id="'.$tabset_name.'">';
		for ($i = 0; $i < count($tab_list); $i++)
		{
			if ($i == 0): $default_active = 'active'; else: $default_active = ''; endif; # Picks first tab as default active
			$html .= '<li class="' . $default_active . '"><a href="#'.$tabset_name.'-a'.($i + 1).'" class="tabswitch" data-toggle="tab">'.$tab_list[$i].'</a></li>';
		}
		$html .= '</ul>';
		return $html;
	}

	public static function tab($tabset_name)
	{
		global $core;

		if(!is_numeric($core->config['tab_index_cache'][$tabset_name]))
		{
			$core->config['tab_index_cache'][$tabset_name] = 0;
		}
		$core->config['tab_index_cache'][$tabset_name]++;

		# get the final content list for this div
		$items = func_get_args();
		array_shift($items);

		$out = '<div class="tab-pane tabarea" id="'.$tabset_name.'-a'.$core->config['tab_index_cache'][$tabset_name].'">';
		$out .= core_form::render_items($items).'</div>';
		return $out;
	}

	public static function table_nv()
	{
		$items = func_get_args();
		#$out = '<table class="form">'.core_form::render_items($items).'</table>';
		$out = '<fieldset>'.core_form::render_items($items).'</fieldset>';
		return $out;
	}

	public static function table_2col($col1='',$col2='')
	{
		$out = '<table>'.core_form::column_widths('48%','4%','48%').'<tr>';
		$out .= '<td>'.$col1.'</td>';
		$out .= '<td>&nbsp;&nbsp;</td>';
		$out .= '<td>'.$col2.'</td>';
		return $out .= '</tr></table>';
	}

	public static function form($name,$url,$options=null)
	{
		$options = core_form::finalize_options($options,array(
			'style'=>'',
			'render'=>true,
		));
		if($options['render'] != true)	return '';

		$out = '<form name="'.$name.'" class="form-horizontal" action="'.$url.'" method="post" id="'.$name.'" onsubmit="return core.submit(\''.$url.'\',this);" enctype="multipart/form-data"';

		if($options['style'] != '')
		{
			$out .= ' style="'.$options['style'].'"';
		}
		$out .= '>';
		$items = func_get_args();
		array_shift($items);
		array_shift($items);
		array_shift($items);
		$out .= core_form::render_items($items);
		return $out .= '</form>';
	}

	public static function page_header($title,$extrafunction='',$function_text='',$icon='')
	{
		$out = '<div class="form_header clearfix">';
		$out .= '<h1>'.$title.'</h1>';
		if($extrafunction!='')
		{
			$out .= '<h2 class="form_add_button btn btn-primary"><a href="'.$extrafunction.'" onclick="core.go(this.href);">'.$function_text.'</a></h2>';
		}
		$out .= '</div><div class="clearfix"></div>';
		return $out;
	}


	public static function header($label,$options=null)
	{
		$options = core_form::finalize_options($options,array(
			'level'=>2,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		return '<h'.$options['level'].'>'.$label.'</h'.$options['level'].'>';
	}

	public static function header_nv($label,$options=null)
	{
		$options = core_form::finalize_options($options,array(
			'level'=>3,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		$html = '<tr><td colspan="2"><h'.$options['level'].'>'.$label;
		$html .= (isset($options['info'])  && $options['info'] != '')?
			core_form::info($options['info'],$options['info_icon'],$options['info_show']):'';
	
		$html .= '</h'.$options['level'].'></td></tr>';
		return $html;
	}
	
	public static function spacer_nv($lines=1)
	{
		$html = '<br />';
		for($i=1;$i<$lines;$i++)
			$html .= '&nbsp;<br />';
		return '<tr><td colspan="2">'.$html.'</td></tr>';
	}

	public static function column_widths()
	{
		$widths = func_get_args();
		$out = '';
		foreach($widths as $width)
			$out .= '<col width="'.$width.'" />';
		return $out;
	}

	public static function required()
	{
		return '<span class="required">*</span>';
	}

	public static function tr_nv($label,$value,$options)
	{
		#$label .= ($label != '&nbsp;')?':':'';
		$label .= (isset($options['sublabel']) && $options['sublabel'] !='')?
			'<div class="sublabel">'.$options['sublabel'].'</div>':'';
		if($label == '&nbsp;')
		{
			$value .= (isset($options['required']) && $options['required'] == true)?
				core_form::required():'';
		}
		else
		{
			$label .= (isset($options['required']) && $options['required'] == true)?
				core_form::required():'';
		}
		$value .= (isset($options['info'])  && $options['info'] != '')?
			core_form::info($options['info'],$options['info_icon'],$options['info_show']):'';


		$html = '
		<div class="control-group">
			<label class="control-label" for="inputEmail">'.$label.'</label>
		    <div class="controls">
				'. $value .'
		    </div>
		</div>
		';
		return $html;
	}

	public static function get_final_value($name,$value)
	{
		if(is_object($value) || is_array($value))
			$value = $value[$name];
		return $value;
	}

	public static function finalize_options($passed,$defaults)
	{
		if($passed == null)
			return $defaults;

		$final = $defaults;
		foreach($passed as $name=>$value)
			$final[$name] = $value;
		return $final;
	}

	public static function render_items($items)
	{
		$out = '';
		foreach($items as $item)
		{
			if(is_array($item))
				$out .= implode('',$item);
			else
				$out .= $item;
		}
		return $out;
	}

	public static function input_button($name,$value,$onclick='',$options=null)
	{
		$options = core_form::finalize_options($options,array(
			'class'=>'primary',
			'type'=>'button',
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		return '<input type="'.$options['type'].'" class="button_'.$options['class'].'" name="'.$name.'" value="'.$value.'" onclick="'.$onclick.'" />';
	}


	public static function input_hidden($name,$value)
	{
		$value = core_form::get_final_value($name,$value);
		return '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
	}

	public static function value($label,$value,$options=null)
	{
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		return core_form::tr_nv($label,$value);
	}


	public static function input_image_upload($label,$ul_path,$options=null)
	{
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'render'=>true,

			'src'=>'',
			'img_id'=>'',
			'img_style'=>'',
			'remove_js'=>'',
			'upload_js'=>'',
		));
		if($options['render'] != true)	return '';

		if($options['src'] == '')
			$options['img_style'] .= 'display:none;';


		$out = '<img id="'.$options['img_id'].'" src="'.$options['src'].'"';
		$out .= (isset($options['img_style']) && $options['img_style'] !='')?' style="'.$options['img_style'].'"':'';
		$out .= ' /><br />';
		$out .= '<input type="file" name="new_image" value="" />';
		$out .= '<input type="button" id="removenlimage" class="button_secondary" value="Remove Image" onclick="'.$options['remove_js'].'" />';

		return core_form::tr_nv($label,$out,$options);
	}

	public static function input_text($label,$name,$value='',$options=null)
	{
		$value   = core_form::get_final_value($name,$value);
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		return core_form::tr_nv($label,'<input type="text" name="'.$name.'" value="'.$value.'" />',$options);
	}

	public static function input_datepicker($label,$name,$value,$options=null)
	{
		$value = core_form::get_final_value($name,$value);
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		return core_form::tr_nv($label,core_ui::date_picker($name,$value),$options);
	}

	public static function input_check($label,$name,$value,$options=null)
	{
		$value = core_form::get_final_value($name,$value);
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		return core_form::tr_nv('&nbsp;',core_ui::checkdiv($name,$label,$value,$options['onclick'],$options));
	}

	public static function input_password($label,$name,$value='',$options=null)
	{
		$value = core_form::get_final_value($name,$value);
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		return core_form::tr_nv($label,'<input type="password" name="'.$name.'" value="'.$value.'" />',$options);
	}

	public static function input_select($label,$name,$value,$source,$options=null)
	{
		$value = core_form::get_final_value($name,$value);
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'render'=>true,
			'select_style'=>'',
			'option_prefix'=>'',
			'option_suffix'=>'',

			'text_column'=>'text',
			'value_column'=>'value',

			'default_show'=>false,
			'default_text'=>'',
			'default_value'=>0,
			'onchange'=>'',
		));
		if($options['render'] != true)	return '';

		$out = '<select name="'.$name.'"';
		$out .= (isset($options['select_style']) && $options['select_style'] != '')?' style="'.$options['select_style'].'"':'';
		$out .='>';

		if($options['default_show'] == true)
		{
			$out .= '<option value="'.$options['default_value'].'"';
			$out .= ($value==$options['default_value'])?' selected="selected"':'';
			$out .= '>'.$options['default_text'].'</option>';
		}

		if(is_array($source))
		{
			foreach($source as $opt_value=>$opt_text)
			{
				$out .= '<option value="'.$opt_value.'"';
				$out .= ($value==$opt_value)?' selected="selected"':'';
				$out .= '>'.$options['option_prefix'].$opt_text.$options['option_suffix'].'</option>';
			}
		}
		else if(is_object($source))
		{
			foreach($source as $source_row)
			{
				$out .= '<option value="'.$source_row[$options['value_column']].'"';
				$out .= ($value==$source_row[$options['value_column']])?' selected="selected"':'';
				$out .= '>'.$options['option_prefix'].$source_row[$options['text_column']].$options['option_suffix'].'</option>';
			}
		}
		else if(is_string($source))
		{
			$out .= $source;
		}

		$out .= '</select>';

		return core_form::tr_nv($label,$out,$options);
	}

	public static function input_textarea($label,$name,$value,$options=null)
	{
		$value = core_form::get_final_value($name,$value);
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'rows'=>7,
			'cols'=>50,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		return core_form::tr_nv($label,'<textarea name="'.$name.'" rows="'.$options['rows'].'" cols="'.$options['cols'].'">'.$value.'</textarea>',$options);
	}

	public static function input_rte($label,$name,$value,$options=null)
	{
		$value = core_form::get_final_value($name,$value);
		$options = core_form::finalize_options($options,array(
			'sublabel'=>'',
			'rowid'=>'',
			'display_row'=>true,
			'required'=>false,
			'info'=>'',
			'info_icon'=>null,
			'info_show'=>false,
			'rows'=>7,
			'cols'=>73,
			'render'=>true,
		));
		if($options['render'] != true)	return '';
		core_ui::rte();
		return core_form::tr_nv($label,'<textarea class="rte" id="'.$name.'" name="'.$name.'" rows="'.$options['rows'].'" cols="'.$options['rows'].'">'.$value.'</textarea>',$options);
	}

	public static function info($msg,$icon='speech',$show=false)
	{
		global $core;
		# take care of a situation where this is called by one of the form generator functions
		if(is_null($icon))
			$icon = 'speech';

		$rand_id = strtr('f'.microtime(),' .','__');
		$out  = '<div class="info_toggle" onclick="$(\'#'.$rand_id.'\').toggle(\'fast\');">&nbsp;</div>';
		$out .= '<div class="info_area info_area_'.$icon.'" id="'.$rand_id.'"';
		if($show === true)
		{
			$out .= ' style="display: block;"';
		}
		$out .= '>'.$msg.'</div>';
		return $out;
	}


	public static function save_buttons($options=null)
	{
		global $core;
		$options = core_form::finalize_options($options,array(
			'require_pin' => false,
		));

		if($core->session['sec_pin'] == 1)
		{
			$options['require_pin'] = false;
		}

		if($options['require_pin'])
		{
			$out = '
				<div class="buttonset unlock_area" id="unlock_area">
					4 Digit Pin: <input type="password" name="sec_pin" id="sec_pin" value="" />
					<input type="button" class="button_primary" value="unlock to save" onclick="core.doRequest(\'/auth/unlock_pin\',{\'formname\':this.form.getAttribute(\'name\'),\'sec_pin\':$(\'#sec_pin\').val()});" />
				</div>
			';
		}
		else
		{
			$out = '
				<div class="form-actions" id="main_save_buttons"'.(($options['require_pin'])?' style="display:none;"':'').'>
					<input type="'.(($require_pin)?'button':'submit').'" class="btn btn-primary" name="save" value="'.$core->i18n['button:save_and_continue'].'" />
					<input type="button" onclick="core.submit(this.form.action,this.form,{\'do_redirect\':1});" class="btn btn-primary" value="'.$core->i18n['button:save_and_go_back'].'" />
				</div>
			';
		}
		return $out;
	}

	public static function save_only_button($options=null)
	{
		global $core;
		$options = core_form::finalize_options($options,array(
			'cancel_button'=>false,
			'on_cancel'=>'',
			'on_save'=>'',
			'require_pin' => false,
		));
		$out = '<div class="buttonset pull-right" id="main_save_buttons">';
		if($options['cancel_button'])
		{
			$out .= '<input type="button" class="btn" name="cancel" onclick="'.$options['on_cancel'].'" value="'.$core->i18n['button:cancel'].'" />';

		}
		$out .= '<input type="submit" class="btn btn-primary btn-large" onclick="'.$options['on_save'].' name="save" value="'.$core->i18n['button:save'].'" /></div>';

		return $out;
	}
}

?>