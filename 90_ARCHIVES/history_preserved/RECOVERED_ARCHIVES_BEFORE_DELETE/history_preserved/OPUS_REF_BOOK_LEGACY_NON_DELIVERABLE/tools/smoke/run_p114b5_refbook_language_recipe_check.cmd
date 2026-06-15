@echo off
php -d max_execution_time=0 "%~dp0p114b5_refbook_language_recipe_check.php"
exit /b %ERRORLEVEL%
