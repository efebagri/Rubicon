# ⚠️  This project is not ready to use. ⚠️
![gh-banner](https://www.swmhp.org/assets/uploads/2016/10/Framework-Logo-e1482348240552.jpg)
# ☁️ Rubicon
Rubicon is a functional based, beginner friendly micro framework written in PHP. The Goal is to help beginners to move with this framework to the professional ones

# Installing
### Windows
> Prerequisites:
[XAMPP](https://www.apachefriends.org/de/index.html)

To Install Framework, follow these instructions:

First go to your directory where the framework is located
```powershell 
C:\xampp\php\php.exe composer.phar install
```

After you have installed Composer you have to set the index.php in the public folder as default. After that you have to import the database and add the database credentials in the .env file.
# 

### Plesk
> Prerequisites:
[Plesk WebServer](https://bindyourserver.de/)

To Install Framework, follow these instructions:

You need to add your domain to Pleak, next you need to upload the framework to your webspace and install Composer under "PHP Composer". As a last step you have to import the database under "Database" and enter the access data in the .env file. If you go under "Hosting and DNS" on "Hosting Settings" add under "Document root" /public then the framework should already work.

# 📑 Features
- [ ] Debug system
- [ ] Database Support (MySQL & MongoDB)
- [ ] Modular system
- [ ] Auth Module
- [ ] Autoloader functions
- [ ] PermissionsSystem
# 🙏 Thanks to:
### 🧑🏻‍🤝‍🧑🏻 Contributors
* Razetro
### 🚧 Used Open-Source projects
* [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)
* [filp/whoops](https://github.com/filp/whoops)
