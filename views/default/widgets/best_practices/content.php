<?php

	$widget = elgg_extract("entity", $vars);
	
	$num_display = (int) $widget->num_display;
	if ($num_display < 1) {
		$num_display = 5;
	}
	
	$options = array(
		"type" => "object",
		"subtype" => BestPractice::SUBTYPE,
		"limit" => $num_display,
		"full_view" => false,
		"pagination" => false
	);
	
	switch ($widget->context) {
		case "groups":
			$options["relationship"] = BestPractice::GROUP_RELATIONSHIP;
			$options["relationship_guid"] = $widget->getOwnerGUID();
			$options["inverse_relationship"] = true;
			
			break;
	}
	
	if (!($contents = elgg_list_entities_from_relationship($options))) {
		$contents = elgg_echo("notfound");
	}
	
	echo $contents;