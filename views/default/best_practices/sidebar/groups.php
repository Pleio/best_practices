<?php

	// show related groups
	$entity = elgg_extract("entity", $vars);
	
	if ($group_guids = $entity->getRelatedGroups(true)) {
		$title = elgg_echo("best_practices:sidebar:groups:title");
		
		$list_options = array(
			"guids" => $group_guids,
			"full_view" => false,
			"pagination" => false,
			"limit" => false
		);
		
		elgg_push_context("widgets");
		$body = elgg_list_entities($list_options);
		elgg_pop_context();
		
		echo elgg_view_module("aside", $title, $body);
	}