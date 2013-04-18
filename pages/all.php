<?php

	$title_text = elgg_echo("best_practices:all:title");

	// make breadcrumb
	elgg_push_breadcrumb($title_text);
	
	// make page elements
	$options = array(
		"type" => "object",
		"subtype" => BestPractice::SUBTYPE,
		"full_view" => false
	);
	if (!($content = elgg_list_entities($options))) {
		$content = elgg_echo("notfound");
	}
	
	// register title button
	elgg_register_title_button();
	
	// build page
	$page_data = elgg_view_layout("content", array(
		"title" => $title_text,
		"content" => $content
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);
	