<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 27/04/2015
 * Tid: 11:04
 * All Rights Reserved
 */

/**
 * Class YearPostList Blir brukt for å holde dataen som blir vist i postList.tpl
 */
class YearPostList
{

    /**
     * @var array $norwegianMonth   Hjelpe array. Hjelper til for å oversette fra måneds tall til navn
     * @var int $year               Et spesifikt årstall
     * @var array $months           En array med key=måneden(Norsk navn) value=Antall innlegg denne måneden
     */
    public static $norwegianMonth = array(1 => "Januar", 2 => "Februar", 3 => "Mars", 4 => "April", 5 => "Mai", 6 => "Juni", 7 => "Juli", 8 => "August", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");
    private $year;
    private $months;

    function __construct($year, Array $monthsIn)
    {
        $this->year = $year;
        $this->months = $monthsIn;
    }

    public function getMonths()
    {
        return $this->months;
    }

    public function getYear()
    {
        return $this->year;
    }
}
