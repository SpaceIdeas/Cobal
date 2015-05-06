<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 06.05.2015
 * Time: 14:20
 */
// Brukeren har valgt å vise vedlegg
require_once('db.php');
require_once('config.php');
    if (isset($_GET['postID'])) {

        $post = POST::getPost($db, $_GET['postID']);
        $profileImage = ProfileImage::getProfileImage($db, $post->getAuthorEmail());
        if (isset($profileImage)) {
            header("Content-Type:image/jpeg");
            echo($profileImage->getPicture());
        }
}