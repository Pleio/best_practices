<?php

	$entity = elgg_extract("entity", $vars);
	$owner = $entity->getOwnerEntity();
	
	$entity_menu = "";
	if(!elgg_in_context("widget")) {
		$entity_menu = elgg_view_menu("entity", array(
			"entity" => $entity,
			"handler" => "best_practice",
			"sort_by" => "priority",
			"class" => "elgg-menu-hz"));
	}
	
	
	$author_link = elgg_view("output/url", array(
		"text" => $owner->name,
		"href" => "best_practice/owner/" . $owner->username,
		"is_trusted" => true
	));
	$author = elgg_echo("byline", array($author_link));
	$date = elgg_view_friendly_time($entity->time_created);
	$comments = "";
	if ($comment_count = $entity->countComments()) {
		$comments = elgg_view("output/url", array(
			"text" => elgg_echo("comments") . " (" . $comment_count . ")",
			"href" => $entity->getURL() . "#comments",
			"is_trusted" => true
		));
	}
	$categories = elgg_view("output/categories", $vars);
	
	if(elgg_extract("full_view", $vars, false)) {
		// full view
		$icon = "";
		if ($entity->icontime) {
			$icon = elgg_view_entity_icon($entity, "medium");
		}
		
		// make subtitle
		$subtitle = $author . " " . $date . " " . $comments . " " . $categories;
		
		// list target audience
		$target_audience = "";
		if($entity->target_audience) {
			$target_audience = "<div>";
			$target_audience .= elgg_echo("best_practices:edit:target_audience") . ": " . elgg_view("output/text", array("value" => implode(", ", $entity->target_audience)));
			$target_audience .= "</div>";
		}
		
		// list organisation
		$organisation = "";
		if ($entity->organisation) {
			$organisation = "<div>";
			$organisation .= elgg_echo("best_practices:edit:organisation") . ": " . elgg_view("output/text", array("value" => $entity->organisation));
			$organisation .= "</div>";
		}
		
		// build summary
		$params = array(
			"entity" => $entity,
			"metadata" => $entity_menu,
			"title" => false,
			"subtitle" => $subtitle,
			"content" => $target_audience . $organisation
		);
		
		$params = $params + $vars;
		$summary = elgg_view("object/elements/summary", $params);
		
		$body = elgg_view("output/longtext", array("value" => $entity->description));
		
		echo elgg_view("object/elements/full", array(
			"summary" => $summary,
			"icon" => $icon,
			"body" => $body,
		));
		
	} else {
		// list view
		$icon = elgg_view_entity_icon($entity, "small");
		
		// make subtitle
		$subtitle = $author . " " . $date . " " . $comments . " " . $categories;
		
		// build summary
		$params = array(
			"entity" => $entity,
			"metadata" => $entity_menu,
			"subtitle" => $subtitle,
			"content" => elgg_get_excerpt($entity->description)
		);
		
		$params = $params + $vars;
		$body = elgg_view("object/elements/summary", $params);
		
		echo elgg_view_image_block($icon, $body);
	}
	