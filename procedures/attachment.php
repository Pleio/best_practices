<?php

	$guid = (int) get_input("guid");
	$filename = get_input("filename");
	
	if (!empty($guid) && !empty($filename)) {
		if (($entity = get_entity($guid)) && elgg_instanceof($entity, "object", BestPractice::SUBTYPE)) {
			$file_info = $entity->getAttachedFileInformation($filename);
			
			$fh = new ElggFile();
			$fh->owner_guid = $entity->getGUID();
			
			$fh->setFilename("files/" . $filename);
			
			if ($fh->exists()) {
				if ($contents = $fh->grabFile()) {
					if (!empty($file_info) && !empty($file_info[2])) {
						header("Content-type: " . $file_info[2]);
					} elseif ($mime = $fh->detectMimeType()) {
						header("Content-type: " . $mime);
					}
					header("Content-Disposition: attachment; filename=\"$filename\"");
					
					echo $contents;
					exit();
				} else {
					register_error(elgg_echo("best_practices:attachtment:no_content"));
				}
			} else {
				register_error(elgg_echo("best_practices:attachtment:not_found"));
			}
		} else {
			register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}
	
	forward(REFERER);