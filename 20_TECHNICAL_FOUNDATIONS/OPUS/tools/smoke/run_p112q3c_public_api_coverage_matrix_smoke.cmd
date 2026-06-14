@echo off
setlocal
cd /d "%~dp0..\.."
php tools\smoke\p112q3c_public_api_coverage_matrix_smoke.php
set EXITCODE=%ERRORLEVEL%
echo.
echo ExitCode=%EXITCODE%
pause
exit /b %EXITCODE%
