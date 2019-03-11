@echo off
:bucle
php app/console app:verificacion
timeout /t %1 /nobreak
goto bucle