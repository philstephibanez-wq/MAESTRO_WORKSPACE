@echo off
REM P113B7_REFBOOK_THEME_SELECTOR smoke launcher.
REM Reads the local RefBook source tree only; writes nothing and requires no Apache/UwAmp runtime.
setlocal
cd /d "%~dp0\..\.."
php tools\smoke\p113b7_theme_selector_smoke.php
endlocal
