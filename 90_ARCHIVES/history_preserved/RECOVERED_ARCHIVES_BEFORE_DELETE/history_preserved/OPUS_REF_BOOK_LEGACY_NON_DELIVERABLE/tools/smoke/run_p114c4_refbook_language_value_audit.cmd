@echo off
setlocal
cd /d "%~dp0\..\.."
php tools\smoke\p114c4_refbook_language_value_audit.php
exit /b %ERRORLEVEL%
