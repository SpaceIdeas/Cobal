<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 10.05.2015
 * Time: 19:17
 */

/**
 * Class Email Klasse som tar seg av sending av e-post til brukere om vertifisering og opprette et nytt passord.
 */
class Email {

    const VERIFY_EMAIL = 0;
    const NEW_PASSWORD = 1;

    /**
     * Sender en e-post med tekst som passer til typen e-post
     *
     * Metoden sender en html-formatert e-post med rett tekst som passer til typen e-post som skal sendes
     * Typen e-post er for eksempel en e-post for vertifisering av e-postadressen eller en e-post for å opprette et
     * nytt passord. Tokenet som tas inn som en parameter er tokenet som generes for nytt passord
     * eller vertifisering av e-post. Hele poenget med html-formateringen er at brukeren skal kunne
     * trykke på en link med et paramater for å gjennopprette et passord eller vertifisere en e-postadresse.
     *
     * @param int $type Konstant fra Email-klassen med typen e-post.
     * @param string $recipient Mottakerens e-postadresse
     * @param string $token Tokenet som skal sendes mesd e-posten
     */
    public static function send(PDO $db, $type, $recipient, $token) {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:noreply@kark.hin.no\r\n';

        $recipientUsername = User::getUsernameFromDB($db, $recipient);

        switch($type) {
            case Email::VERIFY_EMAIL:
                $message =
                    "<html>
                    <head>
                          <title>Vertifiser din e-post på Cobal-bloggen</title>
                        </head>
                        <body>
                          <p>Hei og gratulerer med din registrering på Cobal-bloggen!</p>
                          <p>Du er registrert med følgende opplysninger på bloggen:</p>
                          <table>
                            <tr>
                              <th>Epostadresse</th><th>Brukernavn</th>
                            </tr>
                            <tr>
                              <td>$recipient</td><td>$recipientUsername</td>
                            </tr>
                          </table>
                            <p>For å være sikker på at deg er deg øsnker vi at du trykker på linken under for å vertifisere din epostadresse</p>
                            <a href=\"kark.hin.no/~530241/webapplikasjoner/cobal/index.php?verToken=$token\">Vertifiser e-postadressen din</a>
                        </body>
                        </html>";
                mail($recipient, 'Vertifiser din e-post på Cobal-bloggen', $message, $headers);
                break;
            case Email::NEW_PASSWORD:
                $message =
                    "<html>
                    <head>
                          <title>Nytt passord på Cobal-bloggen</title>
                        </head>
                        <body>
                          <p>Du er registrert med følgende opplysninger på bloggen:</p>
                          <table>
                            <tr>
                              <th>Epostadresse</th><th>Brukernavn</th>
                            </tr>
                            <tr>
                              <td>$recipient</td><td>$recipientUsername</td>
                            </tr>
                          </table>
                            <p>Trykk på linken under for å opprette et nytt passord</p>
                            <a href=\"kark.hin.no/~530241/webapplikasjoner/cobal/newPassword.php?lostPwdToken=$token\">kark.hin.no/~530241/webapplikasjoner/cobal/newPassword.php?lostPwdToken=$token</a>
                        </body>
                        </html>";
                mail($recipient, 'Nytt passord på Cobal-bloggen', $message, $headers);
                break;
        }
    }
}