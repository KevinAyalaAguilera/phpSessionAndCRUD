<?php

$host    = "localhost";
$user = "root";
$pass    = "";
$db      = "php_shop_example_kev";

function connectDB() {
    global $host, $user, $pass, $db;
    $conexion = mysqli_connect($host, $user, $pass, $db);
    if (mysqli_connect_errno()) {
        echo "Error \n";
        echo "Errno: " . mysqli_connect_errno() . "\n";
        echo "Error: " . mysqli_connect_error() . "\n";
        exit;
    }

    return $conexion;
}

function disconnectDB($conexion) {
    mysqli_close($conexion);
}

function showLogIn() {
    echo '<form method="POST">';
    echo '<input type="text" placeholder="User" name="user">';
    echo '<input type="password" placeholder="Password" name="password">';
    echo '<input type="submit" name="login" value="Log in">';
    echo '</form>';
}

function logIn() {
    if (isset($_POST["login"])) {
        if ($_POST["user"] == "") errorField("User");
        else if ($_POST["password"] == "") errorField("Password");
        else {
            $conexion = connectDB();
            $sql = "SELECT * FROM users;";
            $result = $conexion->query($sql);
            while ($row = mysqli_fetch_array($result)) {
                if (($row[1] == $_POST["user"]) & ($row[2] == $_POST["password"])) {
                    $_SESSION["user"] = $row[1];
                    $_SESSION["password"] = $row[2];
                    $_SESSION["rol"] = $row[3];
                    header("location: ./pages/listProducts.php");
                    return;
                }
            }
            echo '<p>Incorrect user or password.</p>';
        }
    }
}

function listProducts() {
    if (isset($_GET["pag"])) {
        if ($_GET["pag"] == null || $_GET["pag"] == 0) $_GET["pag"] = 1;
        $pag = $_GET["pag"];
    }
    else $pag = 1;

    $conexion = connectDB();

    $limit = 3; // max items to show
    $offset = $limit * ($pag -1);

    $sql = "SELECT * FROM products";
    $result = $conexion->query($sql);
    $totalresults = 0;
    while ($row = mysqli_fetch_array($result)) {
        $totalresults++;
    }
    $maxPages = ceil($totalresults / $limit);

    $sql = "SELECT * FROM products LIMIT " . $limit . " OFFSET " . $offset . ";";
    $result = $conexion->query($sql);
    echo '<table><tr><th>ID</th><th>NAME</th><th>CATEGORY</th><th>PRICE</th><th>ORIGIN</th></tr>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $row[0] . '</td>';
        echo '<td>' . $row[1] . '</td>';
        echo '<td>' . $row[2] . '</td>';
        echo '<td>' . $row[3] . '</td>';
        echo '<td>' . $row[4] . '</td>';
        echo '</tr>';
    } 
    echo '</table>';

    $back = $pag -1;
    $next = $pag + 1;

    if (($pag != 1) & ($pag < $maxPages)) {
        echo '<div class="paginaton">';
        echo '<a href="./listProducts.php?pag=' . $back . '">back</a><br>';
        echo '<a href="./listProducts.php?pag=' . $next . '">next</a>';
        echo '</div>';
    } else if ($pag == $maxPages) {
        echo '<div class="paginaton">';
        echo '<a href="./listProducts.php?pag=' . $back . '">back</a><br>';
        echo '</div>';
    } else {
        echo '<div class="paginaton">';
        echo '<a href="./listProducts.php?pag=' . $next . '">next</a>';
        echo '</div>';
    }
    
}

function createProduct(){
    if (isset($_POST["create"])) {
        if (!isset($_POST["id"]) || $_POST["id"] == "") errorField("ID");
        else if (!isset($_POST["name"]) || $_POST["name"] == "") errorField("Name");
        else if (!isset($_POST["cat"]) || $_POST["cat"] == "") errorField("Category");
        else if (!isset($_POST["price"]) || $_POST["price"] == "") errorField("Price");
        else if (!isset($_POST["origin"]) || $_POST["origin"] == "") errorField("Origin");
        else {
            $sql = "SELECT * FROM products";
            $conexion = connectDB();
            $result = $conexion->query($sql);
            $datoDuplicado = false;
            while ($row = mysqli_fetch_array($result)) {
                if (!($datoDuplicado)) {
                    if ($row[0] == $_POST["id"]) {
                        $datoDuplicado = true;
                        echo '<p>Already exists a product with that ID.</p>';
                    } 
                    if ($row[1] == $_POST["name"]) {
                        $datoDuplicado = true;
                        echo '<p>Already exists a product with that name.</p>';
                    }
                }
            }
            if (!($datoDuplicado)) {
                echo '<p>Product created successfully.</p>';
                $sql = "INSERT INTO `products`(`id`, `name`, `category`, `price`, `origin`) VALUES ("
                . $_POST["id"] . ", "
                . "'" . $_POST["name"] . "'" . ", "
                . "'" . $_POST["cat"] . "'" . ", "
                . $_POST["price"] . ", "
                . "'" . $_POST["origin"] . "'"
                .");";
                $conexion->query($sql);
            }
        }
    }
}

function createUser(){
    if (isset($_POST["create"])) {
        if (!isset($_POST["id"]) || $_POST["id"] == "") errorField("ID");
        else if (!isset($_POST["user"]) || $_POST["user"] == "") errorField("User");
        else if (!isset($_POST["password"]) || $_POST["password"] == "") errorField("Password");
        else if (!isset($_POST["rol"]) || $_POST["rol"] == "") errorField("Rol");
        else {
            $sql = "SELECT * FROM users";
            $conexion = connectDB();
            $result = $conexion->query($sql);
            $datoDuplicado = false;
            while ($row = mysqli_fetch_array($result)) {
                if (!($datoDuplicado)) {
                    if ($row[0] == $_POST["id"]) {
                        $datoDuplicado = true;
                        echo '<p>Already exists a user with that id.</p>';
                    } 
                    if ($row[1] == $_POST["user"]) {
                        $datoDuplicado = true;
                        echo '<p>Already exists a user with that name.</p>';
                    }
                }
            }
            if (!($datoDuplicado)) {
                echo '<p>User created successfully.</p>';
                $sql = "INSERT INTO `users`(`id`, `name`, `password`, `rol`) VALUES ("
                . $_POST["id"] . ", "
                . "'" . $_POST["user"] . "'" . ", "
                . "'" . $_POST["password"] . "'" . ", "
                . "'" . $_POST["rol"] . "'"
                .");";
                $conexion->query($sql);
            }
        }
    }
}

function deleteProduct(){
    if (isset($_POST["delete"])) {
        if (isset($_POST["id"])) {
            $sql = "DELETE FROM products WHERE id = " . $_POST["id"] . ";";
            $conexion = connectDB();
            $conexion->query($sql);
        }
    }
    $sql = "SELECT * FROM products;";
    $conexion = connectDB();
    $result = $conexion->query($sql);
    echo '<table><tr><th>ID</th><th>name</th><th>category</th><th>price</th><th>origin</th><th></th></tr>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $row[0] . '</td>';
        echo '<td>' . $row[1] . '</td>';
        echo '<td>' . $row[2] . '</td>';
        echo '<td>' . $row[3] . '</td>';
        echo '<td>' . $row[4] . '</td>';
        echo '<td><form method="POST"><input type="text" hidden name="id" value="' . $row[0]
        . '"><input type="submit" class="x" value="X" name="delete"></form></td>';
        echo '</tr>';
    } 
    echo '</table>';
    if (isset($_POST["delete"])) {
        if (isset($_POST["id"])) {
            echo "<p>Deleted product with ID " . $_POST["id"] . "</p>";
        }
    }
}

function modifyProduct() {
    if (isset($_POST["modify"])) {
        if ($_POST["name"] == "") {
            showModifyProduct($_SESSION["row"]);
            errorField("Name");
        }
        else if ($_POST["cat"] == "") {
            showModifyProduct($_SESSION["row"]);
            errorField("Category");
        }
        else if ($_POST["price"] == "") {
            showModifyProduct($_SESSION["row"]);
            errorField("Price");
        }
        else if ($_POST["proc"] == "") {
            showModifyProduct($_SESSION["row"]);
            errorField("Origin");
        }
        else {
            $sql = "UPDATE `products` SET "
            . "`name`='" . $_POST["name"] ."',"
            . "`category`='" . $_POST["cat"] ."',"
            . "`price`=" . $_POST["price"] .","
            . "`origin`='" . $_POST["proc"] ."' "
            . "WHERE id = " . $_SESSION["row"][0];
            $conexion = connectDB();
            $conexion->query($sql);
            echo '<p>Product ' . $_SESSION["row"][0] . ' modified successfully.</p>';
        }
    }
    else if (isset($_POST["search"])) {
        if (isset($_POST["idMod"])) {
            $sql = "SELECT * FROM products";
            $localizada = false;
            $conexion = connectDB();
            $result = $conexion->query($sql);
            while($row = mysqli_fetch_array($result)) {
                if (!($localizada)) {
                    if ($row[0] == $_POST["idMod"]) {
                        $localizada = true;
                        $_SESSION["row"] = $row;
                        showModifyProduct($_SESSION["row"]);
                    }
                }
            }

            if(!($localizada)) {
                showSearchProduct();
                echo '<p>There are no products with id ' . $_POST["idMod"] . '</p>.';
            }
        }
        else {
            showSearchProduct();
            echo errorField("ID");
        } 
    } else {
        showSearchProduct();
    }
}

function showSearchProduct() {
    echo '<form method="POST">';
    echo '<input type="number" placeholder="ID" name="idMod">';
    echo '<input type="submit" value="search" name="search">';
    echo '</form>';
}

function showModifyProduct($product) {
    echo '<form method="POST">';
    echo '<label>ID ' . $product[0] . '</label>';
    echo '<input type="text" placeholder="(name) ' . $product[1] . '" name="name">';
    echo '<input type="text" placeholder="(category) ' . $product[2] . '" name="cat">';
    echo '<input type="number" placeholder="(price) ' . $product[3] . '" name="price">';
    echo '<input type="text" placeholder="(origin) ' . $product[4] . '" name="proc">';
    echo '<input type="submit" value="modify" name="modify">';
    echo '</form>';
}

function errorField($field) {
    echo '<p>' . $field . ' field can\'t be empty.</p>';
}

