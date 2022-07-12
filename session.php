<?php
session_id("session1");
session_start();

echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
session_write_close();
?>
