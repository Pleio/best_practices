<?php

	function best_practices_public_pages_hook($hook, $type, $returnvalue, $params) {
		$result = $returnvalue;
		
		$result[] = "best_practice/icon/.*";
		
		return $result;
	}
	
	function best_practices_register_menu_owner_block_hook($hook, $type, $returnvalue, $params) {
		$result = $returnvalue;
		
		if (!empty($params) && is_array($params)) {
			$entity = elgg_extract("entity", $params);
			
			if (elgg_instanceof($entity, "user")) {
				$result[] = ElggMenuItem::factory(array(
					"name" => "best_practices",
					"text" => elgg_echo("best_practices:menu:owner_block:user"),
					"href" => "best_practice/owner/" . $entity->username,
					"is_trusted" => true
				));
			} elseif (elgg_instanceof($entity, "group")) {
				$result[] = ElggMenuItem::factory(array(
					"name" => "best_practices",
					"text" => elgg_echo("best_practices:menu:owner_block:group"),
					"href" => "best_practice/group/" . $entity->getGUID(),
					"is_trusted" => true
				));
			}
		}
		
		return $result;
	}