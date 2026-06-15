@echo off
setlocal
cd /d "%~dp0\..\.."
php tools\smoke\p114c3u_refbook_czech_runtime_and_header_force_static_smoke.php
exit /b %ERRORLEVEL%
