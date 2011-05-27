
@rem *** Thin PHP Framework
@rem *** Run this script to generate Model Classes from your MySQL DB
@rem *** PHP MUST BE INSTALLED TO USE THIS SCRIPT!!!

@echo off
echo.
echo --- NOTE: set 'env' (app_config.php) to use DB_PDO_MYSQL first!!
echo --- NOTE: also verify your MySQL DB, Tables.
echo.
echo --- Generating MODEL CLASSES from MYSQL DB...
echo.

echo Delete old files:
del generated\*.*

php generate.php

echo.
echo.

echo Generated files:
echo.
dir /b generated\

	rem -- echo --- copying generated class to /app/model/
	rem -- xcopy /Y .\generated \..\..\app\model\

echo.
echo.
pause