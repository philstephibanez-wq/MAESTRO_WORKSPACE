@echo off
setlocal
cd /d "%~dp0\..\.."
php tools\smoke\p114d1_refbook_doc_i18n_rest_lang_provider_smoke.php
exit /b %ERRORLEVEL%
