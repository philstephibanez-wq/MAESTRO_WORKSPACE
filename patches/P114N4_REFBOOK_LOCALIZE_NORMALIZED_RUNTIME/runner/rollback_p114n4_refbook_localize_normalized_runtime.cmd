@echo off
setlocal EnableExtensions

set "REFBOOK_ROOT=H:\ASAP_REF_BOOK"
set "PATCH_ROOT=H:\MAESTRO_WORKSPACE\patches\P114N4_REFBOOK_LOCALIZE_NORMALIZED_RUNTIME"

if not exist "%PATCH_ROOT%\backup\ReferenceRuntimeSnapshotRepository.php.bak" (
  echo P114N4_ROLLBACK_REPOSITORY_BACKUP_MISSING
  exit /b 1
)

copy /Y "%PATCH_ROOT%\backup\ReferenceRuntimeSnapshotRepository.php.bak" "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php" >nul

php -l "%REFBOOK_ROOT%\application\reference\Service\ReferenceRuntimeSnapshotRepository.php"
if errorlevel 1 exit /b 1

git -C "%REFBOOK_ROOT%" status --short

echo P114N4_ROLLBACK_OK
exit /b 0
