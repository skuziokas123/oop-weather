<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;

class GoogleApi implements DataProvider
{
    /**
     * @return Weather
     * @throws \Exception
     */
    public function getToday()
    {
        $today = $this->load(new NullWeather());
        $today->setDate(new \DateTime());

        return $today;
    }

    /**
     * @param Weather $before
     * @return Weather
     * @throws \Exception
     */
    private function load(Weather $before)
    {
        $now = new Weather();
        $base = $before->getDayTemp();
		
		$now->setDayTemp(random_int($base-5, $base+5));

		$baseNightTemp = $now->getDayTemp();

		$now->setNightTemp(random_int($baseNightTemp-10, $baseNightTemp-3));

        $now->setSky(random_int(1, 3));
		
		$beforeDateTimeMod=new \DateTime($before->getDate()->format('Y-m-d H:i:s'));
		
		$now->setDate($beforeDateTimeMod->modify('+1 day'));

        return $now;
    }
	
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
	
	private function selectAll(){
		$result = [];
        
		$record = new Weather();
        $record->setDate(new \DateTime());
        $record->setDayTemp(random_int(0, 20));
        $record->setNightTemp(random_int($record->getDayTemp()-10, $record->getDayTemp()-3));
        $record->setSky('1');
        $result[] = $record;
			
		for($i=0;$i<10;$i++){
			$result[] = $this->load($result[$i]);
            
        }
		
        return $result;
	}
	
	
	
}
