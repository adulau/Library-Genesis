INSTALLATION
~~~~~~~~~~~~
Needs Apache Web-Server and MySQL-Server installed.

1. Copy content of this archive to subfolder ./editor/ of your WWW-directory,
   e.g. apache/htdocs/editor/ (URL will be http://127.0.0.1/editor/).

2. Run test_DB/install.bat (asks for MySQL-user password) to install test
   database from test_DB/moderated.sql. Default MySQL-user in the BAT is 'root',
   if yours is different, replace 'root' with it.

   On any platforms the command from install.bat can be executed from the
   command line ('root' is for your username): mysql -u root -p < moderated.sql

3. Edit config.php to match your $dbuser and $dbpass (the same as above).

4. Invoke in the usual way by visiting http://127.0.0.1/editor/


USAGE
~~~~~
*  Test-database contains 20 records that can be searched straight away.
   To do so, look into test_DB/moderated.sql, copy any MD5 and paste into the
   MD5-search form, then press "Check MD5!" The record will be shown.

*  To append your files and check their records in the DB, do the following:

   1. Upload a file through the Browse/Send-form.

   2. Fill in the fields of book record and submit by pressing "Register!"

   3. Now the book record can be accessed from the MD5-search form. To find
      the record, insert the book MD5 into MD5-form and press "Check MD5!"

      The book file can be found through in subdirectory ./repository/ or
      through the Web-server here http://127.0.0.1/editor/repository/


NOTES
~~~~~
There will have been temporary folder ./tmp/ created, a file being uploaded is
temporarily stored in it, then, upon completion of book registration, it is
moved to the repository.


September 15, 2009
bookwarrior
