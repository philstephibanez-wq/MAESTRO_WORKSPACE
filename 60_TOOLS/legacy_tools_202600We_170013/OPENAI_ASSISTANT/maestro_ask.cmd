@echo off
setlocal
set "ASK_SCRIPT=H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\ask_maestro.py"
if not exist "%ASK_SCRIPT%" (
  echo ERROR: ask_maestro.py introuvable:
  echo %ASK_SCRIPT%
  exit /b 2
)
python "%ASK_SCRIPT%" %*
endlocal
