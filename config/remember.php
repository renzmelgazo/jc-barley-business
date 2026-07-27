<?php

function generateRememberToken()
{
    return bin2hex(random_bytes(32));
}

function generateSelector()
{
    return bin2hex(random_bytes(12));
}