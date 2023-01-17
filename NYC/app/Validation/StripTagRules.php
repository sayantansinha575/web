<?php

namespace App\Validation;

class StripTagRules
{
	public function stripTag(string $str, string $fields, array $data)
	{
		$content = $data['body'];
		if (!empty(strip_tags($content))) {
            return true;
        } else {
            return false;
        }
	}
}	