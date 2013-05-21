<?php

	$entity = elgg_extract("entity", $vars);
	$target_audience_options = elgg_extract("target_audience_options", $vars, false);
	$use_predefined_groups = (bool) elgg_extract("use_predefined_groups", $vars, false);
	$group_guids = elgg_extract("group_guids", $vars);
	
	$has_icon = false;
	
	if (!empty($entity)) {
		$title = elgg_get_sticky_value("best_practice", "title", $entity->title);
		$description = elgg_get_sticky_value("best_practice", "description", $entity->description);
		$access_id = (int) elgg_get_sticky_value("best_practice", "access_id", $entity->access_id);
		
		$tags = elgg_get_sticky_value("best_practice", "tags", $entity->tags);
		$target_audience = elgg_get_sticky_value("best_practice", "target_audience", $entity->target_audience);
		
		$groups = elgg_get_sticky_value("best_practice", "groups", $entity->getRelatedGroups(true));
		
		$contact_name = elgg_get_sticky_value("best_practice", "contact_name", $entity->contact_name);
		$organisation = elgg_get_sticky_value("best_practice", "organisation", $entity->organisation);
		$contact_email = elgg_get_sticky_value("best_practice", "contact_email", $entity->contact_email);
		$contact_phone = elgg_get_sticky_value("best_practice", "contact_phone", $entity->contact_phone);
		
		$links = elgg_get_sticky_value("best_practice", "links", $entity->links);
		$files = $entity->getAttachedFiles();
		
		if ($entity->icontime) {
			$has_icon = true;
		}
		
		$submit_text = elgg_echo("update");
		
		echo elgg_view("input/hidden", array("name" => "guid", "value" => $entity->getGUID()));
	} else {
		$title = elgg_get_sticky_value("best_practice", "title");
		$description = elgg_get_sticky_value("best_practice", "description");
		$access_id = (int) elgg_get_sticky_value("best_practice", "access_id", get_default_access());
		
		$tags = elgg_get_sticky_value("best_practice", "tags");
		$target_audience = elgg_get_sticky_value("best_practice", "target_audience");
		
		$groups = elgg_get_sticky_value("best_practice", "groups");
		
		$contact_name = elgg_get_sticky_value("best_practice", "contact_name");
		$organisation = elgg_get_sticky_value("best_practice", "organisation");
		$contact_email = elgg_get_sticky_value("best_practice", "contact_email");
		$contact_phone = elgg_get_sticky_value("best_practice", "contact_phone");
		
		$links = elgg_get_sticky_value("best_practice", "links");
		$files = array();
		
		$submit_text = elgg_echo("save");
	}
	
	elgg_clear_sticky_form("best_practice");
	
	echo "<div>";
	echo "<label for='best-practice-form-edit-title'>" . elgg_echo("title") . "*</label>";
	echo elgg_view("input/text", array("name" => "title", "value" => $title, "id" => "best-practice-form-edit-title"));
	echo "</div>";
	
	echo "<div>";
	echo "<label for='best-practice-form-edit-icon'>" . elgg_echo("best_practices:edit:icon") . "</label>";
	echo elgg_view("input/file", array("name" => "icon", "id" => "best-practice-form-edit-icon"));
	if ($has_icon) {
		echo "<div class='elgg-subtext'>" . elgg_echo("best_practices:edit:icon:description") . "</div>";
		echo elgg_view("input/checkbox", array("name" => "remove_icon", "value" => 1));
		echo elgg_echo("best_practices:edit:icon:remove");
	}
	echo "</div>";
	
	echo "<div>";
	echo "<label for='best-practice-form-edit-description'>" . elgg_echo("description") . "*</label>";
	echo elgg_view("input/longtext", array("name" => "description", "value" => $description, "id" => "best-practice-form-edit-description"));
	echo "</div>";
	
	echo "<div>";
	echo "<label for='best-practice-form-edit-tags'>" . elgg_echo("tags") . "</label>";
	echo elgg_view("input/tags", array("name" => "tags", "value" => $tags, "id" => "best-practice-form-edit-tags"));
	echo "</div>";
	
	if (!empty($target_audience_options)) {
		echo "<div>";
		echo "<label for='best-practice-form-edit-target-audience'>" . elgg_echo("best_practices:edit:target_audience") . "</label>";
		echo elgg_view("input/checkboxes", array("name" => "target_audience", "value" => $target_audience, "id" => "best-practice-form-edit-target-audience", "options" => $target_audience_options, "align" => "horizontal"));
		echo "</div>";
	}
	
	// support for site categories
	echo elgg_view("input/categories", $vars);
	
	if (elgg_is_active_plugin("groups")) {
		if ($use_predefined_groups) {
			if ($group_guids) {
				$options = array(
					"guids" => $group_guids,
					"limit" => false
				);
				
				if ($predefined_groups = elgg_get_entities($options)) {
					$group_options = array();
					
					foreach($predefined_groups as $pre_group) {
						$group_options[$pre_group->name] = $pre_group->getGUID();
					}
					
					echo "<div>";
					echo "<label for='best-practice-form-edit-groups-checkbox'>" . elgg_echo("best_practices:edit:groups") . "*</label>";
					echo elgg_view("input/checkboxes", array("name" => "groups", "value" => $groups, "id" => "best-practice-form-edit-groups-checkbox", "options" => $group_options, "align" => "horizontal"));
					echo "</div>";
				}
			}
		} else {
			// use autocomplete group selection
			elgg_load_js("jquery.ui.autocomplete.html");
			
			echo "<div>";
			echo "<label for='best-practice-form-edit-groups'>" . elgg_echo("best_practices:edit:groups") . "*</label>";
			echo elgg_view("input/text", array("id" => "best-practice-form-edit-groups"));
			echo "<div class='elgg-subtext'>" . elgg_echo("best_practices:edit:groups:description") . "</div>";
			echo "<div id='best-practice-form-edit-groups-result' class='ptm'>";
			
			if (!empty($groups)) {
				$group_list_options = array(
					"guids" => $groups,
					"limit" => false
				);
				if ($group_entities = elgg_get_entities($group_list_options)) {
					foreach ($group_entities as $group) {
						echo elgg_view("input/hidden", array("name" => "groups[]", "value" => $group->getGUID()));
						echo elgg_view_entity($group, array("full_view" => false));
					}
				}
			}
			
			echo "</div>";
			echo "</div>";
		}
	}
	
	// contact information
	$contact = "<div>";
	$contact .= "<label for='best-practice-form-edit-contact-name'>" . elgg_echo("best_practices:edit:contact:name") . "*</label>";
	$contact .= elgg_view("input/text", array("name" => "contact_name", "value" => $contact_name, "id" => "best-practice-form-edit-contact-name"));
	$contact .= "</div>";
	
	$contact .= "<div>";
	$contact .= "<label for='best-practice-form-edit-organisation'>" . elgg_echo("best_practices:edit:organisation") . "</label>";
	$contact .= elgg_view("input/text", array("name" => "organisation", "value" => $organisation, "id" => "best-practice-form-edit-organisation"));
	$contact .= "</div>";
	
	$contact .= "<div>";
	$contact .= "<label for='best-practice-form-edit-contact-email'>" . elgg_echo("best_practices:edit:contact:email") . "*</label>";
	$contact .= elgg_view("input/email", array("name" => "contact_email", "value" => $contact_email, "id" => "best-practice-form-edit-contact-email"));
	$contact .= "</div>";
	
	$contact .= "<div>";
	$contact .= "<label for='best-practice-form-edit-contact-phone'>" . elgg_echo("profile:phone") . "*</label>";
	$contact .= elgg_view("input/text", array("name" => "contact_phone", "value" => $contact_phone, "id" => "best-practice-form-edit-contact-phone"));
	$contact .= "</div>";
	
	echo elgg_view_module("info", elgg_echo("best_practices:edit:contact"), $contact);
	
	// attachements
	// links / urls
	$attachments_links = "<div id='best-practice-form-edit-attachtments-links'>";
	$attachments_links .= "<label><span class='hidden'>" . elgg_echo("best_practices:edit:attachements:url") . "</span>";
	
	if (!empty($links)) {
		if (!is_array($links)) {
			$links = array($links);
		}
		
		foreach ($links as $link) {
			$attachments_links .= elgg_view("input/url", array("name" => "links[]", "value" => $link, "class" => "mbs"));
		}
	}
	
	$attachments_links .= elgg_view("input/url", array("name" => "links[]", "class" => "mbs"));
	$attachments_links .= "</label>";
	$attachments_links .= "</div>";
	
	echo elgg_view_module("info", elgg_echo("best_practices:edit:attachements:url"), $attachments_links);
	
	// files
	$attachments_files = "<div id='best-practice-form-edit-attachtments-files'>";
	
	if (!empty($files)) {
		$attachments_files .= "<div>";
		
		foreach($files as $info) {
			$info = json_decode($info);
			
			$attachments_files .= "<div class='elgg-discover'>";
			$attachments_files .= elgg_view("output/url", array("text" => elgg_view_icon("download", "mrs") . $info[0], "href" => "best_practice/attachment/" . $entity->getGUID() . "/" . $info[1]));
			$attachments_files .= elgg_view("output/confirmlink", array(
				"text" => elgg_view_icon("delete"),
				"href" => "action/best_practices/delete_attachment?guid=" . $entity->getGUID() . "&filename=" . urlencode($info[1]),
				"class" => "mls elgg-discoverable"
			));
			$attachments_files .= "</div>";
		}
		
		$attachments_files .= "</div>";
	}
	
	$attachments_files .= "<div>";
	$attachments_files .= "<label>" . elgg_echo("best_practices:edit:attachements:file:title");
	$attachments_files .= elgg_view("input/text", array("name" => "file_titles[]", "class" => "mbs"));
	$attachments_files .= "</label>";
	
	$attachments_files .= "<label>" . elgg_echo("best_practices:edit:attachements:file");
	$attachments_files .= elgg_view("input/file", array("name" => "files[]", "class" => "mbs"));
	$attachments_files .= "</label>";
	
	$attachments_files .= "</div>";
	$attachments_files .= "</div>";
	
	echo elgg_view_module("info", elgg_echo("best_practices:edit:attachements:files"), $attachments_files);
	
	// access
	echo "<div>";
	echo "<label for='best-practice-form-edit-acccess'>" . elgg_echo("access") . "</label>";
	echo "<br />";
	echo elgg_view("input/access", array("name" => "access_id", "value" => $access_id, "id" => "best-practice-form-edit-access"));
	echo "</div>";
	
	echo "<div class='elgg-foot'>";
	echo elgg_view("input/submit", array("value" => $submit_text));
	echo "</div>";
	
	echo "<div class='elgg-quiet'>";
	echo elgg_echo("best_practices:edit:required");
	echo "</div>";
	