<?php

	echo "<th>" . elgg_echo("best_practices:listing:created") . "</th>";
	echo "<th>" . elgg_echo("admin:plugins:label:author") . "</th>";
	echo "<th>" . elgg_echo("title") . "</th>";
	echo "<th>" . elgg_echo("best_practices:edit:organisation") . "</th>";
	echo "<th>" . elgg_echo("best_practices:edit:groups") . "</th>";
	echo "<th>" . elgg_echo("comments") . "</th>";
	
	if (elgg_is_active_plugin("likes")) {
		echo "<th>" . elgg_echo("best_practices:listing:likes") . "</th>";
	}