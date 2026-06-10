@echo off
setlocal EnableExtensions

set "REFBOOK_ROOT=H:\ASAP_REF_BOOK"
set "PATCH_ROOT=H:\MAESTRO_WORKSPACE\patches\P114N2_REFBOOK_CONSUME_ASAP_I18N"

if not exist "%PATCH_ROOT%\backup\AbstractRefBookController.php.bak" (
  echo P114N2_ROLLBACK_ABSTRACT_BACKUP_MISSING
  exit /b 1
)

if not exist "%PATCH_ROOT%\backup\ReferenceRuntimeSnapshotRepository.php.bak" (
  echo P114N2_ROLLBACK_REPOSITORY_BACKUP_MISSING
  exit /b 1
)

copy /Y "%PATCH_ROOT%\backup\AbstractRefBookController.php.bak" "%REFBOOK_ROOT%\application\reference\Controller\AbstractRefBookController.php" >nul
copy /Y "%PATCH_ROOT%\backup\ReferenceRuntimeSnapshotRepository.php.bak" "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php" >nul

php -l "%REFBOOK_ROOT%\application\reference\Controller\AbstractRefBookController.php"
if errorlevel 1 exit /b 1

php -l "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php"
if errorlevel 1 exit /b 1

git -C "%REFBOOK_ROOT%" status --short

echo P114N2_ROLLBACK_OK
exit /b 0
