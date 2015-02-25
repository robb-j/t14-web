set /P id=Enter the folder you wish to check:
java phpChecker %id% > log.txt
echo files checked, the result is in log.txt
pause