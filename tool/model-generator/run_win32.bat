
@rem *** Thin PHP Framework
@rem *** Run this script to generate Model Classes from your MySQL DB
@rem *** PHP MUST BE INSTALLED TO USE THIS SCRIPT

@echo off
echo --- generating MODEL CLASSES from DB...
echo.
php generate.php

echo.
echo.

rem echo.
rem xcopy /Y .\generated \..\..\app\model\

echo.
echo.
pause