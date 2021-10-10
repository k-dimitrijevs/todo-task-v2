<?php

if (isset($_SESSION['email']))
{
    echo "<p>" . $_SESSION['email'] . "</p>";
    echo "<a href='/logout'>Logout</a><br>";
} else {
    echo "<a href='/login'>Sign in</a><br>";
}