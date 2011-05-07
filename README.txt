LOCAL INSTALLATION INSTRUCTIONS
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

1. Install:
   a) Apache HTTP-Server
   b) PHP (setup asks for Apache location, thus should be installed after it)
   c) MySQL Server
   d) MySQL GUI Tools (you may need to use MySQL Administrator out of it)

2. Use MySQL Administrator / Restore / Open Backup File to import
   bookwarrior.updated*.sql database dump.

3. Copy contents of this folder to your WWW-folder.

4. Modify confdb.php to match your MySQL user name and password (replace
   'bookuser' and 'bookpass' with your access details).


That's it! Now start Apache, visit your local WWW-page (http://127.0.0.1/)
and enjoy reading!


June 12, 2010

---
bookwarrior
