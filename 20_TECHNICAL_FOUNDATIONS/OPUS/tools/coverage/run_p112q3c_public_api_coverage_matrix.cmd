@echo off
setlocal
cd /d "%~dp0..\.."
php tools\coverage\p112q3c_public_api_coverage_matrix.php
set EXITCODE=%ERRORLEVEL%
echo.
echo ExitCode=%EXITCODE%
pause
exit /b %EXITCODE%
