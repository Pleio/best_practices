<?php

	elgg_load_js("stupidtable");
	
	echo "<th data-sort='string-ins' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
	echo elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("title");
	echo "<div>" . elgg_view("input/text", array("name" => "title", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";

	echo "<th data-sort='string-ins' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
	echo elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("best_practices:edit:groups");
	echo "<div>" . elgg_view("input/text", array("name" => "groups", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th data-sort='string-ins' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
	echo elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("best_practices:edit:target_audience");
	echo "<div>" . elgg_view("input/text", array("name" => "target_audience", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th data-sort='string-ins' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
	echo elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("best_practices:listing:author");
	echo "<div>" . elgg_view("input/text", array("name" => "author", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th data-sort='string-ins' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
	echo elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("best_practices:edit:organisation");
	echo "<div>" . elgg_view("input/text", array("name" => "organisation", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th data-sort='string-ins' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
	echo elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("tags");
	echo "<div>" . elgg_view("input/text", array("name" => "tags", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th data-sort='string-ins' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
	echo elgg_view_icon("best-practices-filter", "float-alt") . elgg_echo("best_practices:listing:created");
	echo "<div>" . elgg_view("input/text", array("name" => "created", "class" => "best-practices-filter-input")) . "</div>";
	echo "</th>";
	
	echo "<th class='best-practices-align-right best-practices-sortable' data-sort='int' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
	echo elgg_view_icon("speech-bubble") . "</th>";
	
	if (elgg_is_active_plugin("likes")) {
		echo "<th class='best-practices-align-right best-practices-sortable' data-sort='int' class='best-practices-sortable' title='" . htmlspecialchars(elgg_echo("best_practices:listing:sortable"), ENT_QUOTES, "UTF-8", false) . "'>";
		echo elgg_view_icon("thumbs-up") . "</th>";
	}