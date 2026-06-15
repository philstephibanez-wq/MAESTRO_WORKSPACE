@echo off
setlocal
cd /d "%~dp0..\.."
php tools\smoke\p113d2r_refbook_fsm_internal_api_live_smoke.php
exit /b %ERRORLEVEL%
