@echo off
setlocal EnableExtensions
cd /d "%~dp0..\.."
php "tools\refbook\p112q3e_refbook_reflection_contract.php"
set "EXITCODE=%ERRORLEVEL%"
echo.
echo ExitCode=%EXITCODE%
exit /b %EXITCODE%
