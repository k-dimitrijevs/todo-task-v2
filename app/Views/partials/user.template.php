<?php

if (isset($_SESSION['email']))
{
    echo "<p>" . $_SESSION['email'] . "</p>";
    echo "<a href='/logout' class='btn btn-warning w-10'>Logout</a><br>";
} else {
    echo "<a href='/login' class='btn btn-warning w-10'>Sign in</a><br>";
}