<?php

	$page_owner = elgg_get_page_owner_entity();
	if (empty($page_owner) || !elgg_instanceof($page_owner, "group")) {
		register_error(elgg_echo("pageownerunavailable", array(elgg_get_page_owner_guid())));
		forward("best_practice/all");
	}
	
	// only for group members
	group_gatekeeper();
	
	$title_text = elgg_echo("best_practices:group:title", array($page_owner->name));
	
	// make breadcrumb
	elgg_push_breadcrumb(elgg_echo("best_practices:all:title"), "best_practice/all");
	elgg_push_breadcrumb($page_owner->name);
	
	// get page elements
	$options = array(
		"type" => "object",
		"subtype" => BestPractice::SUBTYPE,
		"relationship" => "related_group",
		"relationship_guid" => $page_owner->getGUID(),
		"full_view" => false
	);
	if (!($content = elgg_list_entities($options))) {
		$content = elgg_echo("notfound");
	}
	
	// build page
	$page_data = elgg_view_layout("content", array(
		"title" => $title_text,
		"content" => $content,
		"filter" => false
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);