<?php

	function best_practices_get_friend_guids(ElggUser $user) {
		$result = false;
		
		if(!empty($user) && elgg_instanceof($user, "user")) {
			$options = array(
				"type" => "user",
				"relationship" => "friend",
				"relationship_guid" => $user->getGUID(),
				"limit" => false,
				"callback" => "best_practices_row_to_guid"
			);
			
			$result = elgg_get_entities_from_relationship($options);
		}
		
		return $result;
	}
	
	function best_practices_row_to_guid($row) {
		return (int) $row->guid;
	}
	
	/**
	 * Custom list entities
	 *
	 * @param unknown_type $entities
	 * @param unknown_type $vars
	 * @see elgg_view_entitiy_list
	 */
	function best_practices_view_entity_list($entities, $vars = array()) {
		// new function
		$defaults = array(
			"items" => $entities,
			"list_class" => "elgg-list-entity",
			"full_view" => true,
			"pagination" => true,
			"list_type" => get_input("list_type", "list"),
			"list_type_toggle" => false,
			"offset" => (int) get_input("offset", 0),
		);
		
		$vars = array_merge($defaults, $vars);
		
		switch ($vars["list_type"]) {
			case "gallery":
				return elgg_view("page/components/gallery", $vars);
				break;
			case "table":
				return elgg_view("page/components/table", $vars);
				beak;
			default:
				return elgg_view("page/components/list", $vars);
				break;
		}
	}
	
	function best_practices_use_predefined_groups() {
		static $result;
		
		if (!isset($result)) {
			$result = false;
			
			if (elgg_get_plugin_setting("use_predefined_groups", "best_practices") == "yes") {
				$result = true;
			}
		}
		
		return $result;
	}
	
	function best_practices_get_predefined_group_guids() {
		static $result;
		
		if (!isset($result)) {
			$result = false;
			
			if ($group_guids = elgg_get_plugin_setting("group_guids", "best_practices")) {
				$group_guids = explode(",", $group_guids);
				
				$result = array_filter($group_guids, create_function('$a', 'return !empty($a);'));
			}
		}
		
		return $result;
	}