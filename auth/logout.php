<?php
session_start();
session_destroy();
header("Location: ../view/login/login.php");
exit();