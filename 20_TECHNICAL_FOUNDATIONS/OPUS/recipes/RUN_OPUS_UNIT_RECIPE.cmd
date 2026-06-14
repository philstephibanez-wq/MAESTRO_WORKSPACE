@echo off
cd /d H:\OPUS
php "H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\tools\validate_opus_packages.php" --root=H:\OPUS
if errorlevel 1 exit /b 1
php "H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\OPUS\tools\validate_opus_delivery_layout.php" --root=H:\OPUS --mode=dev
if errorlevel 1 exit /b 1
git status --short --branch
echo OPUS_UNIT_RECIPE_OK
