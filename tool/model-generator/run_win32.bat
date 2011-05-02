
@rem *** Thin PHP Framework
@rem *** Run this script to generate Model Classes from your MySQL DB
@rem *** PHP MUST BE INSTALLED TO USE THIS SCRIPT

@echo off
echo.
echo --- NOTE: 'env' (app_config.php) must be set to use DB_PDO_MYSQL in order to run this tool!
echo.
echo --- Generating MODEL CLASSES from MYSQL DB...
echo.
php generate.php

echo.
echo.

rem -- echo --- copying generated class to /app/model/
rem -- xcopy /Y .\generated \..\..\app\model\

echo.
echo.
pause