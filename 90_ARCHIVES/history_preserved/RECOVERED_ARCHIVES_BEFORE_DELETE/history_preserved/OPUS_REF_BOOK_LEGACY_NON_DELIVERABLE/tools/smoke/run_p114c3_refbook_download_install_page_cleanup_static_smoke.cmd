@echo off
setlocal
cd /d "%~dp0\..\.."
php tools\smoke\p114c3_refbook_download_install_page_cleanup_static_smoke.php
exit /b %ERRORLEVEL%
