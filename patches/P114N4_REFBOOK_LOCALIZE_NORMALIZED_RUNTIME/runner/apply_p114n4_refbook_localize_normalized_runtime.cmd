@echo off
setlocal EnableExtensions

set "ASAP_ROOT=H:\ASAP"
set "REFBOOK_ROOT=H:\ASAP_REF_BOOK"
set "WORKSPACE_ROOT=H:\MAESTRO_WORKSPACE"
set "PATCH_ROOT=%WORKSPACE_ROOT%\patches\P114N4_REFBOOK_LOCALIZE_NORMALIZED_RUNTIME"

if not exist "%WORKSPACE_ROOT%" mkdir "%WORKSPACE_ROOT%"
if not exist "%WORKSPACE_ROOT%\patches" mkdir "%WORKSPACE_ROOT%\patches"
if not exist "%PATCH_ROOT%" mkdir "%PATCH_ROOT%"
if not exist "%PATCH_ROOT%\backup" mkdir "%PATCH_ROOT%\backup"
if not exist "%PATCH_ROOT%\reports" mkdir "%PATCH_ROOT%\reports"

if not exist "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php" (
  echo P114N4_REFBOOK_RUNTIME_REPOSITORY_MISSING
  exit /b 1
)

copy /Y "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php" "%PATCH_ROOT%\backup\ReferenceRuntimeSnapshotRepository.php.bak" >nul

php "%~dp0p114n4_refbook_localize_normalized_runtime.php"
if errorlevel 1 exit /b 1

php -l "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php"
if errorlevel 1 exit /b 1

php "%~dp0p114n4_refbook_localize_normalized_runtime_smoke.php"
if errorlevel 1 exit /b 1

git -C "%ASAP_ROOT%" status --short > "%PATCH_ROOT%\reports\asap_status_after.txt"
git -C "%REFBOOK_ROOT%" status --short > "%PATCH_ROOT%\reports\refbook_status_after.txt"

echo P114N4_REFBOOK_LOCALIZE_NORMALIZED_RUNTIME_APPLY_OK
echo REPORT=%PATCH_ROOT%\reports
exit /b 0
