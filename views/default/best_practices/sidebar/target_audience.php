<?php

	$entity = elgg_extract("entity", $vars);
	
	if ($entity->target_audience) {
		$title = elgg_echo("best_practices:edit:target_audience");
		
		$target_audience = $entity->target_audience;
		if (!is_array($target_audience)) {
			$target_audience = array($target_audience);
		}
		
		$content = elgg_view("output/text", array("value" => implode(", ", $target_audience)));
		
		echo elgg_view_module("aside", $title, $content);
	}