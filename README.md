## unityparty.co
The main unity party site.

# Database
To set up the database, you're going to have to do the following.
(1) Create a database of any name.

(2) Create the following tables: 'forums', 'news', 'threads' and 'users'.
    (a) In 'forums', there are four fields. 'id' (int(15) - AI and primary), 'name' (varchar(15)), description (varchar(127), default=NULL), parent(int(15), default=NULL).
    (b) In 'news', there are five fields. 'id' (int(15) - AI and primary), 'title' (varchar(128)), 'content' (varchar(52000)), 'brief' (varchar(1024)), 'author' (carchar(128)).
    (c) In 'threads', there are six fields. 'id' (int(15) - AI and primary), 'title' (varchar(128), default=NULL), 'content' (varchar(10240)), 'author' (varchar(128)), 'parent' (int(15), default=NULL), 'forum' (int(15)).
    (d) In 'users', there are eight fields. 'id' (int(15) - AI and primary), 'username' (varchar(128)), 'password' (varchar(128)), 'authtoken' (int(12), default=NULL), 'nickname' (varchar(128), default=NULL), 'description' (varchar(10240), default=NULL), admin (boolean), writer (boolean).
    
(3) Create a user that can access the database and give it all permissions.

(4) Edit 'config.php'. 
    (a) If your db is on the same machine as the site, keep $config['dbaddr'] as 'localhost'.
    (b) Set $config['dbname'] to whatever you set the password to.
    (c) Set $config['dbuser'] to whatever you called the user.
    (d) Set $config['dbpass'] to whatever you set ther user's password to.
