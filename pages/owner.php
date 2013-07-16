<?php

	$page_owner = elgg_get_page_owner_entity();
	if (empty($page_owner) || !elgg_instanceof($page_owner, "user")) {
		register_error(elgg_echo("pageownerunavailable", array(elgg_get_page_owner_guid())));
		forward("best_practice/all");
	}
	
	if ($page_owner->getGUID() == elgg_get_logged_in_user_guid()) {
		// mine
		$title_text = elgg_echo("best_practices:owner:title:mine");
		$filter_context = "mine";
	} else {
		// some other owner
		$title_text = elgg_echo("best_practices:owner:title", array($page_owner->name));
		$filter_context = "";
	}
	
	// make breadcrumb
	elgg_push_breadcrumb(elgg_echo("best_practices:all:title"), "best_practice/all");
	elgg_push_breadcrumb($page_owner->name);
	
	// register title button
	elgg_register_title_button();
	
	// get page elements
	$options = array(
		"type" => "object",
		"subtype" => BestPractice::SUBTYPE,
		"owner_guid" => $page_owner->getGUID(),
		"limit" => false,
		"pagination" => false,
		"full_view" => false,
		"list_type" => "table",
		"list_class" => "best-practices-table",
		"header" => elgg_view("best_practices/list_header")
	);
	if (!($content = elgg_list_entities($options, "elgg_get_entities", "best_practices_view_entity_list"))) {
		$content = elgg_echo("notfound");
	}
	
	// we need to be able to add some text after header, but before filter
	elgg_extend_view("page/layouts/content/header", "best_practices/list_description");
	
	// build page
	$page_data = elgg_view_layout("best_practices", array(
		"title" => $title_text,
		"content" => $content,
		"filter_context" => $filter_context
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);