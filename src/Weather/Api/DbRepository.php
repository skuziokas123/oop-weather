<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;
use Weather\Service\FileChecker;

class DbRepository implements DataProvider
{
	
	private $checkedFromFile;
	
	public function __construct($checkedFromFile){
		$this->checkedFromFile=$checkedFromFile;
	}
	
    /**
     * @param \DateTime $date
     * @return Weather
     */
    public function selectByDate(\DateTime $date): Weather
    {
        $items = $this->selectAll();
        $result = new NullWeather();

        foreach ($items as $item) {
            if ($item->getDate()->format('Y-m-d') === $date->format('Y-m-d')) {
                $result = $item;
            }
        }

        return $result;
    }

    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $items = $this->selectAll();
        $result = [];

        foreach ($items as $item) {
            if ($item->getDate() >= $from && $item->getDate() <= $to) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @return Weather[]
     */
    private function selectAll(): array
    {
        $result = [];
		
		$data=$this->loadDataFromFile($this->checkedFromFile);
		
        foreach ($data as $item) {
			
            $record = new Weather();
			//if($this->checkedFromFile==="Weather.json"){
			//FileChecker
			if($this->checkedFromFile===FileChecker::FILE_WEATHER_JSON){
				$this->prepareWeatherCustom($record, $item);
			}
			else{
				$this->prepareWeatherDefault($record, $item);
			}
            
            $result[] = $record;
        }

        return $result;
    }
	
	private function prepareWeatherCustom($record, $item){
		
		$record->setDate(new \DateTime($item['date']));
        $record->setDayTemp($item['high']);
        $record->setNightTemp($item['low']);
			
		$skyItemNameTrimed=trim($item['text']);
		
		$skyTranslatedToFontAwesome=$this->getSkyTranslatedToFontAwesome($skyItemNameTrimed, $record->getStringToFontAwesome());
			
		$skyItemNameTranslatedToId=$this->getSkyTranslatedToId($skyTranslatedToFontAwesome, $record->getSkySymbols());
		
        $record->setSky($skyItemNameTranslatedToId);
		
		return $record;
	}
	
	private function prepareWeatherDefault($record, $item){
		$record->setDate(new \DateTime($item['date']));
        $record->setDayTemp($item['dayTemp']);
        $record->setNightTemp($item['nightTemp']);
			
        $record->setSky($item['sky']);
		
		return $record;
	}
	
	private function getSkyTranslatedToFontAwesome($skyText, $textsTofontsAwesome){
		$skyTranslatedToFontAwesome=$skyText;
		foreach($textsTofontsAwesome as $key=>$value){
			if($skyText===$key){
				$skyTranslatedToFontAwesome=$value;
			}
		}
		return $skyTranslatedToFontAwesome;
		
	}
	
	private function getSkyTranslatedToId($skyText, $weatherSkySymbols){
		$skyTranslatedToId=$skyText;
		foreach($weatherSkySymbols as $key=>$value){
			if($skyText===$value){
				$skyTranslatedToId=$key;
			}
		}
		return $skyTranslatedToId;
		
	}
	
	//FileChecker
	//private function loadDataFromFile($fileName='Data.json'): array
	private function loadDataFromFile($fileName): array
    {
		$data = json_decode(
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Db' . DIRECTORY_SEPARATOR . $fileName),
            true
        );
		return $data;
	}
}
