@echo off
setlocal EnableExtensions EnableDelayedExpansion

set "WORKSPACE=H:\MAESTRO_WORKSPACE"
set "PACKAGE_DIR=%~dp0"
set "REPORT_ROOT=%WORKSPACE%\70_REPORTS\P115A1_WORKSPACE_LEGACY_FINALIZE"
set "HISTORY_ROOT=%WORKSPACE%\99_ARCHIVES\history_preserved"
set "ERROR_FILE=%REPORT_ROOT%\P115A1_WORKSPACE_LEGACY_FINALIZE_ERROR.txt"

if not exist "%WORKSPACE%\.git" (
  echo WORKSPACE_GIT_ROOT_NOT_FOUND>%ERROR_FILE%
  echo WORKSPACE=%WORKSPACE%>>%ERROR_FILE%
  echo ERROR=%ERROR_FILE%
  echo P115A1_WORKSPACE_LEGACY_FINALIZE_FAIL
  pause
  exit /b 1
)

cd /d "%WORKSPACE%" || (
  echo WORKSPACE_CD_FAILED>%ERROR_FILE%
  echo WORKSPACE=%WORKSPACE%>>%ERROR_FILE%
  echo ERROR=%ERROR_FILE%
  echo P115A1_WORKSPACE_LEGACY_FINALIZE_FAIL
  pause
  exit /b 1
)

if not exist "%REPORT_ROOT%" mkdir "%REPORT_ROOT%"
if not exist "%HISTORY_ROOT%" mkdir "%HISTORY_ROOT%"

for /f "tokens=2 delims==" %%A in ('wmic os get LocalDateTime /value ^| find "="') do set "DTS=%%A"
if "%DTS%"=="" (
  echo TIMESTAMP_GENERATION_FAILED>%ERROR_FILE%
  echo WMIC_LocalDateTime_EMPTY>>%ERROR_FILE%
  echo ERROR=%ERROR_FILE%
  echo P115A1_WORKSPACE_LEGACY_FINALIZE_FAIL
  pause
  exit /b 1
)
set "TS=%DTS:~0,8%_%DTS:~8,6%"
set "ARCHIVE_DIR=%HISTORY_ROOT%\P115A1_%TS%"
set "LEGACY_DIR=%ARCHIVE_DIR%\legacy_root_folders"
set "REPORT_FILE=%REPORT_ROOT%\P115A1_WORKSPACE_LEGACY_FINALIZE_REPORT_%TS%.txt"

if exist "%ARCHIVE_DIR%" (
  echo ARCHIVE_DIR_ALREADY_EXISTS>%ERROR_FILE%
  echo ARCHIVE_DIR=%ARCHIVE_DIR%>>%ERROR_FILE%
  echo ERROR=%ERROR_FILE%
  echo P115A1_WORKSPACE_LEGACY_FINALIZE_FAIL
  pause
  exit /b 1
)

mkdir "%ARCHIVE_DIR%"
mkdir "%LEGACY_DIR%"

(
  echo P115A1_WORKSPACE_LEGACY_FINALIZE_START
  echo WORKSPACE=%WORKSPACE%
  echo PACKAGE_DIR=%PACKAGE_DIR%
  echo ARCHIVE_DIR=%ARCHIVE_DIR%
  echo.
  echo BEFORE_ROOT_LIST
  dir /b /a
  echo.
  echo BEFORE_GIT_STATUS
  git --no-pager status --short --branch
  echo.
) > "%REPORT_FILE%"

rem Normalize the previous malformed P115A archive name when present.
if exist "%HISTORY_ROOT%\P115A_202600We_170013" (
  if not exist "%HISTORY_ROOT%\P115A_20260610_170013" (
    ren "%HISTORY_ROOT%\P115A_202600We_170013" "P115A_20260610_170013"
    echo NORMALIZED_ARCHIVE_NAME P115A_202600We_170013 -^> P115A_20260610_170013>>"%REPORT_FILE%"
  ) else (
    echo NORMALIZE_SKIPPED_TARGET_EXISTS P115A_20260610_170013>>"%REPORT_FILE%"
  )
)

set "MOVE_FAILED=0"
for %%D in (ARCHIVES CONTEXT DOC INBOX OUTBOX SECTORS) do (
  if exist "%WORKSPACE%\%%D" (
    if exist "%LEGACY_DIR%\%%D" (
      echo LEGACY_TARGET_ALREADY_EXISTS %%D>>"%REPORT_FILE%"
      set "MOVE_FAILED=1"
    ) else (
      move "%WORKSPACE%\%%D" "%LEGACY_DIR%\%%D" >>"%REPORT_FILE%" 2>>&1
      if errorlevel 1 (
        echo MOVE_FAILED %%D>>"%REPORT_FILE%"
        set "MOVE_FAILED=1"
      ) else (
        echo MOVED_LEGACY_ROOT_FOLDER %%D>>"%REPORT_FILE%"
      )
    )
  ) else (
    echo LEGACY_ROOT_FOLDER_NOT_PRESENT %%D>>"%REPORT_FILE%"
  )
)

if "%MOVE_FAILED%"=="1" (
  echo MOVE_FAILED_SEE_REPORT>%ERROR_FILE%
  echo REPORT=%REPORT_FILE%>>%ERROR_FILE%
  echo ERROR=%ERROR_FILE%
  echo P115A1_WORKSPACE_LEGACY_FINALIZE_FAIL
  pause
  exit /b 1
)

set "INDEX_FILE=%HISTORY_ROOT%\INDEX_HISTORY_PRESERVED.md"
if not exist "%INDEX_FILE%" (
  > "%INDEX_FILE%" echo # History preserved
  >> "%INDEX_FILE%" echo.
  >> "%INDEX_FILE%" echo This folder preserves previous workspace files, failed patches, reports, runners, handoffs, and historical mistakes. Nothing here should be deleted silently.
  >> "%INDEX_FILE%" echo.
)
>> "%INDEX_FILE%" echo - P115A1_%TS%: finalized legacy root cleanup. Moved ARCHIVES, CONTEXT, DOC, INBOX, OUTBOX, SECTORS when present into legacy_root_folders. Previous malformed P115A timestamp normalized if present.

(
  echo.
  echo AFTER_ROOT_LIST
  dir /b /a
  echo.
  echo AFTER_HISTORY_ROOT_LIST
  dir /b /a "%HISTORY_ROOT%"
  echo.
  echo AFTER_GIT_STATUS
  git --no-pager status --short --branch
  echo.
  echo P115A1_WORKSPACE_LEGACY_FINALIZE_DONE
) >> "%REPORT_FILE%"

echo REPORT=%REPORT_FILE%
echo ARCHIVE=%ARCHIVE_DIR%
echo P115A1_WORKSPACE_LEGACY_FINALIZE_OK
pause
exit /b 0
