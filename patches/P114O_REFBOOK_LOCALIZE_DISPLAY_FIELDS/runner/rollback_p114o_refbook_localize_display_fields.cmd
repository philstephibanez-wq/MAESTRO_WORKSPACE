@echo off
setlocal EnableExtensions

set "REFBOOK_ROOT=H:\ASAP_REF_BOOK"
set "PATCH_ROOT=H:\MAESTRO_WORKSPACE\patches\P114O_REFBOOK_LOCALIZE_DISPLAY_FIELDS"

if not exist "%PATCH_ROOT%\backup\ReferenceCatalogService.php.bak" (
  echo P114O_ROLLBACK_CATALOG_BACKUP_MISSING
  exit /b 1
)

copy /Y "%PATCH_ROOT%\backup\ReferenceCatalogService.php.bak" "%REFBOOK_ROOT%\application\reference\Service\ReferenceCatalogService.php" >nul

php -l "%REFBOOK_ROOT%\application\reference\Service\ReferenceCatalogService.php"
if errorlevel 1 exit /b 1

git -C "%REFBOOK_ROOT%" status --short

echo P114O_ROLLBACK_OK
exit /b 0
