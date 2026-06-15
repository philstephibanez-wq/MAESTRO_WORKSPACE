@echo off
setlocal
cd /d "%~dp0\..\.."
php tools\patch\p114c3u_apply.php
exit /b %ERRORLEVEL%
