@echo off
setlocal EnableExtensions

set "ASAP_ROOT=H:\ASAP"
set "REFBOOK_ROOT=H:\ASAP_REF_BOOK"
set "WORKSPACE_ROOT=H:\MAESTRO_WORKSPACE"
set "PATCH_ROOT=%WORKSPACE_ROOT%\patches\P114N2_REFBOOK_CONSUME_ASAP_I18N"

if not exist "%WORKSPACE_ROOT%" mkdir "%WORKSPACE_ROOT%"
if not exist "%WORKSPACE_ROOT%\patches" mkdir "%WORKSPACE_ROOT%\patches"
if not exist "%PATCH_ROOT%" mkdir "%PATCH_ROOT%"
if not exist "%PATCH_ROOT%\backup" mkdir "%PATCH_ROOT%\backup"
if not exist "%PATCH_ROOT%\reports" mkdir "%PATCH_ROOT%\reports"

if not exist "%ASAP_ROOT%\framework\Asap\RefBook\I18n\RefBookDocumentationI18nCatalog.php" (
  echo P114N2_ASAP_I18N_CATALOG_MISSING
  exit /b 1
)

if not exist "%REFBOOK_ROOT%\application\reference\Controller\AbstractRefBookController.php" (
  echo P114N2_REFBOOK_ABSTRACT_CONTROLLER_MISSING
  exit /b 1
)

if not exist "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php" (
  echo P114N2_REFBOOK_RUNTIME_REPOSITORY_MISSING
  exit /b 1
)

copy /Y "%REFBOOK_ROOT%\application\reference\Controller\AbstractRefBookController.php" "%PATCH_ROOT%\backup\AbstractRefBookController.php.bak" >nul
copy /Y "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php" "%PATCH_ROOT%\backup\ReferenceRuntimeSnapshotRepository.php.bak" >nul

php "%~dp0p114n2_refbook_consume_asap_i18n.php"
if errorlevel 1 exit /b 1

php -l "%REFBOOK_ROOT%\application\reference\Controller\AbstractRefBookController.php"
if errorlevel 1 exit /b 1

php -l "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php"
if errorlevel 1 exit /b 1

php "%~dp0p114n2_refbook_consume_asap_i18n_smoke.php"
if errorlevel 1 exit /b 1

git -C "%ASAP_ROOT%" status --short > "%PATCH_ROOT%\reports\asap_status_after.txt"
git -C "%REFBOOK_ROOT%" status --short > "%PATCH_ROOT%\reports\refbook_status_after.txt"

echo P114N2_REFBOOK_CONSUME_ASAP_I18N_APPLY_OK
echo REPORT=%PATCH_ROOT%\reports
exit /b 0
