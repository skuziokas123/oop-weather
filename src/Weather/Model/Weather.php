<?php

namespace Weather\Model;

class Weather
{
	private $stringToFontAwesome = [
		'Scattered Showers' => 'cloud-showers-heavy', 
		'Breezy' => 'wind',
		'Partly Cloudy' => 'cloud-sun',
		'Mostly Cloudy' => 'cloud-sun',
		'Sunny' => 'sun',
		'Cloudy' => 'cloud'

    ];
	
    private $map = [
        1 => 'cloud',
        2 => 'cloud-rain',
        3 => 'sun',
		4 => 'cloud-showers-heavy', //cloud-showers-heavy 
		5 => 'wind', //wind 
		6 => 'cloud-sun', //cloud-sun 
		7 => 'soundcloud', //soundcloud 
		//8 => 'Sunny', //sun
		//9 => 'Cloudy' //cloud

    ];

    /**
     * @var integer
     */
    protected $dayTemp;

    /**
     * @var integer
     */
    protected $nightTemp;

    /**
     * @var int
     */
    protected $sky;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @return int
     */
    public function getDayTemp(): int
    {
        return $this->dayTemp;
    }

    /**
     * @param int $dayTemp
     */
    public function setDayTemp(int $dayTemp): void
    {
        $this->dayTemp = $dayTemp;
    }

    /**
     * @return int
     */
    public function getNightTemp(): int
    {
        return $this->nightTemp;
    }

    /**
     * @param int $nightTemp
     */
    public function setNightTemp(int $nightTemp): void
    {
        $this->nightTemp = $nightTemp;
    }

    /**
     * @return int
     */
    public function getSky(): int
    {
        return $this->sky;
    }

    /**
     * @param int $sky
     */
    public function setSky(int $sky): void
    {
        $this->sky = $sky;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getSkySymbol()
    {
        return $this->map[$this->sky];
    }
	
	public function getSkySymbols(): array
    {
        return $this->map;
    }
	
	//$stringToFontAwesome
	public function getStringToFontAwesome(): array
    {
        return $this->stringToFontAwesome;
    }
}
