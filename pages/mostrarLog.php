<?php
	include_once "../controller/controller.php";
	if (isset($userROL)) {
		include_once "./header.php";
		if ($userROL == "superadmin") {

		} else {
			header("location: ../index.php");
			exit();
		}
	} else {
		header("location: ../index.php");
		exit();
	}
?>
<div method="post" class="lineasFilter">
	<p id="notificacion"></p>
</div>

<?php
	listLog();
	include_once "./footer.php";
?>
<script>document.getElementById("header-btn-clog").classList.add("header-btn-selected")</script>