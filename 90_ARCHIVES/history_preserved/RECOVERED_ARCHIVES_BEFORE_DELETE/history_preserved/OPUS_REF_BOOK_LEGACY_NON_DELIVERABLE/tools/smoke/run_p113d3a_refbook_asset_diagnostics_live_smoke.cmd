@echo off
setlocal
cd /d "%~dp0\..\.."
php tools\smoke\p113d3a_refbook_asset_diagnostics_live_smoke.php
exit /b %ERRORLEVEL%
