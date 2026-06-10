@echo off
setlocal EnableExtensions EnableDelayedExpansion

set "WORKSPACE=H:\MAESTRO_WORKSPACE"
set "PACKAGE_DIR=%~dp0"
set "TEMPLATE_DIR=%PACKAGE_DIR%templates"

set "DATE_PART=%DATE%"
set "TIME_PART=%TIME%"
set "TS=%DATE_PART:~-4%%DATE_PART:~3,2%%DATE_PART:~0,2%_%TIME_PART:~0,2%%TIME_PART:~3,2%%TIME_PART:~6,2%"
set "TS=%TS: =0%"

set "REPORT_DIR=%WORKSPACE%\70_REPORTS\P115A_WORKSPACE_BASELINE_ORGANIZATION"
set "ARCHIVE_DIR=%WORKSPACE%\99_ARCHIVES\history_preserved\P115A_%TS%"
set "REPORT=%REPORT_DIR%\P115A_WORKSPACE_BASELINE_ORGANIZATION_REPORT_%TS%.txt"

if not exist "%WORKSPACE%" mkdir "%WORKSPACE%"
if not exist "%REPORT_DIR%" mkdir "%REPORT_DIR%"
if not exist "%ARCHIVE_DIR%" mkdir "%ARCHIVE_DIR%"

echo P115A_WORKSPACE_BASELINE_ORGANIZATION_START>"%REPORT%"
echo WORKSPACE=%WORKSPACE%>>"%REPORT%"
echo PACKAGE_DIR=%PACKAGE_DIR%>>"%REPORT%"
echo ARCHIVE_DIR=%ARCHIVE_DIR%>>"%REPORT%"
echo.>>"%REPORT%"

if not exist "%TEMPLATE_DIR%" (
  echo TEMPLATE_DIR_NOT_FOUND=%TEMPLATE_DIR%>>"%REPORT%"
  echo ERROR=%REPORT%
  echo P115A_WORKSPACE_BASELINE_ORGANIZATION_FAIL
  exit /b 1
)

echo BEFORE_ROOT_LIST>>"%REPORT%"
dir "%WORKSPACE%" /a /b>>"%REPORT%" 2>&1
echo.>>"%REPORT%"

for %%D in (
"00_COMMON_CONTRACTS"
"01_REGISTRY"
"10_FINAL_GOALS"
"20_TECHNICAL_FOUNDATIONS"
"30_PATCHES"
"40_AUDITS"
"50_HANDOFFS"
"60_TOOLS"
"70_REPORTS"
"80_BACKUPS"
"80_DOWNLOAD_INBOX"
"90_ARCHIVES"
"99_ARCHIVES"
"tmp"
) do (
  if not exist "%WORKSPACE%\%%~D" mkdir "%WORKSPACE%\%%~D"
)

robocopy "%TEMPLATE_DIR%" "%WORKSPACE%" /E /XC /XN /XO /R:1 /W:1 >>"%REPORT%" 2>&1
if %ERRORLEVEL% GEQ 8 (
  echo ROBOCOPY_TEMPLATE_ERROR=%ERRORLEVEL%>>"%REPORT%"
  echo ERROR=%REPORT%
  echo P115A_WORKSPACE_BASELINE_ORGANIZATION_FAIL
  exit /b 1
)

echo.>>"%REPORT%"
echo LEGACY_FOLDER_ARCHIVE>>"%REPORT%"

if exist "%WORKSPACE%\patches" (
  move "%WORKSPACE%\patches" "%WORKSPACE%\30_PATCHES\archived\legacy_patches_%TS%" >>"%REPORT%" 2>&1
)

if exist "%WORKSPACE%\audits" (
  move "%WORKSPACE%\audits" "%WORKSPACE%\40_AUDITS\legacy_audits_%TS%" >>"%REPORT%" 2>&1
)

if exist "%WORKSPACE%\handoffs" (
  move "%WORKSPACE%\handoffs" "%WORKSPACE%\50_HANDOFFS\legacy_handoffs_%TS%" >>"%REPORT%" 2>&1
)

if exist "%WORKSPACE%\reports" (
  move "%WORKSPACE%\reports" "%WORKSPACE%\70_REPORTS\legacy_reports_%TS%" >>"%REPORT%" 2>&1
)

if exist "%WORKSPACE%\backups" (
  move "%WORKSPACE%\backups" "%WORKSPACE%\80_BACKUPS\legacy_backups_%TS%" >>"%REPORT%" 2>&1
)

if exist "%WORKSPACE%\tools" (
  move "%WORKSPACE%\tools" "%WORKSPACE%\60_TOOLS\legacy_tools_%TS%" >>"%REPORT%" 2>&1
)

if exist "%WORKSPACE%\downloads" (
  move "%WORKSPACE%\downloads" "%WORKSPACE%\80_DOWNLOAD_INBOX\legacy_downloads_%TS%" >>"%REPORT%" 2>&1
)

echo.>>"%REPORT%"
echo ROOT_FILE_ARCHIVE>>"%REPORT%"
if not exist "%ARCHIVE_DIR%\root_files" mkdir "%ARCHIVE_DIR%\root_files"

for %%F in ("%WORKSPACE%\*") do (
  if exist "%%~fF" (
    if not "%%~aF"=="" (
      echo MOVE_ROOT_FILE %%~nxF>>"%REPORT%"
      move "%%~fF" "%ARCHIVE_DIR%\root_files\" >>"%REPORT%" 2>&1
    )
  )
)

if exist "%WORKSPACE%\tmp" (
  move "%WORKSPACE%\tmp" "%ARCHIVE_DIR%\tmp_%TS%" >>"%REPORT%" 2>&1
)
mkdir "%WORKSPACE%\tmp" >>"%REPORT%" 2>&1

echo.>>"%REPORT%"
echo AFTER_ROOT_LIST>>"%REPORT%"
dir "%WORKSPACE%" /a /b>>"%REPORT%" 2>&1
echo.>>"%REPORT%"

echo PRESERVED_HISTORY_ARCHIVE=%ARCHIVE_DIR%>>"%REPORT%"
echo P115A_WORKSPACE_BASELINE_ORGANIZATION_DONE>>"%REPORT%"

echo REPORT=%REPORT%
echo ARCHIVE=%ARCHIVE_DIR%
echo P115A_WORKSPACE_BASELINE_ORGANIZATION_OK
exit /b 0
