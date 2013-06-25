<?php

	if ($content = elgg_get_plugin_setting("additional_text", "best_practices")) {
		echo elgg_view("output/longtext", array("value" => $content, "class" => "mbm"));
	}