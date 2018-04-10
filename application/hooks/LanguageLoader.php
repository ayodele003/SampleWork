<?php
class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');
        //$ci->lang->load('message','english');
        $ci->lang->load('message',setting_all('language'));
    }
}
?>