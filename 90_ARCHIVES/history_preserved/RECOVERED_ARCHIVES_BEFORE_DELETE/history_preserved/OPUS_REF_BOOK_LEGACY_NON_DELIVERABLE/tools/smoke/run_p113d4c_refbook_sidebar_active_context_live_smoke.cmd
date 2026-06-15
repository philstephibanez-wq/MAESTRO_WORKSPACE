@echo off
setlocal
cd /d "%~dp0..\.."
php tools\smoke\p113d4c_refbook_sidebar_active_context_live_smoke.php
exit /b %ERRORLEVEL%
