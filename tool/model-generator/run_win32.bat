
@rem *** Thin PHP Framework
@rem *** Run this script to generate Model Classes from your MySQL DB
@rem *** PHP MUST BE INSTALLED TO USE THIS SCRIPT

@echo off
echo --- generating MODEL CLASSES from MYSQL DB...
echo.
php generate.php

echo.
echo.

rem -- // copy generated class
rem -- // echo.
rem -- // xcopy /Y .\generated \..\..\app\model\

echo.
echo.
pause