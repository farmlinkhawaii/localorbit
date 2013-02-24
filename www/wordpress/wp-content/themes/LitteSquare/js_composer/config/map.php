<?php
/**
 * WPBakery Visual Composer Shortcodes settings
 *
 * @package VPBakeryVisualComposer
 *
 */

//$colors_arr = array(__("Grey", "TS") => "button_grey", __("Yellow", "TS") => "button_yellow", __("Green", "TS") => "button_green", __("Blue", "TS") => "button_blue", __("Red", "TS") => "button_red", __("Orange", "TS") => "button_orange");
$colors_arr = array(__("Grey", "TS") => "wpb_button", __("Blue", "TS") => "btn-primary", __("Turquoise", "TS") => "btn-info", __("Green", "TS") => "btn-success", __("Orange", "TS") => "btn-warning", __("Red", "TS") => "btn-danger", __("Black", "TS") => "btn-inverse");

$size_arr = array(__("Regular size", "TS") => "button-big", __("Large", "TS") => "button-big", __("Small", "TS") => "btn-small", __("Mini", "TS") => "btn-mini");

$target_arr = array(__("Same window", "TS") => "_self", __("New window", "TS") => "_blank");


wpb_map( array(
    "name"		=> __("Text block", "TS"),
    "base"		=> "vc_column_text",
    "class"		=> "",
    "icon"      => "icon-wpb-layer-shape-text",
    "wrapper_class" => "clearfix",
    "controls"	=> "full",
    "category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "",
            "heading" => __("Text", "TS"),
            "param_name" => "content",
            "value" => __("<p>I am text block. Click edit button to change this text.</p>", "TS"),
            "description" => __("Enter your content.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );


/* Latest tweets
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Twitter widget", "TS"),
    "base"		=> "vc_twitter",
    "class"		=> "wpb_vc_twitter_widget",
	"icon"		=> 'icon-wpb-balloon-twitter-left',
    "category"  => __('Social', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("What text use as widget title. Leave blank if no title is needed.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Twitter name", "TS"),
            "param_name" => "twitter_name",
            "value" => "",
            "description" => __("Type in twitter profile name from which load tweets.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Tweets count", "TS"),
            "param_name" => "tweets_count",
            "value" => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15),
            "description" => __("How many recent tweets to load.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );

/* Separator (Divider)
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Separator (Divider)", "TS"),
    "base"		=> "vc_separator",
    "class"		=> "wpb_vc_separator wpb_controls_top_right",
	'icon'		=> 'icon-wpb-ui-separator',
    "category"  => __('Content', 'js_composer'),
    "controls"	=> 'popup_delete'
) );

/* Textual block
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Separator (Divider) with text", "TS"),
    "base"		=> "vc_text_separator",
    "class"		=> "wpb_controls_top_right",
    "controls"	=> "edit_popup_delete",
	"icon"		=> "icon-wpb-ui-separator-label",
    "category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Title", "TS"),
            "param_name" => "title",
            "holder" => "div",
            "value" => __("Title", "TS"),
            "description" => __("Separator title.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Title position", "TS"),
            "param_name" => "title_align",
            "value" => array(__('Align center', "TS") => "separator_align_center", __('Align left', "TS") => "separator_align_left", __('Align right', "TS") => "separator_align_right"),
            "description" => __("Select title location.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    ),
    "js_callback" => array("init" => "wpbTextSeparatorInitCallBack")
) );

/* Message box
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Message box", "TS"),
    "base"		=> "vc_message",
    "class"		=> "wpb_vc_messagebox wpb_controls_top_right",
	"icon"		=> "icon-wpb-information-white",
    "wrapper_class" => "alert",
    "controls"	=> "edit_popup_delete",
    "category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "dropdown",
            "heading" => __("Message box type", "TS"),
            "param_name" => "color",
            "value" => array(__('Informational', "TS") => "alert-info", __('Warning', "TS") => "alert-block", __('Success', "TS") => "alert-success", __('Error', "TS") => "alert-error"),
            "description" => __("Select message type.", "TS")
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "messagebox_text",
            "heading" => __("Message text", "TS"),
            "param_name" => "content",
            "value" => __("<p>I am message box. Click edit button to change this text.</p>", "TS"),
            "description" => __("Message text.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    ),
    "js_callback" => array("init" => "wpbMessageInitCallBack")
) );

/* Facebook like button
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Facebook like", "TS"),
    "base"		=> "vc_facebook",
    "class"		=> "wpb_vc_facebooklike wpb_controls_top_right",
	"icon"		=> "icon-wpb-balloon-facebook-left",
    "controls"	=> "edit_popup_delete",
    "category"  => __('Social', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "dropdown",
            "heading" => __("Button type", "TS"),
            "param_name" => "type",
            "value" => array(__("Standard", "TS") => "standard", __("Button count", "TS") => "button_count", __("Box count", "TS") => "box_count"),
            "description" => __("Select button type.", "TS")
        )
    )
) );

/* Tweetmeme button
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Tweetmeme button", "TS"),
    "base"		=> "vc_tweetmeme",
    "class"		=> "wpb_controls_top_right",
	"icon"		=> "icon-wpb-balloon-twitter-left",
    "controls"	=> "edit_popup_delete",
    "category"  => __('Social', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "dropdown",
            "heading" => __("Button type", "TS"),
            "param_name" => "type",
            "value" => array(__("Horizontal", "TS") => "horizontal", __("Vertical", "TS") => "vertical", __("None", "TS") => "none"),
            "description" => __("Select button type.", "TS")
        )
    )
) );

/* Google+ button
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Google+ button", "TS"),
    "base"		=> "vc_googleplus",
    "class"		=> "wpb_vc_googleplus wpb_controls_top_right",
	"icon"		=> "icon-wpb-application-plus",
    "controls"	=> "edit_popup_delete",
    "category"  => __('Social', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "dropdown",
            "heading" => __("Button size", "TS"),
            "param_name" => "type",
            "value" => array(__("Standard", "TS") => "", __("Small", "TS") => "small", __("Medium", "TS") => "medium", __("Tall", "TS") => "tall"),
            "description" => __("Select button type.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Annotation", "TS"),
            "param_name" => "annotation",
            "value" => array(__("Inline", "TS") => "inline", __("Bubble", "TS") => "", __("None", "TS") => "none"),
            "description" => __("Select annotation type.", "TS")
        )
    )
) );

/* Google+ button
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Pinterest button", "TS"),
    "base"		=> "vc_pinterest",
    "class"		=> "wpb_vc_pinterest wpb_controls_top_right",
	"icon"		=> "icon-wpb-pinterest",
    "controls"	=> "edit_popup_delete",
    "category"  => __('Social', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "dropdown",
            "heading" => __("Button layout", "TS"),
            "param_name" => "type",
            "value" => array(__("Horizontal", "TS") => "", __("Vertical", "TS") => "vertical", __("No count", "TS") => "none"),
            "description" => __("Select button type.", "TS")
        )
    )
) );

/* Toggle (FAQ)
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("FAQ (Toggle)", "TS"),
    "base"		=> "vc_toggle",
    "controls"	=> "edit_popup_delete",
    "class"		=> "wpb_vc_faq wpb_controls_top_right",
	"icon"		=> "icon-wpb-toggle-small-expand",
    "category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "holder" => "h4",
            "class" => "toggle_title",
            "heading" => __("Toggle title", "TS"),
            "param_name" => "title",
            "value" => __("Toggle title", "TS"),
            "description" => __("Toggle block title.", "TS")
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "toggle_content",
            "heading" => __("Toggle content", "TS"),
            "param_name" => "content",
            "value" => __("<p>Toggle content goes here, click edit button.</p>", "TS"),
            "description" => __("Toggle block content.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Default state", "TS"),
            "param_name" => "open",
            "value" => array(__("Closed", "TS") => "false", __("Open", "TS") => "true"),
            "description" => __("Select this if you want toggle to be open by default.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );

/* Single image */
wpb_map( array(
	"name"		=> __("Single image", "TS"),
	"base"		=> "vc_single_image",
	"class"		=> "wpb_vc_single_image_widget",
	"icon"		=> "icon-wpb-single-image",
    "category"  => __('Content', 'js_composer'),
    "params"	=> array(
		array(
			"type" => "attach_image",
			"heading" => __("Image", "TS"),
			"param_name" => "image",
			"value" => "",

			"description" => ""
		),
        array(
            "type" => "textfield",
            "heading" => __("Image size", "TS"),
            "param_name" => "img_size",
            "value" => "",
            "description" => __("Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Image link", "TS"),
            "param_name" => "img_link",
            "value" => "",
            "description" => __("Enter url if you want to link this image with any url. Leave empty if you won't use it", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Link Target", "TS"),
            "param_name" => "img_link_target",
            "value" => $target_arr,
            "dependency" => Array('element' => "img_link", 'not_empty' => true)
        )
    )
));

/* Gallery/Slideshow
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Image gallery", "TS"),
    "base"		=> "vc_gallery",
    "class"		=> "wpb_vc_gallery_widget",
	"icon"		=> "icon-wpb-images-stack",
    "category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("What text use as widget title. Leave blank if no title is needed.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Gallery type", "TS"),
            "param_name" => "type",
            "value" => array(__("Flex slider fade", "TS") => "flexslider_fade", __("Flex slider slide", "TS") => "flexslider_slide", __("Nivo slider", "TS") => "nivo", __("Image grid", "TS") => "image_grid"),
            "description" => __("Select gallery type. Note: Nivo slider is not fully responsive.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Auto rotate slides", "TS"),
            "param_name" => "interval",
            "value" => array(3, 5, 10, 15, 0),
            "description" => __("Auto rotate slides each X seconds. Select 0 to disable.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("On click", "TS"),
            "param_name" => "onclick",
            "value" => array(__("Open prettyPhoto", "TS") => "link_image", __("Do nothing", "TS") => "link_no", __("Open custom link", "TS") => "custom_link"),
            "description" => __("What to do when slide is clicked?.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Image size", "TS"),
            "param_name" => "img_size",
            "value" => "",
            "description" => __("Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size.", "TS")
        ),
        array(
            "type" => "attach_images",
            "heading" => __("Images", "TS"),
            "param_name" => "images",
            "value" => "",
            "description" => ""
        ),
        array(
            "type" => "exploded_textarea",
            "heading" => __("Custom links", "TS"),
            "param_name" => "custom_links",
            "description" => __('Select "Open custom link" in "On click" parameter and then enter links for each slide here. Divide links with linebreaks (Enter).', 'js_composer')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Custom link target", "TS"),
            "param_name" => "custom_links_target",
            "description" => __('Select where to open  custom links.', 'js_composer'),
            'value' => $target_arr
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );


/* Tabs
   This one is an advanced example. It has javascript
   callbacks in it. So basically in your theme you can do
   whatever you want. More detailed documentation located
   in the advanced documentation folder.
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Tabs", "TS"),
    "base"		=> "vc_tabs",
    "controls"	=> "full",
    "class"		=> "wpb_tabs not_dropable_in_third_level not-column-inherit tabbable tabs-top",
	"icon"		=> "icon-wpb-ui-tab-content",
	"category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("What text use as widget title. Leave blank if no title is needed.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Auto rotate slides", "TS"),
            "param_name" => "interval",
            "value" => array(0, 3, 5, 10, 15),
            "description" => __("Auto rotate slides each X seconds. Select 0 to disable.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    ),
    "custom_markup" => '
	<div class="tab_controls">
		<button class="add_tab">'.__("Add tab", "TS").'</button>
		<button class="edit_tab">'.__("Edit current tab title", "TS").'</button>
		<button class="delete_tab">'.__("Delete current tab", "TS").'</button>
	</div>

	<div class="wpb_tabs_holder">
		%content%
	</div>',
    'default_content' => '
	<ul>
		<li><a href="#tab-1"><span>'.__('Tab 1', 'js_composer').'</span></a></li>
		<li><a href="#tab-2"><span>'.__('Tab 2', 'js_composer').'</span></a></li>
	</ul>

	<div id="tab-1" class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
		[vc_column_text width="1/1"] '.__('I am text block. Click edit button to change this text.', 'js_composer').' [/vc_column_text]
	</div>

	<div id="tab-2" class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
		[vc_column_text width="1/1"] '.__('I am text block. Click edit button to change this text.', 'js_composer').' [/vc_column_text]
	</div>',
    "js_callback" => array("init" => "wpbTabsInitCallBack", "shortcode" => "wpbTabsGenerateShortcodeCallBack")
    //"js_callback" => array("init" => "wpbTabsInitCallBack", "edit" => "wpbTabsEditCallBack", "save" => "wpbTabsSaveCallBack", "shortcode" => "wpbTabsGenerateShortcodeCallBack")
) );

/* Tour section
---------------------------------------------------------- */
WPBMap::map( 'vc_tour', array(
    "name"		=> __("Tour section", "TS"),
    "base"		=> "vc_tour",
    "controls"	=> "full",
    "class"		=> "wpb_tour not_dropable_in_third_level not-column-inherit",
	"icon"		=> "icon-wpb-ui-tab-content-vertical",
	"category"  => __('Content', 'js_composer'),
    "wrapper_class" => "clearfix",
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("What text use as widget title. Leave blank if no title is needed.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Auto rotate slides", "TS"),
            "param_name" => "interval",
            "value" => array(0, 3, 5, 10, 15),
            "description" => __("Auto rotate slides each X seconds. Select 0 to disable.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    ),
    "custom_markup" => '
	<div class="tab_controls">
		<button class="add_tab">'.__("Add slide", "TS").'</button>
		<button class="edit_tab">'.__("Edit current slide title", "TS").'</button>
		<button class="delete_tab">'.__("Delete current slide", "TS").'</button>
	</div>

	<div class="wpb_tabs_holder clearfix">
		%content%
	</div>',
    'default_content' => '
	<ul>
		<li><a href="#tab-1"><span>'.__('Slide 1', 'js_composer').'</span></a></li>
		<li><a href="#tab-2"><span>'.__('Slide 2', 'js_composer').'</span></a></li>
	</ul>

	<div id="tab-1" class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
		[vc_column_text width="1/1"] '.__('I am text block. Click edit button to change this text.', 'js_composer').' [/vc_column_text]
	</div>

	<div id="tab-2" class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
		[vc_column_text width="1/1"] '.__('I am text block. Click edit button to change this text.', 'js_composer').' [/vc_column_text]
	</div>',
    "js_callback" => array("init" => "wpbTabsInitCallBack", "shortcode" => "wpbTabsGenerateShortcodeCallBack")
) );
/* Tour section
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Accordion section", "TS"),
    "base"		=> "vc_accordion",
    "controls"	=> "full",
    "class"		=> "wpb_accordion not_dropable_in_third_level not-column-inherit",
	"icon"		=> "icon-wpb-ui-accordion",
	"category"  => __('Content', 'js_composer'),
//	"wrapper_class" => "clearfix",
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("What text use as widget title. Leave blank if no title is needed.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    ),
    "custom_markup" => '
	<div class="tab_controls">
		<button class="add_tab">'.__("Add section", "TS").'</button>
		<button class="edit_tab">'.__("Edit current section title", "TS").'</button>
		<button class="delete_tab">'.__("Delete current section", "TS").'</button>
	</div>

	<div class="wpb_accordion_holder clearfix">
		%content%
	</div>',
    'default_content' => '
	<div class="group">
		<h3><a href="#">'.__('Section 1', 'js_composer').'</a></h3>
		<div>
			<div class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
				[vc_column_text width="1/1"] '.__('I am text block. Click edit button to change this text.', 'js_composer').' [/vc_column_text]
			</div>
		</div>
	</div>
	<div class="group">
		<h3><a href="#">'.__('Section 2', 'js_composer').'</a></h3>
		<div>
			<div class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
				[vc_column_text width="1/1"] '.__('I am text block. Click edit button to change this text.', 'js_composer').' [/vc_column_text]
			</div>
		</div>
	</div>',
    "js_callback" => array("init" => "wpbAccordionInitCallBack", "shortcode" => "wpbAccordionGenerateShortcodeCallBack")
) );

/* Teaser grid
---------------------------------------------------------- 
wpb_map( array(
    "name"		=> __("Teaser (posts) grid", "TS"),
    "base"		=> "vc_teaser_grid",
    "class"		=> "wpb_vc_teaser_grid_widget",
	"icon"		=> "icon-wpb-application-icon-large",
	"category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("Heading text. Leave it empty if not needed.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Columns count", "TS"),
            "param_name" => "grid_columns_count",
            "value" => array(4, 3, 2, 1),
            "description" => __("Select columns count.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Teaser count", "TS"),
            "param_name" => "grid_teasers_count",
            "value" => "",
            "description" => __('How many teasers to show? Enter number or "All".', "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Content", "TS"),
            "param_name" => "grid_content",
            "value" => array(__("Teaser (Excerpt)", "TS") => "teaser", __("Full Content", "TS") => "content"),
            "description" => __("Teaser layout template.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Layout", "TS"),
            "param_name" => "grid_layout",
            "value" => array(__("Title + Thumbnail + Text", "TS") => "title_thumbnail_text", __("Thumbnail + Title + Text", "TS") => "thumbnail_title_text", __("Thumbnail + Text", "TS") => "thumbnail_text", __("Thumbnail + Title", "TS") => "thumbnail_title", __("Thumbnail only", "TS") => "thumbnail", __("Title + Text", "TS") => "title_text"),
            "description" => __("Teaser layout.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Link", "TS"),
            "param_name" => "grid_link",
            "value" => array(__("Link to post", "TS") => "link_post", __("Link to bigger image", "TS") => "link_image", __("Thumbnail to bigger image, title to post", "TS") => "link_image_post", __("No link", "TS") => "link_no"),
            "description" => __("Link type.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Link target", "TS"),
            "param_name" => "grid_link_target",
            "value" => $target_arr,
            "dependency" => Array('element' => "grid_link", 'value' => array('link_post', 'link_image', 'link_image_post'))
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Template", "TS"),
            "param_name" => "grid_template",
            "value" => array(__("Grid", "TS") => "grid", __("Grid with filter", "TS") => "filtered_grid", __("Carousel", "TS") => "carousel"),
            "description" => __("Teaser layout template.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Layout mode", "TS"),
            "param_name" => "grid_layout_mode",
            "value" => array(__("Fit rows", "TS") => "fitRows", __('Masonry', "TS") => 'masonry'),
            "dependency" => Array('element' => 'grid_template', 'value' => array('filtered_grid', 'grid')),
            "description" => __("Teaser layout template.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Thumbnail size", "TS"),
            "param_name" => "grid_thumb_size",
            "value" => "",
            "description" => __('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height).', "TS")
        ),
        array(
            "type" => "posttypes",
            "heading" => __("Post types", "TS"),
            "param_name" => "grid_posttypes",
            "description" => __("Select post types to populate posts from.", "TS")
        ),
        array(
            "type" => "taxomonies",
            "heading" => __("Taxomonies", "TS"),
            "param_name" => "grid_taxomonies",
            "dependency" => Array('element' => 'grid_template' , 'value' => array('filtered_grid'), 'callback' => 'wpb_grid_post_types_for_taxomonies_handler'),
            "description" => __("Select texamonies from.", "TS")
        ),

        array(
            "type" => "textfield",
            "heading" => __("Post/Page IDs", "TS"),
            "param_name" => "posts_in",
            "value" => "",
            "description" => __('Fill this field with page/posts IDs separated by commas (,) to retrieve only them. Use this in conjunction with "Post types" field.', "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Exclude Post/Page IDs", "TS"),
            "param_name" => "posts_not_in",
            "value" => "",
            "description" => __('Fill this field with page/posts IDs separated by commas (,) to exclude them from query.', "TS")
        ),
        array(
            "type" => "exploded_textarea",
            "heading" => __("Categories", "TS"),
            "param_name" => "grid_categories",
            "description" => __("If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter).", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Order by", "TS"),
            "param_name" => "orderby",
            "value" => array( "", __("Date", "TS") => "date", __("ID", "TS") => "ID", __("Author", "TS") => "author", __("Title", "TS") => "title", __("Modified", "TS") => "modified", __("Random", "TS") => "rand", __("Comment count", "TS") => "comment_count", __("Menu order", "TS") => "menu_order" ),
            "description" => __('Select how to sort retrieved posts. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'js_composer')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Order way", "TS"),
            "param_name" => "order",
            "value" => array( __("Descending", "TS") => "DESC", __("Ascending", "TS") => "ASC" ),
            "description" => __('Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'js_composer')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );

 Teaser grid
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Posts slider", "TS"),
    "base"		=> "vc_posts_slider",
    "class"		=> "wpb_vc_posts_slider_widget",
	"icon"		=> "icon-wpb-slideshow",
	"category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("Heading text. Leave it empty if not needed.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Slider type", "TS"),
            "param_name" => "type",
            "value" => array(__("Flex slider fade", "TS") => "flexslider_fade", __("Flex slider slide", "TS") => "flexslider_slide", __("Nivo slider", "TS") => "nivo"),
            "description" => __("Select slider type. Note: Nivo slider is not fully responsive.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Slides count", "TS"),
            "param_name" => "count",
            "value" => "",
            "description" => __('How many slides to show? Enter number or "All".', "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Auto rotate slides", "TS"),
            "param_name" => "interval",
            "value" => array(3, 5, 10, 15, 0),
            "description" => __("Auto rotate slides each X seconds. Select 0 to disable.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Description", "TS"),
            "param_name" => "slides_content",
            "value" => array(__("No description", "TS") => "", __("Teaser (Excerpt)", "TS") => "teaser" ),
            "description" => __("Some sliders support description text, what content use for it?", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Link", "TS"),
            "param_name" => "link",
            "value" => array(__("Link to post", "TS") => "link_post", __("Link to bigger image", "TS") => "link_image", __("Open custom link", "TS") => "custom_link", __("No link", "TS") => "link_no"),
            "description" => __("Link type.", "TS")
        ),
        array(
            "type" => "exploded_textarea",
            "heading" => __("Custom links", "TS"),
            "param_name" => "custom_links",
            "description" => __('Select "Open custom link" in "Link" parameter and then enter links for each slide here. Divide links with linebreaks (Enter).', 'js_composer')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Thumbnail size", "TS"),
            "param_name" => "thumb_size",
            "value" => "",
            "description" => __('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height).', "TS")
        ),
        array(
            "type" => "posttypes",
            "heading" => __("Post types", "TS"),
            "param_name" => "posttypes",
            "description" => __("Select post types to populate posts from.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Post/Page IDs", "TS"),
            "param_name" => "posts_in",
            "value" => "",
            "description" => __('Fill this field with page/posts IDs separated by commas (,), to retrieve only them. Use this in conjunction with "Post types" field.', "TS")
        ),
        array(
            "type" => "exploded_textarea",
            "heading" => __("Categories", "TS"),
            "param_name" => "categories",
            "description" => __("If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter).", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Order by", "TS"),
            "param_name" => "orderby",
            "value" => array( "", __("Date", "TS") => "date", __("ID", "TS") => "ID", __("Author", "TS") => "author", __("Title", "TS") => "title", __("Modified", "TS") => "modified", __("Random", "TS") => "rand", __("Comment count", "TS") => "comment_count", __("Menu order", "TS") => "menu_order" ),
            "description" => __('Select how to sort retrieved posts. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'js_composer')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Order by", "TS"),
            "param_name" => "order",
            "value" => array( __("Descending", "TS") => "DESC", __("Ascending", "TS") => "ASC" ),
            "description" => __('Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'js_composer')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );

/* Widgetised sidebar
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Widgetised Sidebar", "TS"),
    "base"		=> "vc_widget_sidebar",
    "controls"	=> "full",
    "class" 	=> "wpb_widget_sidebar_widget",
	"icon"		=> "icon-wpb-layout_sidebar",
	"category"  => __('Structure', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("What text use as widget title. Leave blank if no title is needed.", "TS")
        ),
        array(
            "type" => "widgetised_sidebars",
            "heading" => __("Sidebar", "TS"),
            "param_name" => "sidebar_id",
            "value" => "",
            "description" => __("Select which widget area output.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );


/* Button
---------------------------------------------------------- */
$icons_arr = array(
    __("None", "TS") => "none",
    __("Address book icon", "TS") => "wpb_address_book",
    __("Alarm clock icon", "TS") => "wpb_alarm_clock",
    __("Anchor icon", "TS") => "wpb_anchor",
    __("Application Image icon", "TS") => "wpb_application_image",
    __("Arrow icon", "TS") => "wpb_arrow",
    __("Asterisk icon", "TS") => "wpb_asterisk",
    __("Hammer icon", "TS") => "wpb_hammer",
    __("Balloon icon", "TS") => "wpb_balloon",
    __("Balloon Buzz icon", "TS") => "wpb_balloon_buzz",
    __("Balloon Facebook icon", "TS") => "wpb_balloon_facebook",
    __("Balloon Twitter icon", "TS") => "wpb_balloon_twitter",
    __("Battery icon", "TS") => "wpb_battery",
    __("Binocular icon", "TS") => "wpb_binocular",
    __("Document Excel icon", "TS") => "wpb_document_excel",
    __("Document Image icon", "TS") => "wpb_document_image",
    __("Document Music icon", "TS") => "wpb_document_music",
    __("Document Office icon", "TS") => "wpb_document_office",
    __("Document PDF icon", "TS") => "wpb_document_pdf",
    __("Document Powerpoint icon", "TS") => "wpb_document_powerpoint",
    __("Document Word icon", "TS") => "wpb_document_word",
    __("Bookmark icon", "TS") => "wpb_bookmark",
    __("Camcorder icon", "TS") => "wpb_camcorder",
    __("Camera icon", "TS") => "wpb_camera",
    __("Chart icon", "TS") => "wpb_chart",
    __("Chart pie icon", "TS") => "wpb_chart_pie",
    __("Clock icon", "TS") => "wpb_clock",
    __("Fire icon", "TS") => "wpb_fire",
    __("Heart icon", "TS") => "wpb_heart",
    __("Mail icon", "TS") => "wpb_mail",
    __("Play icon", "TS") => "wpb_play",
    __("Shield icon", "TS") => "wpb_shield",
    __("Video icon", "TS") => "wpb_video"
);

wpb_map( array(
    "name"		=> __("Button", "TS"),
    "base"		=> "vc_button",
    "class"		=> "wpb_vc_button wpb_controls_top_right",
	"icon"		=> "icon-wpb-ui-button",
	"category"  => __('Content', 'js_composer'),
    "controls"	=> "edit_popup_delete",
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Text on the button", "TS"),
            "holder" => "button",
            "class" => "wpb_button",
            "param_name" => "title",
            "value" => __("Text on the button", "TS"),
            "description" => __("Text on the button.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("URL (Link)", "TS"),
            "param_name" => "href",
            "value" => "",
            "description" => __("Button link.", "TS")
        ),
        
        array(
            "type" => "dropdown",
            "heading" => __("Size", "TS"),
            "param_name" => "size",
            "value" => $size_arr,
            "description" => __("Button size.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Icon", "TS"),
            "param_name" => "icon",
            "value" => $icons_arr
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Target", "TS"),
            "param_name" => "target",
            "value" => $target_arr
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    ),
    "js_callback" => array("init" => "wpbButtonInitCallBack", "save" => "wpbButtonSaveCallBack")
    //"js_callback" => array("init" => "wpbCallToActionInitCallBack", "shortcode" => "wpbCallToActionShortcodeCallBack")
) );

wpb_map( array(
    "name"		=> __("Call to action button", "TS"),
    "base"		=> "vc_cta_button",
    "class"		=> "button_grey",
	"icon"		=> "icon-wpb-call-to-action",
	"category"  => __('Content', 'js_composer'),
    "controls"	=> "edit_popup_delete",
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Text on the button", "TS"),
            "param_name" => "title",
            "value" => __("Text on the button", "TS"),
            "description" => __("Text on the button.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("URL (Link)", "TS"),
            "param_name" => "href",
            "value" => "",
            "description" => __("Button link.", "TS")
        ),
    /*  array(
            "type" => "dropdown",
            "heading" => __("Icon", "TS"),
            "param_name" => "icon",
            "value" => $icons_arr
        ),
	*/
        array(
            "type" => "dropdown",
            "heading" => __("Target", "TS"),
            "param_name" => "target",
            "value" => $target_arr
        ),
        array(
            "type" => "textarea",
            "holder" => "h3",
            "class" => "",
            "heading" => __("Text", "TS"),
            "param_name" => "call_text",
            "value" => __("Click edit button to change this text.", "TS"),
            "description" => __("Enter your content.", "TS")
        ),
		array(
            "type" => "textarea",
            "heading" => __("Small Text", "TS"),
            "param_name" => "small_text",
            "value" => __("Click edit button to change this text.", "TS"),
            "description" => __("Small Text.", "TS")
        ),
		
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    ),
    "js_callback" => array("init" => "wpbCallToActionInitCallBack", "save" => "wpbCallToActionSaveCallBack")
) );

/* Video element
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Video player", "TS"),
    "base"		=> "vc_video",
    "class"		=> "",
	"icon"		=> "icon-wpb-film-youtube",
	"category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("Heading text. Leave it empty if not needed.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Video link", "TS"),
            "param_name" => "link",
            "value" => "",
            "description" => __('Link to the video. More about supported formats at <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>.', "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Video size", "TS"),
            "param_name" => "size",
            "value" => "",
            "description" => __('Enter video size in pixels. Example: 200x100 (Width x Height).', "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );

/* Google maps element
---------------------------------------------------------- */
wpb_map( array(
    "name"		=> __("Google maps", "TS"),
    "base"		=> "vc_gmaps",
    "class"		=> "",
	"icon"		=> "icon-wpb-map-pin",
	"category"  => __('Content', 'js_composer'),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("Heading text. Leave it empty if not needed.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Google map link", "TS"),
            "param_name" => "link",
            "value" => "",
            "description" => __('Link to your map. Visit <a href="http://maps.google.com" target="_blank">Google maps</a> find your address and then click "Link" button to obtain your map link.', "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Map height", "TS"),
            "param_name" => "size",
            "value" => "",
            "description" => __('Enter map height in pixels. Example: 200).', "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Map type", "TS"),
            "param_name" => "type",
            "value" => array(__("Map", "TS") => "m", __("Satellite", "TS") => "k", __("Map + Terrain", "TS") => "p"),
            "description" => __("Select button alignment.", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Map Zoom", "TS"),
            "param_name" => "zoom",
            "value" => array(__("14 - Default", "TS") => 14, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );

wpb_map( array(
	"name"		=> __("Raw html", "TS"),
	"base"		=> "vc_raw_html",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-html",
	"category"  => __('Structure', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			"type" => "textarea_raw_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Raw HTML", "TS"),
			"param_name" => "content",
			"value" => base64_encode("<p>I am raw html block.<br/>Click edit button to change this html</p>"),
			"description" => __("Enter your HTML content.", "TS")
		),
	)
) );

wpb_map( array(
	"name"		=> __("Raw js", "TS"),
	"base"		=> "vc_raw_js",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('Structure', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			"type" => "textarea_raw_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Raw js", "TS"),
			"param_name" => "content",
			"value" => __(base64_encode("<script type='text/javascript'> alert('Enter your js here!'); </script>"), "TS"),
			"description" => __("Enter your Js.", "TS")
		),
	)
) );

wpb_map( array(
    "base"		=> "vc_flickr",
    "name"		=> __("Flickr widget", "TS"),
    "class"		=> "",
    "icon"      => "icon-wpb-flickr",
    "category"  => __('Content', 'js_composer'),
    'enqueue_js' => array(''),
    'enqueue_css' => array(''),
    "params"	=> array(
        array(
            "type" => "textfield",
            "heading" => __("Widget title", "TS"),
            "param_name" => "title",
            "value" => "",
            "description" => __("What text use as widget title. Leave blank if no title is needed.", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Flickr ID", "TS"),
            "param_name" => "flickr_id",
            "value" => "",
            "description" => __('To find your flickID visit <a href="http://idgettr.com/" target="_blank">idGettr</a>', "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Number of photos", "TS"),
            "param_name" => "count",
            "value" => array(1, 2, 3, 4, 5, 6, 7, 8, 9),
            "description" => __("Number of photos", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Type", "TS"),
            "param_name" => "type",
            "value" => array(__("User", "TS") => "user", __("Group", "TS") => "group"),
            "description" => __("Photo stream type", "TS")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Display", "TS"),
            "param_name" => "display",
            "value" => array(__("Latest", "TS") => "latest", __("Random", "TS") => "random"),
            "description" => __("Photo order", "TS")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "TS"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "TS")
        )
    )
) );
wpb_map( array(
	"name"		=> __("Flickr 2", "TS"),
	"base"		=> "vc_flickr_widget",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			 "type" => "textfield",
            "heading" => __("Flickr", "TS"),
            "param_name" => "flickr_name",
            "value" => "",
            "description" => __("Enter your flickr ID ", "TS")
			),
		array(
			 "type" => "textfield",
            "heading" => __("Flickr Title", "TS"),
            "param_name" => "flickr_title",
            "value" => "",
            "description" => __("Title For Flickr.Set null if you don't want using it ", "TS")
			),
		array(
			"type" => "textfield",
            "heading" => __("Items", "TS"),
            "param_name" => "flickr_items",
            "value" => "",
            "description" => __("Input a number for flickr", "TS")
			),
		
	)
	) );	
$args=array(
  'orderby' => 'name',
  'order' => 'ASC'
  );
$categories=get_categories($args);
$ts_cates= array();
foreach($categories as $category) { 
	$ts_cates[$category->name] = $category->term_id;
};
/*
Category Post
*/
wpb_map( array(
	"name"		=> __("Category Post", "TS"),
	"base"		=> "ts_category_post_widget",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			 "type" => "textfield",
            "heading" => __("Title", "TS"),
            "param_name" => "category_title",
            "value" => "",
            "description" => __("Title For Category.Set null if you don't want using it ", "TS")
		),
		array(
			"type" => "dropdown",
            "heading" => __("Choice a category", "TS"),
            "param_name" => "category_choice",
            "value" => $ts_cates,
            "description" => __("Choice a category for display.", "TS")
		),
		array(
			"type" => "textfield",
            "heading" => __("Items", "TS"),
            "param_name" => "category_items",
            "value" => "",
            "description" => __("How many Items do you want ", "TS")
		),		
		
	)
) );

/*
Popular Post
*/
wpb_map( array(
	"name"		=> __("Popular Post", "TS"),
	"base"		=> "ts_popular_post_widget",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		
		array(
			"type" => "textfield",
            "heading" => __("Items", "TS"),
            "param_name" => "popular_post_items",
            "value" => "",
            "description" => __("How many Items do you want ", "TS")
		),		
		
	)
) );
/*
Popular Post 2
*/
wpb_map( array(
	"name"		=> __("Popular Post 2", "TS"),
	"base"		=> "ts_popular_post_2_widget",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		
		array(
			"type" => "textfield",
            "heading" => __("Items", "TS"),
            "param_name" => "popular_post_2_items",
            "value" => "",
            "description" => __("How many Items do you want ", "TS")
		),		
		
	)
) );
/*
Recent Post
*/
wpb_map( array(
	"name"		=> __("Recent Post", "TS"),
	"base"		=> "ts_recent_post_2_widget",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		
		array(
			"type" => "textfield",
            "heading" => __("Items", "TS"),
            "param_name" => "recent_post_2_items",
            "value" => "",
            "description" => __("How many Items do you want ", "TS")
		),		
		
	)
) );
wpb_map( array(
	"name"		=> __("Tabs Post", "TS"),
	"base"		=> "ts_custom_tabs_post",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		
		array(
			"type" => "textfield",
            "heading" => __("Items", "TS"),
            "param_name" => "recent_post_2_items",
            "value" => "",
            "description" => __("How many Items do you want ", "TS")
		),		
		
	)
) );
/*
Quick Contact
*/
wpb_map( array(
	"name"		=> __("Quick Contact", "TS"),
	"base"		=> "ts_quick_contact_widget",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		
		array(
			"type" => "textfield",
            "heading" => __("Title", "TS"),
            "param_name" => "ts_quick_contact_title",
            "value" => "",
            "description" => __("Input your title ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Content", "TS"),
            "param_name" => "ts_quick_contact_Content",
            "value" => "",
            "description" => __("Input your content ", "TS")
		),	
		array(
			"type" => "textfield",
            "heading" => __("Phone", "TS"),
            "param_name" => "ts_quick_contact_phone",
            "value" => "",
            "description" => __("Input your phone ", "TS")
		),	
		array(
			"type" => "textfield",
            "heading" => __("Fax", "TS"),
            "param_name" => "ts_quick_contact_fax",
            "value" => "",
            "description" => __("Input your phone ", "TS")
		),	
		array(
			"type" => "textfield",
            "heading" => __("Mail", "TS"),
            "param_name" => "ts_quick_contact_mail",
            "value" => "",
            "description" => __("Input your phone ", "TS")
		),	
		array(
			"type" => "textfield",
            "heading" => __("Address", "TS"),
            "param_name" => "ts_quick_contact_Address",
            "value" => "",
            "description" => __("Input your phone ", "TS")
		),	
		
		
	)
) );
/*
Quick Contact 2
*/
wpb_map( array(
	"name"		=> __("Quick Contact 2", "TS"),
	"base"		=> "ts_quick_contact_2_widget",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		
		array(
			"type" => "textfield",
            "heading" => __("Title", "TS"),
            "param_name" => "ts_quick_contact_2_title",
            "value" => "",
            "description" => __("Input your title ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Content", "TS"),
            "param_name" => "ts_quick_contact_2_Content",
            "value" => "",
            "description" => __("Input your content ", "TS")
		),	
		array(
			"type" => "textfield",
            "heading" => __("Phone", "TS"),
            "param_name" => "ts_quick_contact_2_phone",
            "value" => "",
            "description" => __("Input your phone ", "TS")
		),	
		array(
			"type" => "textfield",
            "heading" => __("Fax", "TS"),
            "param_name" => "ts_quick_contact_2_fax",
            "value" => "",
            "description" => __("Input your phone ", "TS")
		),	
		array(
			"type" => "textfield",
            "heading" => __("Mail", "TS"),
            "param_name" => "ts_quick_contact_2_mail",
            "value" => "",
            "description" => __("Input your Mail ", "TS")
		),	
		array(
			"type" => "textfield",
            "heading" => __("website", "TS"),
            "param_name" => "ts_quick_contact_2_website",
            "value" => "",
            "description" => __("Input your website ", "TS")
		),	
	)
) );
/*
Custom Social
*/
wpb_map( array(
	"name"		=> __("Custom Social", "TS"),
	"base"		=> "ts_custom_social_widget",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		
		array(
			"type" => "textfield",
            "heading" => __("Title", "TS"),
            "param_name" => "ts_custom_social_title",
            "value" => "",
            "description" => __("Input your title ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Content", "TS"),
            "param_name" => "ts_custom_social_content",
            "value" => "",
            "description" => __("Input your content ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Facebook", "TS"),
            "param_name" => "ts_custom_social_facebook",
            "value" => "",
            "description" => __("Input your Facebook ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Twitter", "TS"),
            "param_name" => "ts_custom_social_twitter",
            "value" => "",
            "description" => __("Input your twitter ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("LinkedIn", "TS"),
            "param_name" => "ts_custom_social_linkedin",
            "value" => "",
            "description" => __("Input your LinkedIn ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Vimeo", "TS"),
            "param_name" => "ts_custom_social_vimeo",
            "value" => "",
            "description" => __("Input your Vimeo ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Dribble", "TS"),
            "param_name" => "ts_custom_social_dribble",
            "value" => "",
            "description" => __("Input your Dribble ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Delicious", "TS"),
            "param_name" => "ts_custom_social_delicious",
            "value" => "",
            "description" => __("Input your Delicious ", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Youtube", "TS"),
            "param_name" => "ts_custom_social_youtube",
            "value" => "",
            "description" => __("Input your Youtube", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Stumbleupon", "TS"),
            "param_name" => "ts_custom_social_stumbleupon",
            "value" => "",
            "description" => __("Input your stumbleupon", "TS")
		),		
		array(
			"type" => "textfield",
            "heading" => __("Flickr", "TS"),
            "param_name" => "ts_custom_social_flickr",
            "value" => "",
            "description" => __("Input your flickr", "TS")
		),		
		
	)
) );

wpb_map( array(
	"name"		=> __("Category List", "TS"),
	"base"		=> "ts_category_widget",
	
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"class"		=> "div",
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			 "type" => "textfield",
            "heading" => __("Title", "TS"),
            "param_name" =>"widget_title",
            "value" => "",
            "description" => __("Enter Title For Category List", "TS")
		),
	)
) );

/*
$filter = '1',$sum_post='10',$paged='1',$postfolio_category='All',$order='DESC'
*/
/* Get Portfolio Category */
/* Chua code Dang loi 
	$portfolio_types=get_terms('portfolio-category');
	$ts_cates_portfolio = array();
	if($portfolio_types) :
		foreach($portfolio_types as $category) { 
			$ts_cates_portfolio[$category->name] = $category->term_id;
		};
	endif;*/
/**/
wpb_map( array(
	"name"		=> __("Portfolio List", "TS"),
	"base"		=> "ts_portfolio_list",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('widgets', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			 "type" => "dropdown",
            "heading" => __("Enable Filter", "TS"),
            "param_name" =>"filter",
            "value" => array(__("Yes", "TS") => "1", __("NO", "TS") => "0"),
            "description" => __("Enter Title For Category List", "TS")
		),
		array(
			"type" => "textfield",
            "heading" => __("Number", "TS"),
            "param_name" =>"sum_post",
            "value" => "",
            "description" => __("Enter Title For Category List", "TS")
		),
		/*
		array(
			 "type" => "textfield",
            "heading" => __("Paged of Portfolio", "TS"),
            "param_name" =>"paged",
            "value" => "",
            "description" => __("Enter Title For Category List", "TS")
		),
		
		array(
			 "type" => "dropdown",
            "heading" => __("Portfolio Category", "TS"),
            "param_name" =>"postfolio_category",
            "value" => array(__("ASC", "TS") => "ASC", __("DESC", "TS") => "DESC"),
            "description" => __("Enter Title For Category List", "TS")
		),*/
		array(
			 "type" => "dropdown",
            "heading" => __("Order", "TS"),
            "param_name" =>"order",
            "value" => array(__("ASC", "TS") => "ASC", __("DESC", "TS") => "DESC"),
            "description" => __("Enter Title For Category List", "TS")
		),
		
	)
) );


/*
Box Feature
*/
wpb_map( array(
	"name"		=> __("Box", "TS"),
	"base"		=> "ts_box",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('Content', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			"type" => "textfield",
			"heading" => __("Title", "TS"),
			"param_name" => "title",
			"value" => "",
			"description" => __("Box title.", "TS")
		),
		array(
			"type" => "textarea",
			"heading" => __("Content", "TS"),
			"param_name" => "tscontent",
			"value" => "",
			"description" => __("Box content.", "TS")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Enable Button link", "TS"),
			"param_name" => "enable_button_link",
			"value" => array(__("Yes", "TS") => "Yes", __("No", "TS") => "No"),
			"description" => __("Enable button link.", "TS")
		),
		array(
			"type" => "textfield",
			"heading" => __("Button title", "TS"),
			"param_name" => "button_title",
			"value" => "",
			"description" => __("Enter button title.", "TS")
		),
		array(
			"type" => "textfield",
			"heading" => __("Button link", "TS"),
			"param_name" => "button_link",
			"value" => "",
			"description" => __("Enter your button link.", "TS")
		),
		
	)
) );
/*
Recent Post
*/
wpb_map( array(
	"name"		=> __("Recent Post list 2", "TS"),
	"base"		=> "ts_recent_post_list_2",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('Content', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", "TS"),
			"param_name" => "Content",
			"value" => "",
			"description" => __("Enter title of recent post.", "TS")
		),
	)
) );


/*
Call To Action
*/
wpb_map( array(
	"name"		=> __("Call To Actions", "TS"),
	"base"		=> "ts_call_to_action",
	"class"		=> "div",
	"icon"      => "icon-wpb-raw-javascript",
	"category"  => __('Content', 'js_composer'),
	"wrapper_class" => "clearfix",
	"controls"	=> "full",
	"params"	=> array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Link", "TS"),
			"param_name" => "button_link",
			"value" => "",
			"description" => __("Insert button link.You don't want using,plz make blank.", "TS")
		),
		array(
			"type" => "textfield",
			"heading" => __("Button Title", "TS"),
			"param_name" => "button_title",
			"value" => "",
			"description" => __("Enter title for button.", "TS")
		),
		array(
			"type" => "textfield",
			"heading" => __("Big Text", "TS"),
			"param_name" => "bigtext",
			"value" => "",
			"description" => __("Enter Big Text.", "TS")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Small Text", "TS"),
			"param_name" => "smalltext",
			"value" => "",
			"description" => __("Enter Small text.", "TS")
		),
		
	)
) );

WPBMap::layout(array('id'=>'column_12', 'title'=>'1/2'));
WPBMap::layout(array('id'=>'column_12-12', 'title'=>'1/2 + 1/2'));
WPBMap::layout(array('id'=>'column_13', 'title'=>'1/3'));
WPBMap::layout(array('id'=>'column_13-13-13', 'title'=>'1/3 + 1/3 + 1/3'));
WPBMap::layout(array('id'=>'column_13-23', 'title'=>'1/3 + 2/3'));
WPBMap::layout(array('id'=>'column_14', 'title'=>'1/4'));
WPBMap::layout(array('id'=>'column_14-14-14-14', 'title'=>'1/4 + 1/4 + 1/4 + 1/4'));
WPBMap::layout(array('id'=>'column_16', 'title'=>'1/6'));
WPBMap::layout(array('id'=>'column_11', 'title'=>'1/1'));