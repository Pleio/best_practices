<?php

	echo "<th>" . elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("best_practices:listing:created");
	echo "<div>" . elgg_view("input/text", array("name" => "created", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th>" . elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("admin:plugins:label:author");
	echo "<div>" . elgg_view("input/text", array("name" => "author", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th>" . elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("title");
	echo "<div>" . elgg_view("input/text", array("name" => "title", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th>" . elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("best_practices:edit:organisation");
	echo "<div>" . elgg_view("input/text", array("name" => "organisation", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th>" . elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("best_practices:edit:groups");
	echo "<div>" . elgg_view("input/text", array("name" => "groups", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th>&nbsp;</th>";
	
	if (elgg_is_active_plugin("likes")) {
		echo "<th>&nbsp;</th>";
	}