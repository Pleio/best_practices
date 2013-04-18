<?php

	function best_practices_page_handler($page) {
		
		switch ($page[0]) {
			case "add":
				include(dirname(dirname(__FILE__)) . "/pages/edit.php");
				break;
			case "edit":
				if (isset($page[1])) {
					set_input("guid", $page[1]);
				}
				
				include(dirname(dirname(__FILE__)) . "/pages/edit.php");
				break;
			case "friends":
				include(dirname(dirname(__FILE__)) . "/pages/friends.php");
				break;
			case "group":
				include(dirname(dirname(__FILE__)) . "/pages/group.php");
				break;
			case "owner":
				include(dirname(dirname(__FILE__)) . "/pages/owner.php");
				break;
			case "view":
				if (isset($page[1])) {
					set_input("guid", $page[1]);
				}
				include(dirname(dirname(__FILE__)) . "/pages/view.php");
				break;
			case "icon":
				// format is /best_practice/icon/[guid]/[icon]/[icontime].jpg
				if (isset($page[1])) {
					set_input("guid", $page[1]);
				}
				
				if(isset($page[2])) {
					set_input("size", $page[2]);
				}
				
				if(isset($page[3])) {
					set_input("filename", $page[3]);
				}
				
				include(dirname(dirname(__FILE__)) . "/procedures/icon.php");
				break;
			case "attachment":
				// format is /best_practice/attachment/[guid]/[filename]
				if (isset($page[1])) {
					set_input("guid", $page[1]);
				}
				
				if(isset($page[2])) {
					set_input("filename", $page[2]);
				}
				
				include(dirname(dirname(__FILE__)) . "/procedures/attachment.php");
				break;
			case "all":
			default:
				include(dirname(dirname(__FILE__)) . "/pages/all.php");
				break;
		}
	}