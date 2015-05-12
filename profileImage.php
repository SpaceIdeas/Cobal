<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 06.05.2015
 * Time: 14:20
 *
 * Dette scriptet er laget for å returnere profilbilder som kan brukes i en <img> tag.
 * Meningen er at man skal kunne sende med id til comment eller post og få ut en link til profilbildet som ligger
 * i databasen til forfatteren av posten eller kommentaren.

 */
require_once('config.php');
require_once('db.php');

    // Profilbildet til forfatteren av en post skal hentes ut.
    if (isset($_GET['postID'])) {
        $post = Post::getPost($db, $_GET['postID']);
        // Denne metoden returener et ProfileImage som samsvarer med forfatteren.
        $profileImage = ProfileImage::getProfileImage($db, $post->getAuthorEmail());
        // ProfileImage er kun ikke null, hvis brukeren har et profilbilde.
        if (isset($profileImage)) {
            header("Content-Type:" . $profileImage->getMIMEType());
            echo($profileImage->getPicture());
        }
        // Returnerer en link til deafult-profilbildet hvis et profilbilde ikke ble funnet
        else {
            header("Location: img/DefaultProfilePic.jpg");
            die();
        }
    }
    // Profilbildet til forfatteren av en kommentar skal hentes ut.
    elseif(isset($_GET['commentID'])) {
            $comment = Comment::getCommentByID($db, $_GET['commentID']);
            // Denne metoden returener et ProfileImage som samsvarer med forfatteren.
            $profileImage = ProfileImage::getProfileImage($db, $comment->getAuthorEmail());
        // ProfileImage er kun ikke null, hvis brukeren har et profilbilde.
            if (isset($profileImage)) {
                header("Content-Type:" . $profileImage->getMIMEType());
                echo($profileImage->getPicture());
            }
            // Returnerer en link til deafult-profilbildet hvis et profilbilde ikke ble funnet
            else {
                header("Location: img/DefaultProfilePic.jpg");
                die();
            }
        }