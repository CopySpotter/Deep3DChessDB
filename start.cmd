@echo off
setlocal
cd /d "%~dp0"

where php >nul 2>&1
if errorlevel 1 (
  echo PHP wurde nicht gefunden.
  echo Installiere PHP oder starte eine neue PowerShell, falls PHP gerade erst installiert wurde.
  echo.
  pause
  exit /b 1
)

echo Starte Deep3DChessDB auf http://127.0.0.1:8011/chessdb-demo.html
start "Deep3DChessDB Server" /min php -S 127.0.0.1:8011

rem Kurz warten, damit der lokale PHP-Server bereit ist.
timeout /t 2 /nobreak >nul
start "" "http://127.0.0.1:8011/chessdb-demo.html"

endlocal
exit /b 0
