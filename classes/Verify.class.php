<?php

/**
 * Class Verify Klassen består av statiske metoder som vertifiserer diverse ting angående brukeren.
 * f.eks at sessionen er bevart eller at bruker er logget inn.
 * Hvis kravene ikke er oppfylt vil en Alert bli kjørt
 */
class Verify {

    /**
     * Redirigerer bruker til index.php og logget han ut hvis sessionen til brukeren er kapret
     */
    public static function session()
    {
        //Sjekker om en bruker er logget in
        if (isset($_SESSION['user'])) {
            //Hvis verifyUser() returnerer falskt er sessionene kapret
            if(!$_SESSION['user']->verifyUser()){
                unset($_SESSION['user']);
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
        //Hvis en bruker ikke er logget inn, vil han bli sent til login.php
        if (!isset($_SESSION['user'])) {
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
        //Hvis en bruker ikke er logget inn eller han ikke er admin, vil han bli sent til login.php
        if (!isset($_SESSION['user']) ||  !$_SESSION['user']->isAdmin()) {
            //Lagrer siden brukeren er på nå slik at han kan bli redirigert hit etter han har logget inn
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
