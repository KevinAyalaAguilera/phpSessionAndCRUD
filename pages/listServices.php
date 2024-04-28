<?php
include_once "../controller/controller.php";
if (isset($_SESSION["rol"])) {
	include_once "./header.php";
} else {
	header("location: ../index.php");
    exit();
}

listServices();
include_once "./footer.php";
//include_once "./debugger.php";
include_once "./excelrepartobuttons.php";

?>
<script>
	setTimeout(document.getElementById("header-btn-clist").classList.add("header-btn-selected"), 1000);
</script>