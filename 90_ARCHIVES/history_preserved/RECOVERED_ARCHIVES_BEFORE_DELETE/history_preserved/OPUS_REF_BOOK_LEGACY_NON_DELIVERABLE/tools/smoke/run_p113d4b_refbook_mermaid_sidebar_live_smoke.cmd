@echo off
setlocal
cd /d "%~dp0..\.."
php tools\smoke\p113d4b_refbook_mermaid_sidebar_live_smoke.php
exit /b %ERRORLEVEL%
