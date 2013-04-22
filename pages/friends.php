<?php

	$page_owner = elgg_get_page_owner_entity();
	if (empty($page_owner) || !elgg_instanceof($page_owner, "user")) {
		register_error(elgg_echo("pageownerunavailable", array(elgg_get_page_owner_guid())));
		forward("best_practice/all");
	}
	
	if ($page_owner->getGUID() == elgg_get_logged_in_user_guid()) {
		// my friends
		$filter_context = "friends";
		$no_friends = elgg_echo("friends:none:you");
	} else {
		// someones other friends
		$filter_context = "";
		$no_friends = elgg_echo("friends:none");
	}
	$title_text = elgg_echo("best_practices:friends:title", array($page_owner->name));
	
	// make breadcrumb
	elgg_push_breadcrumb(elgg_echo("best_practices:all:title"), "best_practice/all");
	elgg_push_breadcrumb($page_owner->name, "best_practice/owner/" . $page_owner->username);
	elgg_push_breadcrumb(elgg_echo("friends"));
	
	// register title button
	elgg_register_title_button();
	
	// get page elements
	if ($friend_guids = best_practices_get_friend_guids($page_owner)) {
		$options = array(
			"type" => "object",
			"subtype" => BestPractice::SUBTYPE,
			"owner_guids" => $friend_guids,
			"limit" => false,
			"full_view" => false,
			"list_type" => "table",
			"header" => elgg_view("best_practices/list_header")
		);
		if (!($content = elgg_list_entities($options, "elgg_get_entities", "best_practices_view_entity_list"))) {
			$content = elgg_echo("notfound");
		}
	} else {
		$content = $no_friends;
	}
	
	// build page
	$page_data = elgg_view_layout("best_practices", array(
		"title" => $title_text,
		"content" => $content,
		"filter_context" => $filter_context
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);