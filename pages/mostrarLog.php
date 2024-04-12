<?php
	include_once "../controller/controller.php";
	if (isset($userROL)) {
		include_once "./header.php";
		if ($userROL == "superadmin") {

		} else {
			header("location: ../index.php");
		}
	} else header("location: ../index.php");
?>
<div method="post" class="lineasFilter">
	<p id="notificacion"></p>
</div>
<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" fill="cyan" class="bi bi-person-circle" viewBox="0 0 16 16">
	<path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z"/>
    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1"/>
</svg>

<?php
	listLog();
	include_once "./footer.php";
?>
<script>document.getElementById("header-btn-clog").classList.add("header-btn-selected")</script>
