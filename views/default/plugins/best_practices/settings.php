<?php

	$plugin = elgg_extract("entity", $vars);
	
	// target audience
	echo "<div>";
	echo "<label for='best-practices-settings-audience'>" . elgg_echo("best_practices:settings:target_audience") . "</label>";
	echo elgg_view("input/text", array("name" => "params[target_audience]", "value" => $plugin->target_audience, "id" => "best-practices-settings-audience"));
	echo "<div class='elgg-subtext'>" . elgg_echo("best_practices:settings:target_audience:description") . "</div>";
	echo "</div>";