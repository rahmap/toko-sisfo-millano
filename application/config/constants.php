<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
| API KEY
*/
defined('API_MIDTRANS') OR define('API_MIDTRANS', getenv('API_MIDTRANS')); // Midtrans
defined('MARCHANT_ID') OR define('MARCHANT_ID', getenv('MARCHANT_ID')); // Midtrans Marchat ID
defined('API_RAJA_ONGKIR') OR define('API_RAJA_ONGKIR', getenv('API_RAJA_ONGKIR')); // Api Raja Ongkir

// Mailgun, , cek di Free_Model dan Libraries
defined('MAILGUN') OR define('MAILGUN', getenv('MAILGUN')); // JIKA TRUE MAKA WAJIB SETTING API MAILGUN, JIKA TIDAK MAKA WAJIB SETTING SMTP DLL CEK DI Free_Model/sendMail
// defined('EMAIL_FROM') OR define('EMAIL_FROM', 'ironman@rahmap.me'); // EMAIL PENGIRIM UNTUK SMTP / MAILGUN.
defined('EMAIL_FROM') OR define('EMAIL_FROM', getenv('EMAIL_FROM')); // EMAIL PENGIRIM UNTUK SMTP / MAILGUN.
defined('API_MAILGUN') OR define('API_MAILGUN', getenv('API_MAILGUN')); // API Mailgun
defined('DOMAIN_MAILGUN') OR define('DOMAIN_MAILGUN', getenv('DOMAIN_MAILGUN')); // Domain Mailgun

// Untuk tutor menggunakan Mailgun cari sendiri hehe, akun Mailgun saya udah yang berbayar
// Kalo yang gratis juga bisa kok, tapi ada batasan pengirimannya, kalo gak salah cuma bisa
// send ke email sendiri, atau 5 orang (email) yang sudah di daftarkan. Search Google aja :)
defined('SMTP_PASS') OR define('SMTP_PASS', getenv('SMTP_PASS'));
defined('SMTP_PORT') OR define('SMTP_PORT', getenv('SMTP_PORT'));
defined('SMTP_HOST') OR define('SMTP_HOST', getenv('SMTP_HOST'));
defined('PESAN_MANUAL') OR define('PESAN_MANUAL', 0);
defined('PESAN_1_PRODUK') OR define('PESAN_1_PRODUK', 1);
defined('PESAN_2_PRODUK') OR define('PESAN_2_PRODUK', 2);

/*
 * Data Aplikasi
 */
defined('APP_NAME') OR define('APP_NAME', 'Toko Sisfo');
defined('APP_CREATOR') OR define('APP_CREATOR', '@rahmap._');
defined('APP_CREATOR_LINK') OR define('APP_CREATOR_LINK', '#');
