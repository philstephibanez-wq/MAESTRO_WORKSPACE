@echo off
setlocal EnableExtensions
cd /d "%~dp0..\.."
php "tools\recipes\p113c1_opus_refbook_global_robotized_recipe.php"
set "EXITCODE=%ERRORLEVEL%"
echo.
echo ExitCode=%EXITCODE%
exit /b %EXITCODE%
