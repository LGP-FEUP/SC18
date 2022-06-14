<?php

use ErasmusHelper\App;
use ErasmusHelper\Controllers\Router;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

$authedUser = null;
try {
    $authedUser = App::getInstance()->firebase->auth->getUser(App::getInstance()->auth->getAdminUID());
} catch (AuthException|FirebaseException $e) {
    Router::route("/");
}
?>
<div class="row">
    <div class="box col-12 col-md-6">
        <div class="box-header">
            <span class="box-title">Edit your account<span>
        </div>
        <form method="POST" action="<?= Router::route('account.edit') ?>">
            <div class="box-content">
                <div class="field">
                    <div class="label">Email</div>
                    <input id="email" name="email" class="value" type="email" value="<?= $authedUser->email; ?>" required/>
                </div>
                <div class="field">
                    <div class="label">Password</div>
                    <input id="password" name="password" class="value" type="password" required/>
                </div>
                <div class="field">
                    <div class="label">Confirm Password</div>
                    <input id="password_verification" name="password_verification" class="value" type="password" required/>
                </div>
            </div>
            <div class="box-footer">
                <div class="button-group">
                    <a href="<?= Router::route('menu') ?>" class="button">Cancel</a>
                    <button id="submit" type="submit" class="button cta">Submit</button>
                    <div id="status" class="label" hidden></div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    let confirmField = document.getElementById("password_verification");
    let passwordField = document.getElementById("password");
    let emailField = document.getElementById("email");
    let submit = document.getElementById("submit");
    let status = document.getElementById("status");

    function checkEmailValidity(){
        return !!emailField.value
            .toLowerCase()
            .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
    }

    function checkPasswordMatch(){
        return passwordField.value === confirmField.value && passwordField.value !== "";

    }

    function updateSubmit() {

        if(checkEmailValidity() && checkPasswordMatch()) {
            status.setAttribute("hidden", "hidden");
            submit.removeAttribute("disabled");
        } else {
            if(!checkEmailValidity()) {
                status.innerHTML = "Email invalid.";
            } else {
                status.innerHTML = "Password invalid";
            }
            status.removeAttribute("hidden");
            submit.setAttribute("disabled", "disabled");
        }
    }

    passwordField.addEventListener("input", () => {
        updateSubmit();
    });
    confirmField.addEventListener("input", () => {
        updateSubmit();
    });
    emailField.addEventListener("input", () => {
        updateSubmit();
    });
</script>
