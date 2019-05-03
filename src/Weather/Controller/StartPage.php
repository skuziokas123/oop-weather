<?php

namespace Weather\Controller;

use Weather\Manager;
use Weather\Model\NullWeather;

class StartPage
{
	private $checkedSource;
	private $checkedFromFile;
	
	public function __construct($checkedSource, $checkedFromFile){
		$this->checkedSource=$checkedSource;
		$this->checkedFromFile=$checkedFromFile;
	}
	
    public function getTodayWeather(): array
    {
        try {
            $service = new Manager($this->checkedSource, $this->checkedFromFile);
            $weather = $service->getTodayInfo();
        } catch (\Exception $exp) {
            $weather = new NullWeather();
        }

        return ['template' => 'today-weather.twig', 'context' => ['weather' => $weather]];
    }

    public function getWeekWeather(): array
    {
        try {
            $service = new Manager($this->checkedSource, $this->checkedFromFile);
            $weathers = $service->getWeekInfo();
        } catch (\Exception $exp) {
            $weathers = [];
        }

        return ['template' => 'range-weather.twig', 'context' => ['weathers' => $weathers]];
    }
}
