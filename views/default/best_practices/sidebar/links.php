<?php

	if ($entity = elgg_extract("entity", $vars)) {
		$links = $entity->links;
		
		if(!empty($links)) {
			if(!is_array($links)) {
				$links = array($links);
			}
			
			$content = "";
			foreach($links as $link) {
				$content .= "<div>";
				$content .= elgg_view_icon("link", "mrs");
				$content .= elgg_view("output/url", array("value" => $link));
				$content .= "</div>";
			}
			
			echo elgg_view_module("aside", elgg_echo("best_practices:sidebar:links:title"), $content);
		}
	}