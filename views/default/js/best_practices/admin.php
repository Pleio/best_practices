<?php ?>
//<script>

elgg.provide("elgg.best_practices_admin");

elgg.best_practices_admin.init = function() {
	
	// admin group autocomplete
	var $group_auto = $("#best-practices-settings-groups");
	if ($group_auto.length) {
		$group_auto.autocomplete({
			source: elgg.get_site_url() + "livesearch?match_on=groups",
			minLength: 2,
			html: "html",
			select: function (event, ui) {
				$("#best-practices-settings-groups-result").append(ui.item.label);
				$("#best-practices-settings-groups-result > div:last")
				.prepend("<span class='elgg-icon elgg-icon-delete float-alt'></span>")
				.append("<input type='hidden' name='params[group_guids][]' value='" + ui.item.guid + "' />")
				.removeClass("elgg-autocomplete-item");
				$group_auto.val("");
	
				return false;
			}
		});
	
		$("#best-practices-settings-groups-result span.elgg-icon-delete").live("click", function() {
			$(this).parent("div.elgg-image-block").remove();
		});
	
		$("#best-practices-settings-groups-result div.elgg-image-block").each(function(index, elem) {
			$hidden = $(elem).prev("input[type='hidden']");
				
			$(elem).prepend("<span class='elgg-icon elgg-icon-delete float-alt'></span>").append($hidden);
		});
	}
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.best_practices_admin.init);