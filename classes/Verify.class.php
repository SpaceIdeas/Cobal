<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 28/04/2015
 * Tid: 09:46
 * All Rights Reserved
 */

class Verify {

    /**
     * Redirigerer bruker til index.php og logget han ut hvis sessionen til brukeren er kapret
     */
    public static function session()
    {
        if (isset($_SESSION['user'])) {   //Sjekker om en bruker er logget in
            if(!$_SESSION['user']->verifyUser()){ //Hvis verifyUser() returnerer falskt er sessionene kapret
                unset($_SESSION['loggedin']);
                unset($_SESSION['user']);
                //TODO: Set inn en alert som gir beskjed om situasjonen
                $alert = new Alert(Alert::ERROR, "Sessionen er kapret og du har blitt logget ut. Husk å bruke beskyttelse");
                $alert->displayOnIndex();
            }
        }
    }

    /**
     * Redirigerer bruker til login.php hvis bruker ikke er logget inn
     */
    public static function userLoggedIn()
    {
        if (!isset($_SESSION['user'])) {   //Hvis en bruker ikke er logget inn, vil han bli sent til login.php
            //Lagrer siden brukeren er på nå slik at han kan bli redirigert hit etter han har logget inn
            $_SESSION['returnPage'] = $_SERVER['REQUEST_URI'];
            $alert = new Alert(Alert::ERROR, "Du er nøtt til å være logget inn for å se den siden. Ikke prøv deg på noe.");
            $alert->displayOnOtherPage('login.php');

        }
    }

    /**
     * Redirigerer bruker til index.php hvis bruker ikke er admin
     */
    public static function adminLoggedIn(){
        if (!isset($_SESSION['user']) ||  !$_SESSION['user']->isAdmin()) {   //Hvis en bruker ikke er logget inn eller han ikke er admin, vil han bli sent til login.php
            //Lagrer siden brukeren er på nå slik at han kan bli redirigert hit etter han har logget inn
            //TODO: Set inn en alert som gir beskjed om situasjonen
            $alert = new Alert(Alert::ERROR, "Du er nødt til å være administrator for å se den siden. Du er ikke administrator.");
            $alert->displayOnIndex();

        }
    }

    /**
     * Se Verify::session() og Verify::userLoggedIn()
     */
    public static function sessionAndUserLoggedIn(){
        Verify::session();
        Verify::userLoggedIn();
    }

    /**
     * Se Verify::session() og Verify::adminLoggedIn()
     */
    public static function sessionAndAdminLoggedIn(){
        Verify::session();
        Verify::adminLoggedIn();
    }

}
