<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 27/04/2015
 * Tid: 11:04
 * All Rights Reserved
 */

class YearPostList
{
    //Companion array. Hjelper til i funksjonen setMonths;
    public static $norwegianMonth = array(1 => "Januar", 2 => "Februar", 3 => "Mars", 4 => "April", 5 => "Mai", 6 => "Juni", 7 => "Juli", 8 => "August", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");
    private $year; //Et spesifikt årstall
    private $months; //

    function __construct($year, Array $monthsIn)
    {
        $this->year = $year;
        //Se beskrivelse av metode. $monthsIn er datoobjektene til alle innleggene i året $year
        $this->months = $monthsIn;
    }

    /**
     * @return mixed
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }
}
