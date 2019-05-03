<?php

namespace Weather\Service;

class SourceChecker
{
	const SOURCE_GOOGLEAPI='GoogleApi';
	const SOURCE_DBREPOSITORY='DbRepositry';
	
    private $validSource = [
		SELF::SOURCE_GOOGLEAPI,
		SELF::SOURCE_DBREPOSITORY
    ];
	
	private $defaultSource=SELF::SOURCE_DBREPOSITORY;
	
	public function check($source){
		foreach($this->validSource as $vs){
			if($vs===$source){
				return $vs;
			}
		}
		return $this->defaultSource;
	}
	
}