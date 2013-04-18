<?php

	// need to be logged in
	gatekeeper();
	
	// add or edit
	$guid = (int) get_input("guid");
	$entity = null;
	if (!empty($guid)) {
		// edit
		if (($entity = get_entity($guid)) && $entity->canEdit()) {
			if (!elgg_instanceof($entity, "object", BestPractice::SUBTYPE)) {
				// not correct type/subtype
				register_error(elgg_echo("ClassException:ClassnameNotClass", array($guid, elgg_echo("item:object:best_practice"))));
				forward(REFERER);
			}
		} else {
			// entity not found
			register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
			forward(REFERER);
		}
		
		// set page owner
		elgg_set_page_owner_guid($entity->getOwnerGUID());
		
		
		$title_text = elgg_echo("best_practices:edit:title", array($entity->title));
	} else {
		// add
		$title_text = elgg_echo("best_practices:add:title");
		
	}
	
	//only for group members
	group_gatekeeper();
	
	// make breadcrumb
	elgg_push_breadcrumb(elgg_echo("best_practices:all:title"), "best_practice/all");
	elgg_push_breadcrumb($title_text);
	
	// find out if there is a plugin setting for target audience
	$target_audience_options = false;
	if ($setting = elgg_get_plugin_setting("target_audience", "best_practices")) {
		$target_audience_options = string_to_tag_array($setting);
		$target_audience_options = array_combine($target_audience_options, $target_audience_options);
	}
	
	// make form
	$form_vars = array(
		"enctype" => "multipart/form-data"
	);
	$body_vars = array(
		"entity" => $entity,
		"target_audience_options" => $target_audience_options
	);
	
	$form = elgg_view_form("best_practices/edit", $form_vars, $body_vars);
	
	// build page
	$page_data = elgg_view_layout("content", array(
		"title" => $title_text,
		"filter" => false,
		"content" => $form
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);