<?php

	$english = array(
		// general
		'item:object:best_practice' => "Best practice",
		'best_practice:add' => "Add Best practice",
		
		// menu
		'best_practices:menu:site' => "Best practices",
		'best_practices:menu:owner_block:user' => "Best practices",
		'best_practices:menu:owner_block:group' => "Group best practices",
		
		// pages
		'best_practices:all:title' => "Best practices",
		
		'best_practices:add:title' => "New best practice",
		'best_practices:edit:title' => "Edit best practice: %s",
		
		'best_practices:edit:icon' => "Upload an icon",
		'best_practices:edit:icon:description' => "You can upload a new icon for this Best practice of leave it blank to keep the current icon",
		'best_practices:edit:icon:remove' => "Remove the current icon",
		'best_practices:edit:target_audience' => "Target audience",
		'best_practices:edit:organisation' => "Organisation",
		'best_practices:edit:groups' => "Related groups",
		'best_practices:edit:contact' => "Contact information",
		'best_practices:edit:contact:name' => "Contact person",
		'best_practices:edit:contact:email' => "E-mail address",
		'best_practices:edit:attachements:url' => "Links",
		'best_practices:edit:attachements:files' => "Files",
		'best_practices:edit:attachements:file:title' => "Filename",
		'best_practices:edit:attachements:file' => "Upload a new file",
		'best_practices:edit:required' => "Fields marked with a * are required",
		
		'best_practices:friends:title' => "%s friends' best practices",
		
		'best_practices:group:title' => "%s' best practices",
		
		'best_practices:owner:title:mine' => "My best practices",
		'best_practices:owner:title' => "%s' best practices",
		
		'best_practices:listing:author' => "Created by",
		'best_practices:listing:created' => "Created",
		'best_practices:listing:likes' => "Likes",
		'best_practices:listing:date_format' => "Y-m-d",
		
		// widget
		'best_practices:widget:title' => "Best practices",
		'best_practices:widget:description' => "List the latest best practices within the group",
		
		// plugin settings
		'best_practices:settings:target_audience' => "Define the target audience options",
		'best_practices:settings:target_audience:description' => "You can supply a comma seperated list of options for the target audience to be chosen when creating/editing a Best practice",
		
		// procedures
		'best_practices:attachtment:not_found' => "The attachtment could not be found",
		'best_practices:attachtment:no_content' => "The attachment doesn't seam to have any content",
		
		// sidebar
		'best_practices:sidebar:contact:title' => "Contact information",
		'best_practices:sidebar:files:title' => "Files",
		'best_practices:sidebar:groups:title' => "Related groups",
		'best_practices:sidebar:links:title' => "Links",
		
		// river
		'river:create:object:default' => "%s created a best practice %s",
		
		// actions
		// delete attachment
		'best_practices:action:delete_attachment:error' => "An unknown error occured while deleting the attachment %s, please try again",
		'best_practices:action:delete_attachment:success' => "The attachment %s was deleted",
		
		// edit
		'best_practices:action:edit:error:required:title' => "Please provide a title in order to continue",
		'best_practices:action:edit:error:required:description' => "Please provide a description in order to continue",
		'best_practices:action:edit:error:required:contact_name' => "Please provide a contact person in order to continue",
		'best_practices:action:edit:error:required:contact_email' => "Please provide a contact email in order to continue",
		'best_practices:action:edit:error:required:contact_phone' => "Please provide a contact phonenumber in order to continue",
		'best_practices:action:edit:error:required:groups' => "Please relate at least one group in order to continue",
		'best_practices:action:edit:error:save' => "An unknown error occured while saving the best practice",
		'best_practices:action:edit:success' => "The best practice was saved successfully",
		
	);
	
	add_translation("en", $english);