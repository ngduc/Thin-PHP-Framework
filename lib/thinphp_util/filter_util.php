<?php

function sanitize_str($s)
{
	return filter_var($s, FILTER_SANITIZE_STRING);
}

function sanitize_email($s)
{
	return filter_var($s, FILTER_SANITIZE_EMAIL);
}

function sanitize_url($s)
{
	return filter_var($s, FILTER_SANITIZE_URL);
}

?>