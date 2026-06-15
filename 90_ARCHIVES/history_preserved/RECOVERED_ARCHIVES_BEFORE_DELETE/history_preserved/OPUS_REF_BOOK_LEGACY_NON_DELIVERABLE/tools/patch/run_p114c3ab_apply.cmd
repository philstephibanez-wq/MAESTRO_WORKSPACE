@echo off
setlocal
cd /d "%~dp0\..\.."
php tools\patch\p114c3ab_apply.php
exit /b %ERRORLEVEL%
