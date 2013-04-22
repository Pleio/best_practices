<?php
/**
 * Group blog module
 */

$group = elgg_get_page_owner_entity();

$all_link = elgg_view("output/url", array(
	"href" => "best_practice/group/$group->guid/all",
	"text" => elgg_echo("link:view:all"),
	"is_trusted" => true,
));

elgg_push_context("widgets");
$options = array(
	"type" => "object",
	"subtype" => BestPractice::SUBTYPE,
	"relationship" => BestPractice::GROUP_RELATIONSHIP,
	"relationship_guid" => $group->getGUID(),
	"inverse_relationship" => true,
	"limit" => 6,
	"full_view" => false,
	"pagination" => false,
);

if (!($content = elgg_list_entities_from_relationship($options))) {
	$content = "<p>" . elgg_echo("notfound") . "</p>";
}
elgg_pop_context();

$new_link = "";
if ($user_guid = elgg_get_logged_in_user_guid()) {
	$new_link = elgg_view("output/url", array(
		"href" => "best_practice/add/" . $user_guid,
		"text" => elgg_echo("best_practice:add"),
		"is_trusted" => true,
	));
}

echo elgg_view("groups/profile/module", array(
	"title" => elgg_echo("best_practices:menu:owner_block:group"),
	"content" => $content,
	"all_link" => $all_link,
	"add_link" => $new_link,
));
