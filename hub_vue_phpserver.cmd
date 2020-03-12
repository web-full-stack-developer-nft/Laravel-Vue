@ECHO OFF
start . && start "" "%PROGRAMFILES%\Git\bin\sh.exe" --login && php artisan serve --port=5000
PAUSE