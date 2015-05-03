<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 26.04.2015
 * Time: 17:27
 */
require_once('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Verify::sessionAndAdminLoggedIn();
Alert::displayAlertFromSession($smarty);
if (isset($_POST['btnAddPost'])) {
    // Legger til inlegg i database
    $post = new Post();
    $post->setText($_POST['txtPost']);
    $post->setTitle($_POST['txtTitle']);
    $post->setAuthorEmail($_SESSION['user']->getEmail());

    // Innlegget ble lagt til i databasen
    if ($post->addToDB($db)) {
        $postID = $db->lastInsertId();
        // Hvis en fil er valgt som vedlegg
        if ($_FILES['userfile']['error'] != UPLOAD_ERR_NO_FILE) {
            // Henter ut ID til inlegget som nettop ble lagt til
            // Hvis filen som er laste opp er den som skulle lastes opp
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $attachment = new Attachment();
                $attachment->setData(file_get_contents($_FILES['userfile']['tmp_name']));
                $attachment->setPostID($postID);
                $attachment->setMIMEType($_FILES['userfile']['type']);

                // Innlegget og vedlegget ble lagt til i database uten feil
                if ($attachment->addToDB($db)) {
                    $alert = new Alert(Alert::SUCCESS, 'Inlegget og vedlegget ble lagt til.');
                    $alert->displayOnOtherPage('post.php?id=' . $postID);
                }
                // Innlegget ble lagt til uten feil, men feil oppstod med vadlegget og databasen
                else {
                    $alert = new Alert(Alert::ERROR, 'Inlegget ble lagt til, men en feil oppstod med vedlegget');
                    $alert->displayOnOtherPage('post.php?id=' . $postID);
                }
            }
            // Finner ikke riktig fil på serveren
            else {
                $alert = new Alert(Alert::ERROR, 'Filen som ble lastet opp er kanskje en del av et angrep. Kun innlegget ble lastet opp');
                $alert->displayOnOtherPage('post.php?id=' . $postID);
            }
        }
        // Inlegget ble lagt til (vedlegg ikke valgt). Sender brukeren til det nye inlegget og gir han suksessmelding.
        $alert = new Alert(Alert::SUCCESS, 'Ditt innlegg ble lagt til');
        $alert->displayOnOtherPage('post.php?id=' . $postID);
    }
    // Inlegget ble ikke lagt til i databasen på grunn av en feil
    else {
        $alert = new Alert(Alert::ERROR, 'En feil oppstod. Innlegget ble ikke lagt til.');
        $alert->displayOnIndex();
    }
}
$smarty->display('addPost.tpl');