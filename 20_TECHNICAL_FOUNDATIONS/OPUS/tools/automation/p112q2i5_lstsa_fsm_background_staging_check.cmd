@echo off
setlocal EnableExtensions
cd /d "%~dp0..\.."
php tools\automation\p112q2i5_lstsa_fsm_background_staging_recipe.php
exit /b %ERRORLEVEL%
