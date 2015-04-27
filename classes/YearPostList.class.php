<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 27/04/2015
 * Tid: 11:04
 * All Rights Reserved
 */

class YearPostList {
    //Companion array. Hjelper til i funksjonen setMonths;
    private $norwegianMonth = array("Januar","Februar","Mars","April","Mai","Juni","Juli","August","September","Oktober","November","Desember");

    private $year; //Et spesifikt årstall
    private $months; //

    function __construct($year, Array $monthsIn)
    {
        $this->year = $year;
        //Se beskrivelse av metode. $monthsIn er datoobjektene til alle innleggene i året $year
        $this->setMonths($monthsIn);
    }


    /**
     * @return mixed
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * Gjør $monthsIn som er en array av datoobjekter om til en assosiativ
     * array der månedsnavet er key og antallet datoeobjekter
     * i den spesifike måneden som value
     * @param array $monthsIn
     */
    public function setMonths(Array $monthsIn)
    {
        //Denne arrayen holder på måneden og hvor mange innlegg det er i hver måned
        $this->months = array("Januar"=>0,"Februar"=>0,"Mars"=>0,"April"=>0,"Mai"=>0,"Juni"=>0,"Juli"=>0,"August"=>0,"September"=>0,"Oktober"=>0,"November"=>0,"Desember"=>0);
        //Denne løkken legger til en i månededen i months for hver måned som er i monthsIn
        foreach($monthsIn as $monthIn){
            $this->months[$this->norwegianMonth[$monthIn['month']-1]] += 1;
        }
        //Fjerner tomme måneder slik at bare de med verdi er igjen
        for($i = 0; $i < 12; $i++){
            //Henter ut f.eks "Januar" i $months hvis $i lik 0 og  "Februar" i $months hvis $i lik 2 osv.
            //Dette gjøres ved å bruke indexen til companion arrayet $norwegianMonth
            //Fjerner måneden i $months hvis verdien er 0
            if($this->months[$this->norwegianMonth[$i]] == 0){
                unset($this->months[$this->norwegianMonth[$i]]);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }




}