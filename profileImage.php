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
            header("Content-Type:" . $profileImage->getMIMEType());
            echo($profileImage->getPicture());
        }
        else {
            header("Location: img/DefaultProfilePic.jpg");
            die();
        }
    }

    elseif(isset($_GET['commentID'])) {
            $comment = Comment::getCommentByID($db, $_GET['commentID']);
            $profileImage = ProfileImage::getProfileImage($db, $comment->getAuthorEmail());

            if (isset($profileImage)) {
                header("Content-Type:" . $profileImage->getMIMEType());
                echo($profileImage->getPicture());
            }
            else {
                header("Location: img/DefaultProfilePic.jpg");
                die();
            }
        }