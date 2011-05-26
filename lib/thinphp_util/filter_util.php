<?php

function sanitizeString($s)
{
	return filter_var($s, FILTER_SANITIZE_STRING);
}

function sanitizeEmail($s)
{
	return filter_var($s, FILTER_SANITIZE_EMAIL);
}

function sanitizeUrl($s)
{
	return filter_var($s, FILTER_SANITIZE_URL);
}
