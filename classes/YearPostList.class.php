<?php
/**
 * Class YearPostList Blir brukt for å holde dataen som blir vist i postList.tpl
 */
class YearPostList
{

    /**
     * @var array $norwegianMonth   Hjelpe array. Hjelper til for å oversette fra måneds tall til navn
     */
    public static $norwegianMonth = array(1 => "Januar", 2 => "Februar", 3 => "Mars", 4 => "April", 5 => "Mai", 6 => "Juni", 7 => "Juli", 8 => "August", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");
    /**
     * @var int $year               Et spesifikt årstall
     */
    private $year;
    /**
     * @var array $months           En array med key=måneden(Norsk navn) value=Antall innlegg denne måneden
     */
    private $months;

    /**
     * Konstruktøren til YearPostList
     *
     * @param int $year
     * @param array $monthsIn
     */
    function __construct($year, Array $monthsIn)
    {
        $this->year = $year;
        $this->months = $monthsIn;
    }

    /**
     * Henter arrayen med key=måneden(Norsk navn) value=Antall innlegg denne måneden
     *
     * @return array
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * Henter året
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }
}
