<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 28.04.2015
 * Time: 09:48
 */

/**
 * Class Alert er en klasse laget for å gi feilmeldinger og suksessmeldinger til brukeren.
 *
 * Klassen gir utviklere en mer objektsorienter måte å vise meldinger til brukeren.
 * Klassen benytter seg av både smarty og sesjoner for å fungere. Hver side på bloggen inneholder en felles header.tpl.
 * Inne i denne header.tpl inkluderes alert.tpl som viser et bootstrap-alert hvis en smarty-variabel er satt.
 * Dermed trenger en utvikler kun å benytte seg av metodene i denne klassen for å vise feilmeldinger på nåværende
 * eller andre sider. Sesjonsvariabler benyttes for å vise feilmeldinger på andre sider enn nåværende. Alert tar seg
 * ogsåav å sende brukeren til den andre siden hvor meldingen skal vises. Klassen tar seg også håndteringen med
 * å sette og fjerne sesjonsvariabler.
 *
 */
class Alert {
     const ERROR = 0; // Feilmelding - rød
     const SUCCESS = 1; // Suksess - grønn

    private $type;
    private $message;

    /**
     * Konstruktor for Alert-klassen.
     *
     * @param $type int Typen advarsel, error eller succcess. Definert som konstanter i Alert-klassen.
     * @param $message string teksten til advarselen.
     * @
     */
    function __construct($type, $message) {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Metoden viser et Alert på siden man er på ved hjelp av sidens smarty-objekt.
     *
     * @param Smarty $smarty Sidens smarty-objekt
     */
    public function displayOnThisPage(Smarty $smarty) {
        switch($this->type) {
            case Alert::ERROR:
                $smarty->assign('errorMessage', $this->message);
                break;
            case Alert::SUCCESS:
                $smarty->assign('successMessage', $this->message);
                break;
        }
    }

    /**
     * Metoden viser Alert på index.php
     */
    public function displayOnIndex() {
        $this->displayOnOtherPage('index.php');
    }

    /**
     * Metoden viser Alert på en annen side og sender brukern til denne siden.
     *
     * @param $url
     */
    public function displayOnOtherPage($url) {
        // Legger til alert i session slik at man kan få tak i det på en annen side
        $_SESSION['alert'] = $this;
        // Sender bruker avgårde til siden
        header('Location: ' . $url );
        exit();
    }

    /**
     * Metoden viser Alert satt i sesjonsobjektet. Dvs. Alerts fra andre sider.
     *
     * @param Smarty $smarty
     */
    public static function displayAlertFromSession(Smarty $smarty) {
        // Sjekker om alert er satt
        if (isset($_SESSION['alert'])) {
            $alert = $_SESSION['alert'];
            // Fjerner alert fra session siden det nå skal vises og ikke trengs mer.
            unset($_SESSION['alert']);
            // Kjører metoden for å vise alert
            $alert->displayOnThisPage($smarty);
        }
    }

    /**
     * Metoden fjerner Alert-objektet fra sesjonen, slik at man ikke får et alert to ganger.
     */
    public function removeFromSession() {
        unset($_SESSION['alert']);
    }
}