<?php

	if ($entity = elgg_extract("entity", $vars)) {
		if ($files = $entity->getAttachedFiles()) {
			$can_edit = $entity->canEdit();
			
			$content = "";
			
			foreach ($files as $file) {
				$info = json_decode($file);
				
				$content .= "<div class='elgg-discover'>";
				$content .= elgg_view("output/url", array("text" => elgg_view_icon("download", "mrs") . $info[0], "href" => "best_practice/attachment/" . $entity->getGUID() . "/" . $info[1]));
				if($can_edit) {
					$content .= elgg_view("output/confirmlink", array(
						"text" => elgg_view_icon("delete"),
						"href" => "action/best_practices/delete_attachment?guid=" . $entity->getGUID() . "&filename=" . urlencode($info[1]),
						"class" => "mls elgg-discoverable"
					));
				}
				$content .= "</div>";
			}
			
			echo elgg_view_module("aside", elgg_echo("best_practices:sidebar:files:title"), $content, array("id" => "best-practices-sidebar-files"));
		}
	}