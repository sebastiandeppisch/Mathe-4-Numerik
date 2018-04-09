phpunit "$1"
inotifywait -r -m -e close_write src/ tests/ |
while read line
do
	clear
	phpunit "$1"
done