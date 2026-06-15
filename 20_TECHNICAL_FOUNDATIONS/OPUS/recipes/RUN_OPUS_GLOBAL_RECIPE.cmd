@echo off
call "%~dp0RUN_OPUS_WORKSPACE_LAYOUT_GUARD.cmd"
if errorlevel 1 exit /b 1
call "H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\recipes\RUN_OPUS_UNIT_RECIPE.cmd"
if errorlevel 1 exit /b 1
if not exist "H:\OPUS\config" echo OPUS_GLOBAL_RECIPE_FAILED_CONFIG_MISSING
if not exist "H:\OPUS\config" exit /b 1
if not exist "H:\OPUS\framework\Opus" echo OPUS_GLOBAL_RECIPE_FAILED_FRAMEWORK_CORE_MISSING
if not exist "H:\OPUS\framework\Opus" exit /b 1
if not exist "H:\OPUS\packages\opus-8.1.0-lysenko-reference-book\opus-package.json" echo OPUS_GLOBAL_RECIPE_FAILED_REFBOOK_PACKAGE_MANIFEST_MISSING
if not exist "H:\OPUS\packages\opus-8.1.0-lysenko-reference-book\opus-package.json" exit /b 1
if not exist "H:\OPUS\sites" echo OPUS_GLOBAL_RECIPE_FAILED_SITES_ROOT_MISSING
if not exist "H:\OPUS\sites" exit /b 1
if not exist "H:\OPUS\var" echo OPUS_GLOBAL_RECIPE_FAILED_VAR_ROOT_MISSING
if not exist "H:\OPUS\var" exit /b 1
if not exist "H:\OPUS\vendor" echo OPUS_GLOBAL_RECIPE_FAILED_VENDOR_MISSING
if not exist "H:\OPUS\vendor" exit /b 1
if exist "H:\OPUS\DOC" echo OPUS_GLOBAL_RECIPE_FAILED_DOC_MUST_STAY_WORKSPACE_ONLY
if exist "H:\OPUS\DOC" exit /b 1
if exist "H:\OPUS\tools" echo OPUS_GLOBAL_RECIPE_FAILED_TOOLS_MUST_STAY_WORKSPACE_ONLY
if exist "H:\OPUS\tools" exit /b 1
git -C H:\OPUS status --short --branch
echo OPUS_GLOBAL_RECIPE_OK
