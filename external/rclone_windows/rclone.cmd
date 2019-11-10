@echo off
del config.txt
rclone config --config config.txt
start "" notepad config.txt