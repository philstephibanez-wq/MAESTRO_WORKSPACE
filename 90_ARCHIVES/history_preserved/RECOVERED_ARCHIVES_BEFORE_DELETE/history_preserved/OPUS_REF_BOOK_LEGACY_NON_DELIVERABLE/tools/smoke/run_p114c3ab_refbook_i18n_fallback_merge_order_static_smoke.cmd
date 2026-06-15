@echo off
setlocal
cd /d "%~dp0\..\.."
php tools\smoke\p114c3ab_refbook_i18n_fallback_merge_order_static_smoke.php
exit /b %ERRORLEVEL%
