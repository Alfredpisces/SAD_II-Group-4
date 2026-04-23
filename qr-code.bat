@echo off
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| find "IPv4 Address"') do (
    set ip=%%a
)
set ip=%ip: =%
echo Your current IP is: %ip%
echo Starting CafeEase server on http://%ip%:8000
php artisan serve --host=0.0.0.0 --port=8000
pause
