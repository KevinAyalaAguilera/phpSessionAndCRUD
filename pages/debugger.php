<?php
if ($_SESSION['user'] == "kayala") {
    echo '<div class="debugger">';
    echo '<form method="POST">';
    echo '<input type="submit" name="superadmin" value="superadmin"></input>';
    echo '<input type="submit" name="admin" value="admin"></input>';
    echo '<input type="submit" name="user" value="user"></input>';
    echo '<input type="submit" name="valbea" value="valbea"></input>';
    echo '<input type="submit" name="conforama" value="conforama"></input>';
    echo '</div>';
}
if (isset($_POST['superadmin'])) {
    $userROL = "superadmin";
    $_SESSION["rol"] = "superadmin";
    reload();
}
if (isset($_POST['admin'])) {
    $userROL = "admin";
    $_SESSION["rol"] = "admin";
    reload();
}
if (isset($_POST['user'])) {
    $userROL = "user";
    $_SESSION["rol"] = "user";
    reload();
}
if (isset($_POST['valbea'])) {
    $userEmpresaID = 1;
    $_SESSION["userEmpresaID"] = 1;
    reload();
}
if (isset($_POST['conforama'])) {
    $userEmpresaID = 2;
    $_SESSION["userEmpresaID"] = 2;
    reload();
}

function reload() {
    unset($_POST['superadmin']);
    unset($_POST['admin']);
    unset($_POST['user']);
    unset($_POST['valbea']);
    unset($_POST['conforama']);
    header("location: ../pages/listServices.php");
}
?>