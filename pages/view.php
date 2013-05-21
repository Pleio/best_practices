<?php

	$guid = (int) get_input("guid");
	
	if (!empty($guid)) {
		if ($entity = get_entity($guid)) {
			if (elgg_instanceof($entity, "object", BestPractice::SUBTYPE)) {
				
				$title_text = $entity->title;
				$owner = $entity->getOwnerEntity();
				
				// set page owner
				elgg_set_page_owner_guid($owner->getGUID());
				
				// build breadcrumb
				elgg_push_breadcrumb(elgg_echo("best_practices:all:title"), "best_practice/all");
				elgg_push_breadcrumb($owner->name, "best_practice/owner/" . $owner->username);
				elgg_push_breadcrumb($entity->title);
				
				// build content
				$content = elgg_view_entity($entity, array("full_view" => true));
				$content .= elgg_view_comments($entity, elgg_is_logged_in(), array("id" => "comments"));
				
				// sidebar
				$sidebar = elgg_view("best_practices/sidebar/contact", array("entity" => $entity));
				$sidebar .= elgg_view("best_practices/sidebar/target_audience", array("entity" => $entity));
				$sidebar .= elgg_view("best_practices/sidebar/links", array("entity" => $entity));
				$sidebar .= elgg_view("best_practices/sidebar/files", array("entity" => $entity));
				$sidebar .= elgg_view("best_practices/sidebar/groups", array("entity" => $entity));
				
				// build page
				$page_data = elgg_view_layout("content", array(
					"title" => $title_text,
					"content" => $content,
					"sidebar" => $sidebar,
					"filter" => false
				));
				
				// draw page
				echo elgg_view_page($entity->title, $page_data);
			} else {
				register_error(elgg_echo("ClassException:ClassnameNotClass", array($guid, elgg_echo("item:object:best_practice"))));
				forward(REFERER);
			}
		} else {
			register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
			forward(REFERER);
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
		forward(REFERER);
	}
