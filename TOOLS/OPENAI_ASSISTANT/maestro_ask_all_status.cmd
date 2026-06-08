@echo off
setlocal
echo === MO_KB_DAEMON ===
call "H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_daemon_status.cmd"
if errorlevel 1 exit /b %errorlevel%
echo.
echo === MO_KB_FRONT ===
call "H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_front_status.cmd"
if errorlevel 1 exit /b %errorlevel%
echo.
echo === MAESTRO_V5 ===
call "H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_maestro_v5_status.cmd"
if errorlevel 1 exit /b %errorlevel%
endlocal
