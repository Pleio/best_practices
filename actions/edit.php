<?php

	elgg_make_sticky_form("best_practice");

	$guid = (int) get_input("guid");
	$title = get_input("title");
	$description = get_input("description");
	$access_id = (int) get_input("access_id");
	
	$tags = string_to_tag_array(get_input("tags"));
	$target_audience = get_input("target_audience");
	$remove_icon = (int) get_input("remove_icon", 0);
	
	$organisation = get_input("organisation");
	
	$groups = get_input("groups");
	
	$contact_name = get_input("contact_name");
	$contact_email = get_input("contact_email");
	$contact_phone = get_input("contact_phone");
	
	$links = get_input("links");
	$file_titles = get_input("file_titles");
	
	$forward_url = REFERER;
	$edit = false;
	
	// validate required input
	$valid_input = true;
	$required_input = array(
		"title",
		"description",
		"contact_name",
		"contact_email",
		"contact_phone",
		"groups"
	);
	foreach ($required_input as $field) {
		if ($field == "groups") {
			if (!elgg_is_active_plugin("groups")) {
				// skip group requirement if groups isn't enabled
				continue;
			} elseif (best_practices_use_predefined_groups() && !best_practices_get_predefined_group_guids()) {
				// use predefined group, but none defined
				continue;
			}
		}
		
		if (!get_input($field)) {
			$valid_input = false;
			
			register_error(elgg_echo("best_practices:action:edit:error:required:" . $field));
		}
	}
	
	if ($valid_input) {
		$entity = false;
		
		if (!empty($guid)) {
			// edit entity
			if(($entity = get_entity($guid)) && $entity->canEdit()) {
				if (!elgg_instanceof($entity, "object", BestPractice::SUBTYPE)) {
					register_error("ClassException:ClassnameNotClass", array($guid, elgg_echo("item:object:best_practice")));
					unset($entity);
				} else {
					$edit = true;
				}
			} else {
				register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
				unset($entity);
			}
		} else {
			// new entity
			$entity = new BestPractice();
			
			if (!$entity->save()) {
				register_error(elgg_echo("IOException:UnableToSaveNew", array(elgg_echo("item:object:best_practice"))));
				unset($entity);
			}
		}
		
		// do stuff with the entity
		if (!empty($entity)) {
			$entity->title = $title;
			$entity->description = $description;
			$entity->access_id = $access_id;
			
			$entity->tags = $tags;
			$entity->target_audience = $target_audience;
			
			$entity->organisation = $organisation;
			
			// set related groups
			$entity->setRelatedGroups($groups);
			
			// contact information
			$entity->contact_name = $contact_name;
			$entity->contact_email = $contact_email;
			$entity->contact_phone = $contact_phone;
			
			// attachements
			// links/urls
			if (!empty($links)) {
				if(!is_array($links)) {
					$links = array($links);
				}
				
				foreach ($links as $index => $link) {
					// make sure we filter out empty values
					if(empty($link)) {
						unset($links[$index]);
					}
				}
			}
			$entity->links = $links;
			
			//files
			if (!empty($_FILES["files"])) {
				$fh = new ElggFile();
				$fh->owner_guid = $entity->getGUID();
				
				foreach ($_FILES["files"]["error"] as $index => $errorcode) {
					if ($errorcode === UPLOAD_ERR_OK) {
						// no error occured
						$filename_prefix = 0;
						$filename = $_FILES["files"]["name"][$index];
						
						// make a unique filename
						$fh->setFilename("files/" . $filename);
						while($fh->exists()) {
							$filename_prefix++;
							$fh->setFilename($filename_prefix . $filename);
						}
						
						if($filename_prefix > 0) {
							$filename = $filename_prefix . $filename;
						}
						
						// get uploaded file
						if ($contents = file_get_contents($_FILES["files"]["tmp_name"][$index])) {
							$fh->open("write");
							$fh->write($contents);
							$fh->close();
							
							$nice_name = $filename;
							if (!empty($file_titles[$index])) {
								$nice_name = $file_titles[$index];
							}
							
							$entity->addFileAttachment($nice_name, $filename, $_FILES["files"]["type"][$index]);
						}
					}
				}
			}
			
			// process icon
			if (get_uploaded_file("icon")) {
				
				if ($icon_info = elgg_get_config("icon_sizes")) {
					$fh = new ElggFile();
					$fh->owner_guid = $entity->getGUID();
					
					foreach($icon_info as $size => $info) {
						$fh->setFilename("icon/" . $size . ".jpg");
						$fh->open("write");
						$fh->write(get_resized_image_from_uploaded_file("icon", $info["w"], $info["h"], $info["square"], $info["upscale"]));
						$fh->close();
					}
					
					$entity->icontime = time();
				}
			} elseif ($edit && $remove_icon) {
				$entity->removeIcon();
			}
			
			if ($entity->save()) {
				elgg_clear_sticky_form("best_practice");
				
				// add river event
				if (!$edit) {
					add_to_river("river/object/best_practice/create", "create", $entity->getOwnerGUID(), $entity->getGUID());
				}
				
				system_message(elgg_echo("best_practices:action:edit:success"));
				
				$forward_url = $entity->getURL();
			} else {
				register_error(elgg_echo("best_practices:action:edit:error:save"));
			}
		}
	}
	
	forward($forward_url);