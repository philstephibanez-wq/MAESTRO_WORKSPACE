@echo off
setlocal EnableExtensions
cd /d "%~dp0..\.."
php "tools\smoke\p112q3e4_refbook_http_metadata_smoke.php"
set "EXITCODE=%ERRORLEVEL%"
echo.
echo ExitCode=%EXITCODE%
exit /b %EXITCODE%
