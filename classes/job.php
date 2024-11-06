<?php


class job
{
    static style $header,$top,$bottom,$footer,$body;
    public $job;
    function __construct()
    {
        self::$header = new style('header');
        self::$top  = new style('top');
        self::$bottom = new style('bottom');
        self::$footer = new style('footer');
        self::$body = new style();
        $this->job = data::$get->job;
        if (config::$get->force_login && member::$current->id < 1) {
            if ($this->job == 'ajax') {
                // show error msg
                create_error('Please Login');
            } else {
                // display login page
                require './routes/_login.php';
                // @TODO LOGIN FROM ANY PAGE
                if (member::$current->id > 0 && $this->job != 'login') {
                    $this->execute_job();
                }
            }
        } else {
            $this->execute_job();
        }
    }
    static function clear_html() {
        self::$header = new style();
        self::$top = new style();
        self::$bottom = new style();
        self::$footer = new style();
    }
    static function out() {
        print job::$header.job::$top.job::$body.job::$bottom.job::$footer;
    }
    private function execute_job() {

        $file = './routes/_'.$this->job.'.php';
//        self::$header = new style('header');
//        self::$footer = new style('footer');
//        self::$top = new style('top');
//        self::$bottom = new style('bottom');
        if (file_exists($file)) {
            require $file;
        } else {
            $this->no_method();
        }
    }
    private function no_method() {
        /**
         * For Automated non file jobs you can specify the file that should handle the job here
        */
        data::$get->page_title = '{{error}}';
        $file = './routes/unknown-handler.php';
        if (file_exists($file)) require $file;
        else {
            print style::msgbox('{{file_not_found}}','danger',true);
            die();
        }
    }
}