DATE=`date +%m/%d/%Y`
TIME=$(TZ=":US/Central" date +%r)

echo "RUN DATE = $DATE"
echo "RUN TIME = $TIME"

/usr/bin/mysql --user=swibl_root --password='bas3!ball5566' swibl_dashboard  < /home/swibl/public_html/swibl_cron/updateDashboardStats.sql
/usr/bin/mysql --user=swibl_root --password='bas3!ball5566' swibl_dashboard  < /home/swibl/public_html/swibl_cron/updateDivisionStats.sql

