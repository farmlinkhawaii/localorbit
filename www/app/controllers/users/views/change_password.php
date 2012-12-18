<?
core::ensure_navstate(array('left'=>'left_dashboard'));
if(lo3::is_admin() || lo3::is_market() || lo3::is_seller()):
	core_ui::fullWidth();
else:
	core_ui::showLeftNav();
endif;

core::head('Change Your Password','This page is used to change your own password');
lo3::require_permission();
lo3::require_login();


echo(
	core_form::page_header('Change Your password').
	core_form::form('userForm','/users/do_change_password',null,
		core_form::tab_switchers('passwordtabs',array('Password Security')),
		core_form::tab('passwordtabs',
			core_form::table_nv(
				core_form::input_password('New Password','password'),
				core_form::input_password('Confirm Password','confirm_password')
			)
		),
		'</div>',
		core_form::input_hidden('entity_id',$core->session['user_id']),
		core_form::save_only_button()
	)
);

?>
