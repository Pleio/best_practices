<?php

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");
	
	elgg_register_event_handler("init", "system", "best_practices_init");
	
	function best_practices_init() {
		// extend CSS/js
		elgg_extend_view("css/elgg", "css/best_practices/site");
		elgg_extend_view("js/elgg", "js/best_practices/site");
		
		// register page handler for nice URL's
		elgg_register_page_handler("best_practice", "best_practices_page_handler");
		
		// add subtype
		add_subtype("object", BestPractice::SUBTYPE, "BestPractice");
		
		// extend views
		elgg_extend_view("groups/tool_latest", "best_practices/group_module");
		
		// register widgets
		elgg_register_widget_type("best_practices", elgg_echo("best_practices:widget:title"), elgg_echo("best_practices:widget:description"), "groups");
		
		// register events
		elgg_register_event_handler("pagesetup", "system", "best_practices_pagesetup");
		
		// register plugin hooks
		elgg_register_plugin_hook_handler("public_pages", "walled_garden", "best_practices_public_pages_hook");
		elgg_register_plugin_hook_handler("register", "menu:owner_block", "best_practices_register_menu_owner_block_hook");
		elgg_register_plugin_hook_handler("widget_url", "widget_manager", "best_practices_widget_url_hook");
		
		// register actions
		elgg_register_action("best_practices/edit", dirname(__FILE__) . "/actions/edit.php");
		elgg_register_action("best_practice/delete", dirname(__FILE__) . "/actions/delete.php");
		elgg_register_action("best_practices/delete_attachment", dirname(__FILE__) . "/actions/delete_attachment.php");
	}
	
	function best_practices_pagesetup() {
		// add site menu item
		elgg_register_menu_item("site", array(
			"name" => "best_practices",
			"text" => elgg_echo("best_practices:menu:site"),
			"href" => "best_practice/all"
		));
	}