<?php ?>
//<script>

elgg.provide("elgg.best_practices");

elgg.best_practices.init = function() {
	$("#best-practice-form-edit-attachtments-links .elgg-input-url:last").live("focus", function() {
		var $clone = $(this).clone();
		$("#best-practice-form-edit-attachtments-links").append($clone);
		
	});
	
	$("#best-practice-form-edit-attachtments-links .elgg-input-url").live("blur", function() {
		var $links = $("#best-practice-form-edit-attachtments-links .elgg-input-url").not(":last");

		if ($links.length) {
			$.each($links, function(index, elm) {
				if ($(elm).val() == "") {
					$(elm).remove();
				}
			});
		}
	});
	
	$("#best-practice-form-edit-attachtments-files .elgg-input-file:last").live("focus", function() {
		var $clone = $(this).parent().parent().clone();
		$clone.find(".elgg-input-text").attr("value", "");
		
		$("#best-practice-form-edit-attachtments-files").append($clone);
		
	});
	
	$("#best-practice-form-edit-attachtments-files .elgg-input-file").live("blur", function() {
		var $files = $("#best-practice-form-edit-attachtments-files .elgg-input-file").not(":last");

		if ($files.length) {
			$.each($files, function(index, elm) {
				if ($(elm).val() == "") {
					$(elm).parent().parent().remove();
				}
			});
		}
	});

	var $group_auto = $("#best-practice-form-edit-groups");
	if ($group_auto.length) {
		$group_auto.autocomplete({
			source: elgg.get_site_url() + "livesearch?match_on=groups",
			minLength: 2,
			html: "html",
			select: function (event, ui) {
				$("#best-practice-form-edit-groups-result").append(ui.item.label);
				$("#best-practice-form-edit-groups-result > div:last")
					.prepend("<span class='elgg-icon elgg-icon-delete float-alt'></span>")
					.append("<input type='hidden' name='groups[]' value='" + ui.item.guid + "' />")
					.removeClass("elgg-autocomplete-item");
				$group_auto.val("");

				return false;
			}
		});

		$("#best-practice-form-edit-groups-result span.elgg-icon-delete").live("click", function() {
			$(this).parent("div.elgg-image-block").remove();
		});

		$("#best-practice-form-edit-groups-result div.elgg-image-block").each(function(index, elem) {
			$hidden = $(elem).prev("input[type='hidden']");
			
			$(elem).prepend("<span class='elgg-icon elgg-icon-delete float-alt'></span>").append($hidden);
		});
	}

	$(".elgg-icon-best-practices-filter").click(function(){
		$(this).parent().find(".best-practices-filter-input").toggle();
	});

	$(".best-practices-filter-input").keyup(function() {
		elgg.best_practices.filter(this);
	});
		
}

elgg.best_practices.filter = function(elem) {
	name = $(elem).attr("name");
	val = $(elem).val();
	
	if(val == ""){
		$(".best-practices-table td[rel='" + name + "']").removeClass("hidden");
	} else {
		$(".best-practices-table td[rel='" + name + "']").each(function(){
			if($(this).text().toUpperCase().indexOf(val.toUpperCase()) >= 0) {
				$(this).removeClass("hidden");
			} else {
				$(this).addClass("hidden");
			}
		});
	}

	$(".best-practices-table tr").each(function(){
		if($(this).find("td.hidden").length > 0){
			$(this).addClass("hidden");
		} else {
			$(this).removeClass("hidden");
		}
	});
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.best_practices.init);