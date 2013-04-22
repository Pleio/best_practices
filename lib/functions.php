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