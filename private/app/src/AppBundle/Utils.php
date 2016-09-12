<?php
namespace AppBundle;

class Utils
{
	public static function linearize($string)
	{
		$string = trim($string);
		$string = preg_replace(array(
				"/\r?\n/",
				'/\s\s+/',
				"/(\r\n|\n\r|\n|\r|\t)/"
		), '', $string);
	
		return $string;
	}
}