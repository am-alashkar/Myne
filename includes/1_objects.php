<?php
/** OBJECT functions ..
 * all functions here must return a string . can be with optional variables passed .
 * when parsing a style object to print it the "<!-- OBJ_function_name -->" in its HTML will be replaced with what function_name() will return .
 */


/** Navigation links */
function obj_nav_links(){
    $links = new style('nav_links');
    $i = 1;
    $html = '';
    while ($link = $links->get_part($i++).''){
        $ht = explode("\n",$link,2);
        $per = strtolower(trim((string) $ht['0']));
        if (allowed($per) || "all" == $per) $html .= $ht['1'];
        elseif ('member' == $per && member::$current->id) $html .= $ht['1'];
        elseif ('guest' == $per && !member::$current->id) $html .= $ht['1'];
    }
    return $html;
}

/** user info  */
function obj_user_info() {
    //if (member::$current->id)
    // $html = member::$current->name .'<input type="hidden" id="user_id" value="'.+member::$current->id.'">';
    /** BUG: in some browsers a hidden input was cashed and caused an error when switching accounts on the same browser  so this changed to a button and hidden by style*/
    $html = member::$current->name .'<input type="button" id="user_id" style="display:none" value="'.+member::$current->id.'">';
    return $html;
    //return '';
}

