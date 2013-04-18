<?php

	$guid = (int) get_input("guid");
	
	$forward_url = REFERER;
	
	if (!empty($guid)) {
		if (($entity = get_entity($guid)) && $entity->canEdit()) {
			if(elgg_instanceof($entity, "object", BestPractice::SUBTYPE)) {
				$title = $entity->title;
				
				if ($entity->delete()) {
					$forward_url = "best_practice/all";
					system_message(elgg_echo("entity:delete:success", array($title)));
				} else {
					register_error(elgg_echo("entity:delete:fail", array($title)));
				}
			} else {
				register_error(elgg_echo("ClassException:ClassnameNotClass", array($guid, elgg_echo("item:object:best_practice"))));
			}
		} else {
			register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}
	
	forward($forward_url);