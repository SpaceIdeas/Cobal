<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 28.04.2015
 * Time: 09:48
 */

class Alert {
     const ERROR = 0;
     const SUCCESS = 1;

    private $type;
    private $message;

    function __construct($type, $message) {
        $this->type = $type;
        $this->message = $message;
    }

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

    public function displayOnIndex() {
        $this->displayAlertOnOtherPage('index.php');
    }

    public function displayAlertOnOtherPage($url) {
        $_SESSION['alert'] = $this;
        header('Location: ' . $url );
        exit();
    }

    public static function displayAlertFromSession(Smarty $smarty) {
        if (isset($_SESSION['alert'])) {
            $alert = $_SESSION['alert'];
            $_SESSION['alert'] = null;
            $alert->displayOnThisPage($smarty);
        }
    }
}