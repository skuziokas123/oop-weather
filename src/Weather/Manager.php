<?php

namespace Weather;

use Weather\Api\DataProvider;
use Weather\Api\DbRepository;
use Weather\Model\Weather;
use Weather\Service\SourceChecker;

class Manager
{
    /**
     * @var DataProvider
     */
    private $transporter;
	private $transporterName;
	private $checkedFromFile;
	
	public function __construct($transporterName, $checkedFromFile){
		$this->transporterName=$transporterName;
		$this->checkedFromFile=$checkedFromFile;
	}

    public function getTodayInfo(): Weather
    {
        return $this->getTransporter()->selectByDate(new \DateTime());
    }

    public function getWeekInfo(): array
    {
        return $this->getTransporter()->selectByRange(new \DateTime('midnight'), new \DateTime('+6 days'));
    }

    private function getTransporter()
    {
        if (null === $this->transporter) {
            
			if($this->transporterName===SourceChecker::SOURCE_DBREPOSITORY){
				$this->transporter = new DbRepository($this->checkedFromFile);
			}
			else{
				$class="\Weather\Api\\".$this->transporterName;
				$this->transporter = new $class();
			}
        }

        return $this->transporter;
    }
}