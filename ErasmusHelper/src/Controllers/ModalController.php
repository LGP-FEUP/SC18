<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Dbg;
use ErasmusHelper\Models\User;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class ModalController extends UniModsBackOfficeController {

    protected string $layout = "empty";

    /**
     * @throws FirebaseException
     * @throws AuthException
     */
    public function searchUsers() {
        $users = array();
        foreach ($_POST as $user) {
            $users[] = new User(json_decode($user, true));
        }
        $this->render("users.search", ["users" => $users]);
    }
}