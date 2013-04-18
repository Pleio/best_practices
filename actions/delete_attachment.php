<?php

	$guid = (int) get_input("guid");
	$filename = get_input("filename");
	
	if (!empty($guid) && !empty($filename)) {
		if (($entity = get_entity($guid)) && $entity->canEdit()) {
			if(elgg_instanceof($entity, "object", BestPractice::SUBTYPE)) {
				if ($entity->deleteFileAttachment($filename)) {
					system_message(elgg_echo("best_practices:action:delete_attachment:success", array($filename)));
				} else {
					register_error(elgg_echo("best_practices:action:delete_attachment:error", array($filename)));
				}
			} else {
				register_error(elgg_echo("ClassException:ClassnameNotClass", array($guid, elgg_echo("item:object:best_practice"))));
			}
		} else {
			register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}
	
	forward(REFERER);