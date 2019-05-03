<?php

namespace Weather\Service;

class FileChecker
{
	const FILE_DATA_JSON='Data.json';
	const FILE_WEATHER_JSON='Weather.json';
	
    private $validFiles = [
		self::FILE_DATA_JSON,
		self::FILE_WEATHER_JSON
    ];
	
	private $defaultFile=self::FILE_DATA_JSON;
	
	public function check($source){
		foreach($this->validFiles as $vf){
			if($vf===$source){
				return $vf;
			}
		}
		return $this->defaultFile;
	}
	
}