@echo off
REM Replace 'root' with your MySQL account name
REM Requests the user's password upon execution

mysql -u root -p < moderated.sql
pause
