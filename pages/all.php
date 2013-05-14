<?php

	$title_text = elgg_echo("best_practices:all:title");

	// make breadcrumb
	elgg_push_breadcrumb($title_text);
	
	// make page elements
	$options = array(
		"type" => "object",
		"subtype" => BestPractice::SUBTYPE,
		"limit" => false,
		"full_view" => false,
		"list_type" => "table",
		"list_class" => "best-practices-table",
		"header" => elgg_view("best_practices/list_header")
	);
	if (!($content = elgg_list_entities($options, "elgg_get_entities", "best_practices_view_entity_list"))) {
		$content = elgg_echo("notfound");
	}
	
	// register title button
	elgg_register_title_button();
	
	// build page
	$page_data = elgg_view_layout("best_practices", array(
		"title" => $title_text,
		"content" => $content
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);
	