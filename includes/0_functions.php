<?php
/** functions that are used almost every time. */

/** this creates an error page ( require error.php ) and put the info inside. */
function create_error($msg = null,$code = 403, $sender = null){
    if (!$msg) $msg = 'Internal Error';
    if (data::$get->job == 'ajax') die('<span style="color: red; ">'.$msg.'</span>');
    $error['code'] = $code;
    $error['details'] = $msg;
    $error['files'] = $sender ? $sender : phrases::$error_sender[rand(0,count(phrases::$error_sender)-1)];
    require 'error.php';
}

/** a simplified function to check for permissions  */
function allowed($permission) {
    return member::$current->allowed($permission);
}

/** dump and die */
function dd($v = null) {
    if (!$v) $v = data::$get;
    print '<pre class="text-left" dir="ltr">';
    var_dump($v);
    print '</pre>';
    die();
}

/** print and redirect ... to download a file , the id is db related . */
function download($id) {
    print '<hr>'.'سيبدأ تحميل الملف خلال ثواني <br> إذا لم يبدأ <a href="'.config::$get->home_link.'download/'.$id.'/">اضغط هنا</a>';
    redirect(true,'','download/'.$id.'/',1,100,1,1);
}

/** simplified function to redirect the browser with a message . this uses javascript.
 * when autoprint is true the execution will stop after printing , else it will return the script (html ready) and continue
 */
function redirect($autoprint = false , $msg = '' ,$link = '' , $in = 1 , $timeout = '1000',$replace = true,$silent = false) {
        $replace = $replace ? 'replace' : 'assign' ;
        if ($link == '?' || $link == '/') $link = '';
        $html = $msg.'<br />';
        if ($in) {
            $lnk = config::$get->home_link. $link;
            if (!$lnk) {
                $lnk = config::$get->home_link;
            }
        } else { //if ($link)
            $lnk = $link;
            if (!$lnk) {
                $lnk = config::$get->home_link;
            }
        }
        $script = '<script>
function callback(a){
    return function(){
    	window.location.'.$replace.'("'.$lnk . '");
    	}
    }  
let a = "UBX";
setTimeout(callback(a), ' . $timeout . ');
</script>';
        if ($autoprint) {
            if (!$silent) print $html.'Click this link <a href="'.$lnk.'">'.$lnk.'</a> if not redirected automatically';
            print  $script;
            die();
        } else {
            if ($silent) return $script;
            return $html.'Click this link <a href="'.$lnk.'">'.$lnk.'</a> if not redirected automatically'.$script;
        }
}
 /** simplified function to redirect to index */
function redirect_to_index($timeout = 500){
    return redirect(true, '','',true,$timeout,true,true);
}

/** press back button */
function history_back() {
    $scr = '<script>
window.history.back();
</script>';
    die($scr);
}

/** @TODO : this function needs to be tested and modified
 * return to the page that requires login.
 */
function redirect_to_prev() {
    $ref = str_replace(config::$get->home_link,'',(string) $_SERVER['HTTP_REFERER']);
    $r2index = ['login','login/','logout','logout/','changepassword','changepassword/'];
    if (strstr((string) $ref,'http') && strstr((string) $ref,'://')) {
        member::logout();
        die();
    }
    if (in_array((string) $ref,$r2index)) {
        return redirect(true, 'Redirecting ...','',true,500,true,false);
    } else {
        return redirect(true, 'Redirecting ...',$ref,true,500,true,false);
    }
}

/** uuid simple function
 * I can't remember from whom I got this function !
 */
function gen_uuid() {
    try {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            random_int(0, 0xffff), random_int(0, 0xffff),
            // 16 bits for "time_mid"
            random_int(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            random_int(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            random_int(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
        );
    } catch (Exception $e) {
        return false;
    }
}
/**
 * Print or get a script to refresh web page in the browser
 * You can use it to refresh a page after submitting a form using normal posting method so if a user hit back or refresh it will not confirm to resend form
 * @param bool $print true to print directly to browser , false to return ;
 * @param int $time timeout before refresh
 * @return string
 */
function refresh($print = false, $time = 3000){
    $scr = '<script>
setTimeout(function() {
  window.location.replace(self.location);
},'.$time.');
</script>';
    if (!$print) return $scr;
    print $scr;
}

/** this function marks active a link in the navigation panel
 * @todo : this script must be style related . to have more flexibility in making a multi style site .
 */
function mark_active($link) {
    data::$get->lmscript .= '<script>
$("[href=\'<!-- CONFIG_home_link -->'.$link.'/\']").addClass("'.style::variable('active').'");
</script>';
}
/** clean a text to be safe for html and sql */
function clean(&$text)
{
    // &frasl;
    //$text = str_replace('&','_',(string) $text);
    $text = str_replace('&#92;','_',(string) $text);
    $text = str_replace('/','_',(string) $text);
    $text = str_replace('\\\\','_',(string) $text);
    $text = str_replace('\\','_',(string) $text);
    $text = str_replace('&frasl;','_',(string) $text);
    $text = str_replace(';','_',(string) $text);
    $text = str_replace(':','_',(string) $text);
    $text = str_replace('"','_',(string) $text);
    $text = str_replace('\'','_',(string) $text);
    $text = str_replace('+','_',(string) $text);
    $text = str_replace('&','_',(string) $text);
    $text = str_replace('#','_',(string) $text);
    while (strstr($text,'__'))
    $text = str_replace('__','_',(string) $text);
    while (strstr($text,'  '))
    $text = str_replace('  ',' ',(string) $text);

    $text = trim($text);

}