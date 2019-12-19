<?php

/**
 * Simple security library for most common security problems in PHP application.
 * PHP version 7.0.0
 *
 * @category PHP
 * @package  SecLib
 * @author   Amir Zec <amirzecdev@outlook.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: @1.0.0@
 * @link     https://github.com/azecdev90/
 */

namespace SecLibrary;

/**
 *
 *  ======  ======  ======  =====   ======  =  ==    =   =======
 *  =       =       =       =   =   =   =   =  = =   =   =
 *  ======  ======  =       =====   ===     =  =  =  =   =  ====
 *  =            =  =       =   =   =       =  =   = =   =  =  =
 *  ======  ======  ======  =   =   =       =  =    ==   =======
 *
 */

 /**
  * Escape string and clean from XSS attack
  *
  * @param string $string String who need to clean
  *
  * @return string Escaped safe string for use
  */
function xssCleaner($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}


/**
 *
 *  =====  ======   ======   ==    ==   =====
 *  =      =    =   =    =   = =  = =   =
 *  ===    =    =   =====    =  ==  =   =====
 *  =      =    =   =   =    =      =       =
 *  =      ======   =    =   =      =   =====
 *
 */

/**
 * Generate secure token
 *
 * This function use in form usualyy with hidden input field.
 *
 * @return string $_SESSION['token'] Return string with random token
 *
 */
function csrfGenerateToken()
{

        return $_SESSION['token'] = bin2hex(random_bytes(32));
}

/**
 * Compare tokens equality
 *
 * Function compare token from SESSION and form. If is equal, it means
 * that is legal request. If not, it means that request came from different
 * form.
 *
 * @param string $formtoken Token from form
 *
 * @return true|false
 */
function csrfCompareTokens($formtoken)
{

    if ($formtoken === $_SESSION['token']) {
        return true;
    } else {
        return false;
    }
}


/**
  *
  *   =   =   =====   =====   =   =   =   ==    =   =======
  *   =   =   =   =   =       =   =   =   = =   =   =
  *   =====   =====   =====   =====   =   =  =  =   =   ===
  *   =   =   =   =       =   =   =   =   =   = =   =     =
  *   =   =   =   =   =====   =   =   =   =    ==   =======
  *
  */

/**
  * Hash password
  *
  * Hash password with Blowfish algorithm. This function is simplicify
  * bcyript. Lot of beginners make mistake with this function because they
  * try to generate random salt not properly and make a problem. You need
  * to store this password in table with column CHAR or VARCHAR
  *
  * @param  string $plainpassword Plain password from user/login form
  *
  * @return string $hashedpass Password hashed and safe for store in database
  */
function hashPassword($plainpassword)
{
    $hashedpass = password_hash($plainpassword, PASSWORD_BCRYPT);
    return $hashedpass;
}

/**
* Check password equality
*
* Password from user request compare to password from database.
*
* @param string $plainpassword Password in plain format usually form form
* @param string $hashedpassword Hashed password from database
*
* @return true|false
*/
function checkPassword($plainpass, $hashedpass)
{
    if (password_verify($plainpass, $hashedpass)) {
        return true;
    } else {
        return false;
    }
}


/**
 *
 *  =   ==    ==   ======   ======   =====    =====
 *  =   = =  = =   =    =   =        =        =
 *  =   =  ==  =   ======   =  ===   ====     =====
 *  =   =      =   =    =   =    =   =            =
 *  =   =      =   =    =   ======   =====    =====
 *
 */

/**
 * Check image extension against list acceptbles values
 *
 * @param string $filename       File to test extensions
 * @param array  $allowedextensions Acceptable extensions
 *
 * @return true|false
 */
function imgCheckExtension($filename, $allowedextensions)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (in_array($ext, $allowedextensions)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check Mime-type of file
 *
 * @param string $file        File to check mime-type
 * @param array  $allowedmime List of allowed mime types
 *
 * @return true|false
 */
function imgCheckMimeType($file, $allowedmime)
{
    $mimetype = mime_content_type($file);

    if (in_array($mimetype, $allowedmime)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Generate random name from image.
 *
 * Name is generated in form uniq name and timestamp
 *
 * @return string Return random file name
 */
function imgRandomName()
{
    $newname = uniqid()."_".time();
    return $newname;
}


/**
 *
 *  =  ==    =  ====  =      =   =  =====  =  ======  ==    =
 *  =  = =   =  =     =      =   =  =      =  =    =  = =   =
 *  =  =  =  =  =     =      =   =  =====  =  =    =  =  =  =
 *  =  =   = =  =     =      =   =      =  =  =    =  =   = =
 *  =  =    ==  ====  ====   =====  =====  =  ======  =    ==
 *
 */

/**
 * Check is param from url in allowed list, or not
 *
 * Put your allowed pages in array list, and when you make dynamic include page,
 * just process is page in array list, if not then you reject. Whitelisting principle
 * is more efficient than blacklisting.
 *
 * @param string $page
 * @param array $allowedlist
 * @return true|false
 */
function checkInclusion($page, $allowedlist)
{
    if (in_array($page, $allowedlist)) {
        return true;
    } else {
        return false;
    }
}


/**
 *
 *  =        =   =====   =        =    ====    =====   =====   =   =====   =     =
 *   =      =    =   =   =        =    =   =   =   =     =     =   =   =   = =   =
 *    =    =     =====   =        =    =   =   =====     =     =   =   =   =  =  =
 *     =  =      =   =   =        =    =   =   =   =     =     =   =   =   =   = =
 *       =       =   =   =====    =    ===     =   =     =     =   =====   =    ==
 *
 */

/**
 * Validate variable is in email format
 *
 * @param string $email
 *
 * @return true|false
 */
function validateEmail($email)
{
    if (filter_Var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Validate variable is a number
 *
 * @param mixed $number
 *
 * @return true|false
 */
function validateNumber($number)
{
    if (filter_var($number, FILTER_VALIDATE_INT) === 0 || filter_var($number, FILTER_VALIDATE_INT)) {
        return true;
    } else {
        return false;
    }
}
