@ECHO OFF
CD C:\wamp64\www\GestionEcoleS5
PHP -S 127.0.0.1:8000 -t public
ECHO Congratulations! Your project executed successfully.
ECHO Open http://127.0.0.1:8000
PAUSE