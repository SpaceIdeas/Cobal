<?php
/**
 * Dette skriptet tar inn en ID til et blogginnlegg samt adressen til hvor brukeren skal returneres etter sletting av
 * innlegget. Innlegget slettes hvis det finnes og brukeren sendes dit han skal med suksessmelding eller eventuell
 * feilmelding.
 */
require_once ('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Verify::sessionAndAdminLoggedIn();
//Sant hvis get har de variablene som er nødvendig
if(isset($_GET['id']) && isset($_GET['return'])) {
    //Prøver å hente innlegget ut av databasen, basert på IDen gitt
    $post = Post::getPost($db, $_GET['id']);
    //Sant hvis innlegget ble funnet i databasen
    if ($post != null) {
        //Sletter innlegget og returnerer sant hvis innlegget ble vellykket slettet
        if ($post->deletePost($db)) {
            $alert = new Alert(Alert::SUCCESS, "Innlegget ble slettet.");
            $alert->displayOnIndex();
        } else {
            $alert = new Alert(Alert::ERROR, "En feil skjedde under slettingen. Jeg... hmm. Du kan kansje... nei. ");
            $alert->displayOnIndex();
        }
    } else {
        $alert = new Alert(Alert::ERROR, "Innlegget ble ikke funnet i databasen. Du får ta til takke med denne kommentaren");
        $alert->displayOnIndex();
    }
}else{
    header("Locaton: index.php");
    die();
}