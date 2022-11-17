<?php

	include '../backend/init.php';
	$_SESSION = array();
	session_destroy();
	$userObj->redirect();