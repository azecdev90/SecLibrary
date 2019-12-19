# SECLIBRARY

SecLibrary is simple library written in PHP for most common security problems in PHP developers everday life. Intention of this library is to provide some basic functionality to  PHP beginners, and help them to avoid most common problems. Some of functionality exist in native PHP but with missconeption from lot of beginners. [![MIT license](https://img.shields.io/badge/License-MIT-blue.svg)](https://lbesson.mit-license.org/) 

1. [Prologue](#prologue)
2. [Installation](#installation)
3. [Getting started](#getting-started)
4. [How to use](#how-to-use)
    1. [Escaping](#escaping)
    2. [Forms](#forms)
    3. [Hashing](#hashing)
    4. [Images](#images)
    4. [Inclusion](#inclusion)
    5. [Validation](#validation)
5. [Epilogue](#epilogue)


# Prologue
From the mid of 90s to nowdays PHP conquered world of web. Popularity of this languge was grown rapidly where there is no real opponent in this in this branch. Huge community is result that popularity. Beauty of PHP is easy learning curve and flexibility. Also, huge community made impact on beginners to start learn and use this language. Relative easy learning curve and big community was been perfect for beginners who had not   knowledge in programming, but also in security during the development software. PHP made constantly some of features to ensure tools for battle against most common problems in web development. Features that missing in PHP, or tools that are confuse beginners are part of this project. 

# Installation
There is two way how you can install this library and incorporate in your project.

### Manually

Step 1.
Download this project from Github 

Step 2.  
Unzip archive  

Step 3.  
Move unzziped folder to your server  



### Via Composer
```
composer require azecdev90/seclibrary
```

# Getting started
You need to include SecLibrary.php file in your project and import functions from namespace. For Composer installation you have option to use autoload option.

# How to use
This project is divided into categories based on topics in alphabetical order.

### Escaping
Escaping is technique we use it when we want to safe display informations from database. This way we ensure that potentially attacker cant make Cross site scripting attack. It is attack when content from database is not escaped, and it is displayed and interpreted. This can be used from attacker usually to steal sessions and execute code on your browser.

###### xssCleaner()
```php 
<?php xssCleaner($stringfromdatabase); ?>
```
###### Note: Use escape technique always on output, not on input.

### Forms
One of main problems when working with forms in PHP is because your application dont know origin of request. This means that, some of attacker could make trap victim to do regulary action without know that. Usually it is type of action where attacker try to make some damage to legitimate user like delete account or change password. Solution to prevent this type of attack is called request tokens. Idea behind this option is to generate token in form and session, and then on the action page you compare tokens. If they are equals, the request is from normal origin, but if they are not equals or there is no token it means that it is potentially attack and your web app need to denied that.
To implement this solution with this library is easy but two-step process.
First is to generate token in form and session. Tokens are usually in form in hidden type and are not visible to end user. 

###### csrfGenerateToken()
###### csrfCompareTokens()
```html
<input type="hidden" name="token" value="<?php echo csrfGenerateToken(); ?>">
```

Second step in this process is to compare tokens.
```php
<?php
if(csrfCompareTokens($_POST['token'])) {
   // tokens are equals and request is valid
} else {
  // refuse request, because it is potentially type of CSRF attack
}
?>
```
###### Note: You must start session on both stage of process.

### Hashing
Securing passwords of your users is one of the most importants steps in process of secure web application. Why is this so important ? Reason for this lies in human nature. Most of man use easy password because they dont want to remember complicated random password. This means that if someone break and get yours users password it potentially threaten all aplications who are used by that users, Facebook and others social networks are part of this, also a email account. If passwords are not hashed, opportunities are endless. This reason make process of securing users password so important. In the past, PHP programmers used md5 hash function which use md5 algorithm made by Ronald Rivest on start of 90s. This is used most by most programmers in recent period. Nowdays, this way of securing password is not acceptable. Reason for this is because hardware today is improved and advanced and it can break password with brute force type of attack. There is more options like sha-1 and others, but it is not right choice for secure passwords.
Instead old algorithm, we need to use Blowfish algorithm. It is proper way to secure password from PHP 5.5.0 version. Implementation of Blowfish algorithm in this library is different from native PHP because it dont accept salt, because most of the beginners try to make salt on inproper way and actually make password less secure.
Way to store password in database table
###### hashPassword()
###### checkPassword()

```php
<?php
hashPassword($plainpassword);
?>
```
and then store it in table.
On the other way to compare if password is right, usually on the user/login part of page way to that is next.
```php
<?php
// $plainpass – usually from form
// $hashedpass – usually from database
checkPassword($plainpass, $hashedpass) { 
// Password from form and database are equals
}
?>
```
###### Note: Hashing is not same process as encryption. Encryption is two-way process, hashing is just one-way. Encryption is important as a part user/login systems to defend against man-in-middle attacks. Using encryption with secure protol https is must !

### Images
File upload in PHP and other languages is important part of security. With file upload you can allow users to upload “images” on your server. This open a lot of possibilites to attacker try to take advantage and upload file that is not image. Usually this is shell file wich allow attacker to gain access on your web server. Way to secure file uploads and maximaze security is to secure web server with different kind of options. On the other hand, in PHP you can make some basic things to secure most common type attacks.
After request from form you have few options.
###### imgCheckExtension()
###### imgCheckMimeType()
###### imgRandomName()
```php
<?php
// $file to check extension
// $allowedextensions = [‘jpg’,’png’]
If(imgCheckExtension($file, $allowedextensions)) {
// extension of this file is in allowed list 
}
?>
```
Second way is to check mime-type  of uploaded file.
```php
<?php
// $file to check mime type
// $allowedmime = ['image/jpg', 'image/png']
If(imgCheckMimeType($file, $allowedmime)) {
// file have right mime-type
}
?>
```
Generate random name with uploaded files is also one measure to lift your security level. 
```php
<?php
$newname = imgRandomName();
?>
```
###### Note: Mime-type can be faked and its highly recommended to make more layers of protecion. 

### Inclusion
Inclusion is type of attack where attackers exploit page that dynamic include pages. There is a two type of this attack local file inclusion and remote file inclusion. Remote file inclusion allows attacker to include code or script from remote resource and run on your web server. On the other hand, local file inclusion include file from same server. 
###### checkInclusion()
```php
<?php
// $page = $_GET['page']
// $allowedlist = ['forum.php','about.php','history.php'];
If(checkInclusion($page, $allowedlist) {
// Page is in allowed list, safe include file
include “$page”;
}
?>
```
###### Note: Protection for remote file inclusion is to set server allow_url_include = off 

### Validation
Validation is process when we check is input in way like we expect. Validation is first line of defense in PHP security.
###### validateEmail()
###### validateNumber()
To check is input for email in expect format we can use
```php
<?php
validateEmail($emailfrominput);
?>
```
To check is input in numeric format 
```php
<?php
validateNumber($numberfrominput);
?>
```


# Epilogue
Big number of PHP programmers, and also a big number application without good seacurity made myth that PHP is not right tool for web development. Fact is, that a lot of application who are made with PHP are vulnerable in some way. But reason for that is not specific language, but bad programming practise. Modern frameworks based on Ruby and others languages are not immune on some types attacks. Same problems in PHP are problems in other languages and frameworks. Some of them of course work on best practise, but if programmer not have enough knolewdge in security area it can be a problem. 

Concept of security is complex topic. This concept require strong and wide spectrum of knowledge. Strategy is in general, to implement more levels of protection and use defense in depth. This means that if attacker can avoid one level, he cant others. Also, to fully protect application it shoud be clear that code made from programmer is just one layer of security. Others importans layers are configuration web servers where is application hosted. Third layer of protection is enduser. Clients for who you work and develop application need to understand basic principles and importance security related for their use. If some user with high level of privileges make simple and predictable passwords, then even application with good code potentially became in threaten and dangerous situation.



