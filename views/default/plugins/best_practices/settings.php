<?php

	$plugin = elgg_extract("entity", $vars);
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgG_echo("option:yes")
	);
	
	// target audience
	echo "<div>";
	echo "<label for='best-practices-settings-audience'>" . elgg_echo("best_practices:settings:target_audience") . "</label>";
	echo elgg_view("input/text", array("name" => "params[target_audience]", "value" => $plugin->target_audience, "id" => "best-practices-settings-audience"));
	echo "<div class='elgg-subtext'>" . elgg_echo("best_practices:settings:target_audience:description") . "</div>";
	echo "</div>";
	
	// use predefined group selection
	if (elgg_is_active_plugin("groups")) {
		elgg_load_js("jquery.ui.autocomplete.html");
		
		echo "<div>";
		echo "<label for='best-practices-settings-use-predefined-groups'>" . elgg_echo("best_practices:settings:use_predefined_groups") . "</label><br />";
		echo elgg_view("input/dropdown", array("name" => "params[use_predefined_groups]", "value" => $plugin->use_predefined_groups, "options_values" => $noyes_options, "id" => "best-practices-settings-use-predefined-groups"));
		echo "</div>";
		
		echo "<div>";
		echo "<label for='best-practices-settings-groups'>" . elgg_echo("best_practices:settings:groups") . "</label>";
		echo elgg_view("input/text", array("id" => "best-practices-settings-groups"));
		echo elgg_view("input/hidden", array("name" => "params[group_guids][]"));
		echo "<div class='elgg-subtext'>" . elgg_echo("best_practices:settings:groups:description") . "</div>";
		
		echo "<div id='best-practices-settings-groups-result'>";
		
		if ($group_guids = best_practices_get_predefined_group_guids()) {
			$options = array(
				"guids" => $group_guids,
				"limit" => false
			);
			
			if ($groups = elgg_get_entities($options)) {
				foreach ($groups as $group) {
					echo elgg_view("input/hidden", array("name" => "params[group_guids][]", "value" => $group->getGUID()));
					echo elgg_view_entity($group, array("full_view" => false));
				}
			}
		}
		
		echo "</div>"; // end groups result
		echo "</div>"; // end groups
	}