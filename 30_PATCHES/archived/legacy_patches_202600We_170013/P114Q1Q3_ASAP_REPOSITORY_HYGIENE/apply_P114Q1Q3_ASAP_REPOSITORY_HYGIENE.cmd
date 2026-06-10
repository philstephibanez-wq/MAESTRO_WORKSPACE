@echo off
setlocal
cd /d H:\ASAP
python "%~dp0apply_p114q1q3.py" "H:\ASAP" "H:\MAESTRO_WORKSPACE\patches\P114Q1Q3_ASAP_REPOSITORY_HYGIENE"
if errorlevel 1 (
  echo P114Q1Q3_ASAP_REPOSITORY_HYGIENE_FAIL
  pause
  exit /b 1
)
echo P114Q1Q3_ASAP_REPOSITORY_HYGIENE_OK
pause
