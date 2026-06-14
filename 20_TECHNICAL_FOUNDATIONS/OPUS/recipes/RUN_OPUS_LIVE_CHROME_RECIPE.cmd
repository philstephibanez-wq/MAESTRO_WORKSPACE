@echo off
call "H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\recipes\RUN_OPUS_GLOBAL_RECIPE.cmd"
if errorlevel 1 exit /b 1
if not exist "H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\chrome_extension\opus-live-tester\manifest.json" echo OPUS_LIVE_CHROME_RECIPE_FAILED_EXTENSION_MANIFEST_MISSING
if not exist "H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\chrome_extension\opus-live-tester\manifest.json" exit /b 1
if not exist "H:\UwAmp\www\OPUS_REF_BOOK\index.php" echo OPUS_LIVE_CHROME_RECIPE_FAILED_REFBOOK_INDEX_MISSING
if not exist "H:\UwAmp\www\OPUS_REF_BOOK\index.php" exit /b 1
set CHROME_EXE=
if exist "%ProgramFiles%\Google\Chrome\Application\chrome.exe" set CHROME_EXE=%ProgramFiles%\Google\Chrome\Application\chrome.exe
if exist "%ProgramFiles(x86)%\Google\Chrome\Application\chrome.exe" set CHROME_EXE=%ProgramFiles(x86)%\Google\Chrome\Application\chrome.exe
if "%CHROME_EXE%"=="" echo OPUS_LIVE_CHROME_RECIPE_FAILED_CHROME_EXE_MISSING
if "%CHROME_EXE%"=="" exit /b 1
mkdir "H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\var\chrome-profile" 2>nul
"%CHROME_EXE%" --new-window --user-data-dir="H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\var\chrome-profile" --load-extension="H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\chrome_extension\opus-live-tester" "http://127.0.0.1/OPUS_REF_BOOK/?theme=night&lang=en"
echo OPUS_LIVE_CHROME_RECIPE_LAUNCHED
