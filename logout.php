<?php
require 'config/constants.php';
session_destroy();
header ('location: ' .Root_URL);
die();
