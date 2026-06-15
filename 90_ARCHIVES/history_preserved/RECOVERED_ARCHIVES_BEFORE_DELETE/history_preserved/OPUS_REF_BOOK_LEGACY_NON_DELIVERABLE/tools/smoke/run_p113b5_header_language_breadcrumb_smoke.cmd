@echo off
setlocal
cd /d "%~dp0..\.."
php tools\smoke\p113b5_header_language_breadcrumb_smoke.php
exit /b %ERRORLEVEL%
