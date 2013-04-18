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