<?php

if (isset($_SESSION['username']))
{
    echo "<p>" . $_SESSION['username'] . "</p>";
    echo "<a href='/logout'>Logout</a><br>";
} else {
    echo "<a href='/login'>Sign in</a><br>";
}