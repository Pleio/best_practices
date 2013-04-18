<?php

	function best_practices_public_pages_hook($hook, $type, $returnvalue, $params) {
		$result = $returnvalue;
		
		$result[] = "best_practice/icon/.*";
		
		return $result;
	}