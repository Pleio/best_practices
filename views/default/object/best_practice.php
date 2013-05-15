<?php

	$entity = elgg_extract("entity", $vars);
	$list_type = elgg_extract("list_type", $vars);
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
			$target = $entity->target_audience;
			if (!is_array($target)) {
				$target = array($target);
			}
			
			$target_audience = "<div>";
			$target_audience .= elgg_echo("best_practices:edit:target_audience") . ": " . elgg_view("output/text", array("value" => implode(", ", $target)));
			$target_audience .= "</div>";
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
		// how to show the listing
		if (!empty($list_type) && ($list_type == "table")) {
			// table view
			$title_link = elgg_view("output/url", array("text" => $entity->title, "href" => $entity->getURL(), "is_trusted" => true));
			echo "<td rel='title'>" . $title_link . "</td>";
			
			// groepen
			$group_list = "&nbsp;";
			if($groups = $entity->getRelatedGroups()) {
				$group_list = array();
				foreach ($groups as $group) {
					$group_list[] = elgg_view("output/url", array("text" => $group->name, "href" => "best_practice/group/" . $group->getGUID() . "/all", "is_trusted" => true));
				}
				
				$group_list = implode(", ", $group_list);
			}
			echo "<td rel='groups'>" . $group_list . "</td>";
			
			$target_audience = "&nbsp;";
			if ($entity->target_audience) {
				$target = $entity->target_audience;
				if (!is_array($target)) {
					$target = array($target);
				}
				
				$target_audience = implode(", ", $target);
			}
			echo "<td rel='target_audience'>" . $target_audience . "</td>";
			
			echo "<td rel='author'>" . $author_link . "</td>";
			echo "<td rel='organisation'>" . $entity->organisation . "</td>";
			echo "<td rel='tags'>" . elgg_view("output/tags", array("value" => $entity->tags)) . "</td>";
			echo "<td rel='created' class='best-practices-nowrap'>" . date(elgg_echo("best_practices:listing:date_format"), $entity->time_created) . "</td>";
			
			$comments = elgg_view("output/url", array("text" => $comment_count . "&nbsp;" . elgg_view_icon("speech-bubble"), "href" => $entity->getURL() . "#comments", "is_trusted" => true));
			echo "<td class='best-practices-nowrap'>" . $comments . "</td>";
			
			// likes, if available
			if (elgg_is_active_plugin("likes")) {
				$likes_count = likes_count($entity);
				$likes_link = elgg_view("likes/button", array("entity" => $entity));
				
				echo "<td class='best-practices-nowrap'>" . $likes_count . "&nbsp;" . $likes_link . "</td>";
			}
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
	}
	