<?php

	class BestPractice extends ElggObject {
		const SUBTYPE = "best_practice";
		const GROUP_RELATIONSHIP = "related";
		
		public function initializeAttributes() {
			parent::initializeAttributes();
			
			$this->subtype = self::SUBTYPE;
		}
		
		/**
		 * @todo make this work
		 * @see ElggEntity::getIconURL()
		 */
		public function getIconURL($size = "medium") {
			$result = false;
			
			if ($this->icontime) {
				$result = "best_practice/icon/" . $this->getGUID() . "/" . $size . "/" . $this->icontime . ".jpg";
			} else {
				$result = parent::getIconURL($size);
			}
			
			return $result;
		}
		
		public function getURL() {
			return "best_practice/view/" . $this->getGUID() . "/" . elgg_get_friendly_title($this->title);
		}
		
		public function removeIcon() {
			$result = false;
			
			if ($this->icontime) {
				if ($icon_info = elgg_get_config("icon_sizes")) {
					$fh = new ElggFile();
					$fh->owner_guid = $this->getGUID();
						
					foreach($icon_info as $size => $info) {
						$fh->setFilename("icon/" . $size . ".jpg");
						$fh->delete();
					}
						
					unset($this->icontime);
					$result = true;
				}
			}
			
			return $result;
		}
		
		public function addFileAttachment($nice_name, $filename, $mime_type = "") {
			$files = $this->files;
			
			if(empty($files)) {
				$files = array();
			} elseif (!is_array($files)) {
				$files = array($files);
			}
			
			$files[] = json_encode(array($nice_name, $filename, $mime_type));
			
			return $this->files = $files;
		}
		
		public function getAttachedFiles() {
			$result = false;
			
			if ($files = $this->files) {
				if (!is_array($files)) {
					$files = array($files);
				}
				
				$result = $files;
			}
			
			return $result;
		}
		
		public function deleteFileAttachment($filename) {
			$result = false;
			
			if ($files = $this->getAttachedFiles()) {
				foreach ($files as $index => $info) {
					$info = json_decode($info);
					
					if($info[1] == $filename) {
						$fh = new ElggFile();
						$fh->owner_guid = $this->getGUID();
						
						$fh->setFilename("files/" . $filename);
						
						if($fh->exists()) {
							$fh->delete();
						}
						
						unset($files[$index]);
						$result = true;
						break;
					}
				}
				
				if($result) {
					$this->files = $files;
				}
			}
			
			return $result;
		}
		
		public function getAttachedFileInformation($filename) {
			$result = false;
				
			if ($files = $this->getAttachedFiles()) {
				foreach ($files as $info) {
					if ($info = json_decode($info, true)) {
						$result = $info;
					}
				}
			}
				
			return $result;
		}
		
		public function setRelatedGroups($group_guids) {
			if ($this->getGUID()) {
				// first remove all related groups
				remove_entity_relationships($this->getGUID(), self::GROUP_RELATIONSHIP, false, "group");
				
				// now add the new relationships
				if (!empty($group_guids)) {
					if (!is_array($group_guids)) {
						$group_guids = array($group_guids);
					}
					
					foreach ($group_guids as $group_guid) {
						$this->addRelationship($group_guid, self::GROUP_RELATIONSHIP);
					}
				}
			}
		}
		
		public function getRelatedGroups($guid_only = false) {
			$result = false;
			
			if ($this->getGUID()) {
				$options = array(
					"type" => "group",
					"limit" => false,
					"relationship" => self::GROUP_RELATIONSHIP,
					"relationship_guid" => $this->getGUID(),
				);
				
				if ($guid_only) {
					$options["callback"] = "best_practices_row_to_guid";
				}
				
				$result = elgg_get_entities_from_relationship($options);
			}
			
			return $result;
		}
	}