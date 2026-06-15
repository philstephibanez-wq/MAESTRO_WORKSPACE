@echo off
setlocal EnableExtensions
cd /d H:\MAESTRO_WORKSPACE
python "H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\tools\quality\validate_workspace_layout_guard.py" --workspace-root "H:\MAESTRO_WORKSPACE" --opus-refbook-root "H:\OPUS_REF_BOOK"
exit /b %0%
