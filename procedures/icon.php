<?php

	$guid = (int) get_input("guid");
	$size = get_input("size", "medium");
	$filename = get_input("filename");
	
	// check headers
	$etag = md5($guid . $size . $filename);
	if (isset($_SERVER["HTTP_IF_NONE_MATCH"]) && trim($_SERVER["HTTP_IF_NONE_MATCH"]) == $etag) {
		header("HTTP/1.1 304 Not Modified");
		exit();
	}
	
	// check with the entity
	if (!empty($guid)) {
		// check if the icon size is supported
		if (($icon_sizes = elgg_get_config("icon_sizes")) && array_key_exists($size, $icon_sizes)) {
			// check if we can get a correct entity
			if (($entity = get_entity($guid)) && elgg_instanceof($entity, "object", BestPractice::SUBTYPE)) {
				// does this entity have an icon
				if ($entity->icontime) {
					$fh = new ElggFile();
					$fh->owner_guid = $entity->getGUID();
					
					$fh->setFilename("icon/" . $size . ".jpg");
					
					if($fh->exists()){
						$contents = $fh->grabFile();
						$etag = md5($guid . $size . $entity->icontime . ".jpg");
						
						header("Content-type: image/jpg");
						header("Content-length: " . strlen($contents));
						header("Expires: " . gmdate("D, d M Y H:i:s \G\M\T", strtotime("+6 months")), true);
						header("Pragma: public");
						header("Cache-Control: public");
						header("ETag: " . $etag);
						
						echo $contents;
						exit();
					}
				}
			}
		}
	}
	
	// no icon was found, so output default
	header("Content-type: image/png");
	
	echo file_get_contents(elgg_get_config("path") . "_graphics/icons/default/" . $size . ".png");
	exit();
	