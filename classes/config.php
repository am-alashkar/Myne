<?php


class config
{
    use DynamicProperties;
    static $get;
    public $login_by;
    public $home_link,$storedate,$storetime,$storedatetime,$assets_link;
    private $ok;
    function __construct()
    {
        $settings = db::$db->select('*','settings');
        //die(db::$db->get_last_error());
        if ($settings->is_empty()) {
            $error['files'] = 'a dinosaur 🐸';
            $error['details'] = 'Database is Not Configured';
            $error['code'] = 'CFG01';
            require 'error.php';
        }
        foreach ($settings as $value) {
            $this->{$value['var_name']} = $value['var_value'];
        }
        $this->home_link = _HOME_; // This is with a slash (/)
        $this->assets_link = _HOME_.'assets'; // no slash (/) please 
        $this->storedatetime = 'Y-m-d H:i:s';
        $this->storedate = 'Y-m-d';
        $this->storetime = 'H:i:s';
        $this->login_by = 'email'; // email , login , or the name of the column in the members table
        self::$get = $this;
    }
    public function update($key,$value) {
        $up[$key] = $value;
        $this->$key = $value;
        db::$db->update('settings',$up,'var_name','=',$key);
    }
    public function delete($key) {
        unset($this->$key);
        db::$db->delete('settings','var_name','=',$key);
    }
}

