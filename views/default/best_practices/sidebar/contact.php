<?php

	if ($entity = elgg_extract("entity", $vars)) {
		$title = elgg_echo("best_practices:sidebar:contact:title");
		
		$content = "";
		
		if ($entity->contact_name) {
			$content = elgg_view_icon("user", "mrs") . $entity->contact_name . "<br />";
		}
		
		if ($entity->contact_email) {
			$content .= elgg_view_icon("mail-alt", "mrs") . elgg_view("output/email", array("value" => $entity->contact_email)) . "<br />";
		}
		
		if ($entity->contact_phone) {
			$content .= elgg_view_icon("cell-phone", "mrs") . $entity->contact_phone;
		}
		
		if (!empty($content)) {
			echo elgg_view_module("aside", $title, $content);
		}
	}