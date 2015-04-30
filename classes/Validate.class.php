<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 30/04/2015
 * Tid: 10:20
 * All Rights Reserved
 */

//TODO: Fikse på denne classen
class Validate
{
    /**
     * Metoden som blir kalt passordene ikke er like
     * Setter smartyvariablene som skal bli satt når passordene ikke er like
     * @param $smarty
     */
    public static function nonMatchingPasswords(Smarty $smarty)
    {
        //Varselbeskjeden til smarty når noe er galt
        $smarty->assign("errorMessage", "Passordene er ikke like");
        //Sender med ekstra css til passord input feltene, som passer til situasjonen
        $smarty->assign("passwordCSS", "has-error");
        //Sender brukernavn og email som brukeren har sendt inn, tilbake til smarty slik at de automatisk blir fylt inn for brukeren
        $smarty->assign("inputUsername", $_POST['inputUsername']);
        $smarty->assign("inputEmail", $_POST['inputEmail']);
    }

    /**
     * Metoden som blir kalt når brukeren allerede eksisterer
     * Setter smartyvariablene som passer til situasjonen
     * @param $smarty
     */
    public static function userAlreadyExists(Smarty $smarty)
    {
        //Varselbeskjeden til smarty når noe er galt
        $smarty->assign("errorMessage", "Emailen er allerede tatt");
        //Sender med ekstra css til email inputfeltene, som passer til situasjonen
        $smarty->assign("emailCSS", "has-error");
        //Sender brukernavn som brukeren har sendt inn, tilbake til smarty slik at den automatisk blir fylt inn for brukeren
        $smarty->assign("inputUsername", $_POST['inputUsername']);

    }

}