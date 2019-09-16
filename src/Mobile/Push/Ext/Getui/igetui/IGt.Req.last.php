<?php
class CmdID extends PBEnum
{
    const GTHEARDBT  = 0;
    const GTAUTH  = 1;
    const GTAUTH_RESULT  = 2;
    const REQSERVHOST  = 3;
    const REQSERVHOSTRESULT  = 4;
    const PUSHRESULT  = 5;
    const PUSHOSSINGLEMESSAGE  = 6;
    const PUSHMMPSINGLEMESSAGE  = 7;
    const STARTMMPBATCHTASK  = 8;
    const STARTOSBATCHTASK  = 9;
    const PUSHLISTMESSAGE  = 10;
    const ENDBATCHTASK  = 11;
    const PUSHMMPAPPMESSAGE  = 12;
    const SERVERNOTIFY  = 13;
    const PUSHLISTRESULT  = 14;
    const SERVERNOTIFYRESULT  = 15;
}
class GtAuth extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
    }
    public function sign()
    {
        return $this->_get_value("1");
    }
    public function set_sign($value)
    {
        return $this->_set_value("1", $value);
    }
    public function appkey()
    {
        return $this->_get_value("2");
    }
    public function set_appkey($value)
    {
        return $this->_set_value("2", $value);
    }
    public function timestamp()
    {
        return $this->_get_value("3");
    }
    public function set_timestamp($value)
    {
        return $this->_set_value("3", $value);
    }
    public function seqId()
    {
        return $this->_get_value("4");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("4", $value);
    }
}
class GtAuthResult_GtAuthResultCode extends PBEnum
{
    const successed  = 0;
    const failed_noSign  = 1;
    const failed_noAppkey  = 2;
    const failed_noTimestamp  = 3;
    const failed_AuthIllegal  = 4;
    const redirect  = 5;
}
class GtAuthResult extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
    }
    public function code()
    {
        return $this->_get_value("1");
    }
    public function set_code($value)
    {
        return $this->_set_value("1", $value);
    }
    public function redirectAddress()
    {
        return $this->_get_value("2");
    }
    public function set_redirectAddress($value)
    {
        return $this->_set_value("2", $value);
    }
    public function seqId()
    {
        return $this->_get_value("3");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("3", $value);
    }
    public function info()
    {
        return $this->_get_value("4");
    }
    public function set_info($value)
    {
        return $this->_set_value("4", $value);
    }
}
class ReqServList extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
    }
    public function seqId()
    {
        return $this->_get_value("1");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("1", $value);
    }
    public function timestamp()
    {
        return $this->_get_value("3");
    }
    public function set_timestamp($value)
    {
        return $this->_set_value("3", $value);
    }
}
class ReqServListResult_ReqServHostResultCode extends PBEnum
{
    const successed  = 0;
    const failed  = 1;
    const busy  = 2;
}
class ReqServListResult extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = array();
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
    }
    public function code()
    {
        return $this->_get_value("1");
    }
    public function set_code($value)
    {
        return $this->_set_value("1", $value);
    }
    public function host($offset)
    {
        $v = $this->_get_arr_value("2", $offset);
        return $v->get_value();
    }
    public function append_host($value)
    {
        $v = $this->_add_arr_value("2");
        $v->set_value($value);
    }
    public function set_host($index, $value)
    {
        $v = new $this->fields["2"]();
        $v->set_value($value);
        $this->_set_arr_value("2", $index, $v);
    }
    public function remove_last_host()
    {
        $this->_remove_last_arr_value("2");
    }
    public function host_size()
    {
        return $this->_get_arr_size("2");
    }
    public function seqId()
    {
        return $this->_get_value("3");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("3", $value);
    }
}
class PushResult_EPushResult extends PBEnum
{
    const successed_online  = 0;
    const successed_offline  = 1;
    const successed_ignore  = 2;
    const failed  = 3;
    const busy  = 4;
    const success_startBatch  = 5;
    const success_endBatch  = 6;
}
class PushResult extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PushResult_EPushResult";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBString";
        $this->values["6"] = "";
        $this->fields["7"] = "PBString";
        $this->values["7"] = "";
    }
    public function result()
    {
        return $this->_get_value("1");
    }
    public function set_result($value)
    {
        return $this->_set_value("1", $value);
    }
    public function taskId()
    {
        return $this->_get_value("2");
    }
    public function set_taskId($value)
    {
        return $this->_set_value("2", $value);
    }
    public function messageId()
    {
        return $this->_get_value("3");
    }
    public function set_messageId($value)
    {
        return $this->_set_value("3", $value);
    }
    public function seqId()
    {
        return $this->_get_value("4");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("4", $value);
    }
    public function target()
    {
        return $this->_get_value("5");
    }
    public function set_target($value)
    {
        return $this->_set_value("5", $value);
    }
    public function info()
    {
        return $this->_get_value("6");
    }
    public function set_info($value)
    {
        return $this->_set_value("6", $value);
    }
    public function traceId()
    {
        return $this->_get_value("7");
    }
    public function set_traceId($value)
    {
        return $this->_set_value("7", $value);
    }
}
class PushListResult extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PushResult";
        $this->values["1"] = array();
    }
    public function results($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    public function add_results()
    {
        return $this->_add_arr_value("1");
    }
    public function set_results($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    public function remove_last_results()
    {
        $this->_remove_last_arr_value("1");
    }
    public function results_size()
    {
        return $this->_get_arr_size("1");
    }
}
class Button extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBInt";
        $this->values["2"] = "";
    }
    public function text()
    {
        return $this->_get_value("1");
    }
    public function set_text($value)
    {
        return $this->_set_value("1", $value);
    }
    public function next()
    {
        return $this->_get_value("2");
    }
    public function set_next($value)
    {
        return $this->_set_value("2", $value);
    }
}
class AppStartUp extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
    }
    public function android()
    {
        return $this->_get_value("1");
    }
    public function set_android($value)
    {
        return $this->_set_value("1", $value);
    }
    public function symbia()
    {
        return $this->_get_value("2");
    }
    public function set_symbia($value)
    {
        return $this->_set_value("2", $value);
    }
    public function ios()
    {
        return $this->_get_value("3");
    }
    public function set_ios($value)
    {
        return $this->_set_value("3", $value);
    }
}
class ActionChain_Type extends PBEnum
{
    const refer  = 0;
    const notification  = 1;
    const popup  = 2;
    const startapp  = 3;
    const startweb  = 4;
    const smsinbox  = 5;
    const checkapp  = 6;
    const eoa  = 7;
    const appdownload  = 8;
    const startsms  = 9;
    const httpproxy  = 10;
    const smsinbox2  = 11;
    const mmsinbox2  = 12;
    const popupweb  = 13;
    const dial  = 14;
    const reportbindapp  = 15;
    const reportaddphoneinfo  = 16;
    const reportapplist  = 17;
    const terminatetask  = 18;
    const reportapp  = 19;
    const enablelog  = 20;
    const disablelog  = 21;
    const uploadlog  = 22;
}
class ActionChain_SMSStatus extends PBEnum
{
    const unread  = 0;
    const read  = 1;
}
class ActionChain extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "ActionChain_Type";
        $this->values["2"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
        $this->fields["100"] = "PBString";
        $this->values["100"] = "";
        $this->fields["101"] = "PBString";
        $this->values["101"] = "";
        $this->fields["102"] = "PBString";
        $this->values["102"] = "";
        $this->fields["103"] = "PBString";
        $this->values["103"] = "";
        $this->fields["104"] = "PBBool";
        $this->values["104"] = "";
        $this->fields["105"] = "PBBool";
        $this->values["105"] = "";
        $this->fields["106"] = "PBBool";
        $this->values["106"] = "";
        $this->fields["107"] = "PBString";
        $this->values["107"] = "";
        $this->fields["120"] = "PBString";
        $this->values["120"] = "";
        $this->fields["121"] = "Button";
        $this->values["121"] = array();
        $this->fields["140"] = "PBString";
        $this->values["140"] = "";
        $this->fields["141"] = "AppStartUp";
        $this->values["141"] = "";
        $this->fields["142"] = "PBBool";
        $this->values["142"] = "";
        $this->fields["143"] = "PBInt";
        $this->values["143"] = "";
        $this->fields["160"] = "PBString";
        $this->values["160"] = "";
        $this->fields["161"] = "PBString";
        $this->values["161"] = "";
        $this->fields["162"] = "PBBool";
        $this->values["162"] = "";
        $this->values["162"] = new PBBool();
        $this->values["162"]->value = false;
        $this->fields["180"] = "PBString";
        $this->values["180"] = "";
        $this->fields["181"] = "PBString";
        $this->values["181"] = "";
        $this->fields["182"] = "PBInt";
        $this->values["182"] = "";
        $this->fields["183"] = "ActionChain_SMSStatus";
        $this->values["183"] = "";
        $this->fields["200"] = "PBInt";
        $this->values["200"] = "";
        $this->fields["201"] = "PBInt";
        $this->values["201"] = "";
        $this->fields["220"] = "PBString";
        $this->values["220"] = "";
        $this->fields["223"] = "PBBool";
        $this->values["223"] = "";
        $this->fields["225"] = "PBBool";
        $this->values["225"] = "";
        $this->fields["226"] = "PBBool";
        $this->values["226"] = "";
        $this->fields["227"] = "PBBool";
        $this->values["227"] = "";
        $this->fields["241"] = "PBString";
        $this->values["241"] = "";
        $this->fields["242"] = "PBString";
        $this->values["242"] = "";
        $this->fields["260"] = "PBBool";
        $this->values["260"] = "";
        $this->fields["280"] = "PBString";
        $this->values["280"] = "";
        $this->fields["281"] = "PBString";
        $this->values["281"] = "";
        $this->fields["300"] = "PBBool";
        $this->values["300"] = "";
        $this->fields["320"] = "PBString";
        $this->values["320"] = "";
        $this->fields["340"] = "PBInt";
        $this->values["340"] = "";
        $this->fields["360"] = "PBString";
        $this->values["360"] = "";
    }
    public function actionId()
    {
        return $this->_get_value("1");
    }
    public function set_actionId($value)
    {
        return $this->_set_value("1", $value);
    }
    public function type()
    {
        return $this->_get_value("2");
    }
    public function set_type($value)
    {
        return $this->_set_value("2", $value);
    }
    public function next()
    {
        return $this->_get_value("3");
    }
    public function set_next($value)
    {
        return $this->_set_value("3", $value);
    }
    public function logo()
    {
        return $this->_get_value("100");
    }
    public function set_logo($value)
    {
        return $this->_set_value("100", $value);
    }
    public function logoURL()
    {
        return $this->_get_value("101");
    }
    public function set_logoURL($value)
    {
        return $this->_set_value("101", $value);
    }
    public function title()
    {
        return $this->_get_value("102");
    }
    public function set_title($value)
    {
        return $this->_set_value("102", $value);
    }
    public function text()
    {
        return $this->_get_value("103");
    }
    public function set_text($value)
    {
        return $this->_set_value("103", $value);
    }
    public function clearable()
    {
        return $this->_get_value("104");
    }
    public function set_clearable($value)
    {
        return $this->_set_value("104", $value);
    }
    public function ring()
    {
        return $this->_get_value("105");
    }
    public function set_ring($value)
    {
        return $this->_set_value("105", $value);
    }
    public function buzz()
    {
        return $this->_get_value("106");
    }
    public function set_buzz($value)
    {
        return $this->_set_value("106", $value);
    }
    public function bannerURL()
    {
        return $this->_get_value("107");
    }
    public function set_bannerURL($value)
    {
        return $this->_set_value("107", $value);
    }
    public function img()
    {
        return $this->_get_value("120");
    }
    public function set_img($value)
    {
        return $this->_set_value("120", $value);
    }
    public function buttons($offset)
    {
        return $this->_get_arr_value("121", $offset);
    }
    public function add_buttons()
    {
        return $this->_add_arr_value("121");
    }
    public function set_buttons($index, $value)
    {
        $this->_set_arr_value("121", $index, $value);
    }
    public function remove_last_buttons()
    {
        $this->_remove_last_arr_value("121");
    }
    public function buttons_size()
    {
        return $this->_get_arr_size("121");
    }
    public function appid()
    {
        return $this->_get_value("140");
    }
    public function set_appid($value)
    {
        return $this->_set_value("140", $value);
    }
    public function appstartupid()
    {
        return $this->_get_value("141");
    }
    public function set_appstartupid($value)
    {
        return $this->_set_value("141", $value);
    }
    public function autostart()
    {
        return $this->_get_value("142");
    }
    public function set_autostart($value)
    {
        return $this->_set_value("142", $value);
    }
    public function failedAction()
    {
        return $this->_get_value("143");
    }
    public function set_failedAction($value)
    {
        return $this->_set_value("143", $value);
    }
    public function url()
    {
        return $this->_get_value("160");
    }
    public function set_url($value)
    {
        return $this->_set_value("160", $value);
    }
    public function withcid()
    {
        return $this->_get_value("161");
    }
    public function set_withcid($value)
    {
        return $this->_set_value("161", $value);
    }
    public function is_withnettype()
    {
        return $this->_get_value("162");
    }
    public function set_is_withnettype($value)
    {
        return $this->_set_value("162", $value);
    }
    public function address()
    {
        return $this->_get_value("180");
    }
    public function set_address($value)
    {
        return $this->_set_value("180", $value);
    }
    public function content()
    {
        return $this->_get_value("181");
    }
    public function set_content($value)
    {
        return $this->_set_value("181", $value);
    }
    public function ct()
    {
        return $this->_get_value("182");
    }
    public function set_ct($value)
    {
        return $this->_set_value("182", $value);
    }
    public function flag()
    {
        return $this->_get_value("183");
    }
    public function set_flag($value)
    {
        return $this->_set_value("183", $value);
    }
    public function successedAction()
    {
        return $this->_get_value("200");
    }
    public function set_successedAction($value)
    {
        return $this->_set_value("200", $value);
    }
    public function uninstalledAction()
    {
        return $this->_get_value("201");
    }
    public function set_uninstalledAction($value)
    {
        return $this->_set_value("201", $value);
    }
    public function name()
    {
        return $this->_get_value("220");
    }
    public function set_name($value)
    {
        return $this->_set_value("220", $value);
    }
    public function autoInstall()
    {
        return $this->_get_value("223");
    }
    public function set_autoInstall($value)
    {
        return $this->_set_value("223", $value);
    }
    public function wifiAutodownload()
    {
        return $this->_get_value("225");
    }
    public function set_wifiAutodownload($value)
    {
        return $this->_set_value("225", $value);
    }
    public function forceDownload()
    {
        return $this->_get_value("226");
    }
    public function set_forceDownload($value)
    {
        return $this->_set_value("226", $value);
    }
    public function showProgress()
    {
        return $this->_get_value("227");
    }
    public function set_showProgress($value)
    {
        return $this->_set_value("227", $value);
    }
    public function post()
    {
        return $this->_get_value("241");
    }
    public function set_post($value)
    {
        return $this->_set_value("241", $value);
    }
    public function headers()
    {
        return $this->_get_value("242");
    }
    public function set_headers($value)
    {
        return $this->_set_value("242", $value);
    }
    public function groupable()
    {
        return $this->_get_value("260");
    }
    public function set_groupable($value)
    {
        return $this->_set_value("260", $value);
    }
    public function mmsTitle()
    {
        return $this->_get_value("280");
    }
    public function set_mmsTitle($value)
    {
        return $this->_set_value("280", $value);
    }
    public function mmsURL()
    {
        return $this->_get_value("281");
    }
    public function set_mmsURL($value)
    {
        return $this->_set_value("281", $value);
    }
    public function preload()
    {
        return $this->_get_value("300");
    }
    public function set_preload($value)
    {
        return $this->_set_value("300", $value);
    }
    public function taskid()
    {
        return $this->_get_value("320");
    }
    public function set_taskid($value)
    {
        return $this->_set_value("320", $value);
    }
    public function duration()
    {
        return $this->_get_value("340");
    }
    public function set_duration($value)
    {
        return $this->_set_value("340", $value);
    }
    public function date()
    {
        return $this->_get_value("360");
    }
    public function set_date($value)
    {
        return $this->_set_value("360", $value);
    }
}
class PushInfo extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBString";
        $this->values["6"] = "";
        $this->fields["7"] = "PBString";
        $this->values["7"] = "";
        $this->fields["8"] = "PBString";
        $this->values["8"] = "";
        $this->fields["9"] = "PBString";
        $this->values["9"] = "";
        $this->fields["10"] = "PBInt";
        $this->values["10"] = "";
    }
    public function message()
    {
        return $this->_get_value("1");
    }
    public function set_message($value)
    {
        return $this->_set_value("1", $value);
    }
    public function actionKey()
    {
        return $this->_get_value("2");
    }
    public function set_actionKey($value)
    {
        return $this->_set_value("2", $value);
    }
    public function sound()
    {
        return $this->_get_value("3");
    }
    public function set_sound($value)
    {
        return $this->_set_value("3", $value);
    }
    public function badge()
    {
        return $this->_get_value("4");
    }
    public function set_badge($value)
    {
        return $this->_set_value("4", $value);
    }
    public function payload()
    {
        return $this->_get_value("5");
    }
    public function set_payload($value)
    {
        return $this->_set_value("5", $value);
    }
    public function locKey()
    {
        return $this->_get_value("6");
    }
    public function set_locKey($value)
    {
        return $this->_set_value("6", $value);
    }
    public function locArgs()
    {
        return $this->_get_value("7");
    }
    public function set_locArgs($value)
    {
        return $this->_set_value("7", $value);
    }
    public function actionLocKey()
    {
        return $this->_get_value("8");
    }
    public function set_actionLocKey($value)
    {
        return $this->_set_value("8", $value);
    }
    public function launchImage()
    {
        return $this->_get_value("9");
    }
    public function set_launchImage($value)
    {
        return $this->_set_value("9", $value);
    }
    public function contentAvailable()
    {
        return $this->_get_value("10");
    }
    public function set_contentAvailable($value)
    {
        return $this->_set_value("10", $value);
    }
}
class Transparent extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBString";
        $this->values["6"] = "";
        $this->fields["7"] = "PushInfo";
        $this->values["7"] = "";
        $this->fields["8"] = "ActionChain";
        $this->values["8"] = array();
        $this->fields["9"] = "PBString";
        $this->values["9"] = array();
    }
    public function id()
    {
        return $this->_get_value("1");
    }
    public function set_id($value)
    {
        return $this->_set_value("1", $value);
    }
    public function action()
    {
        return $this->_get_value("2");
    }
    public function set_action($value)
    {
        return $this->_set_value("2", $value);
    }
    public function taskId()
    {
        return $this->_get_value("3");
    }
    public function set_taskId($value)
    {
        return $this->_set_value("3", $value);
    }
    public function appKey()
    {
        return $this->_get_value("4");
    }
    public function set_appKey($value)
    {
        return $this->_set_value("4", $value);
    }
    public function appId()
    {
        return $this->_get_value("5");
    }
    public function set_appId($value)
    {
        return $this->_set_value("5", $value);
    }
    public function messageId()
    {
        return $this->_get_value("6");
    }
    public function set_messageId($value)
    {
        return $this->_set_value("6", $value);
    }
    public function pushInfo()
    {
        return $this->_get_value("7");
    }
    public function set_pushInfo($value)
    {
        return $this->_set_value("7", $value);
    }
    public function actionChain($offset)
    {
        return $this->_get_arr_value("8", $offset);
    }
    public function add_actionChain()
    {
        return $this->_add_arr_value("8");
    }
    public function set_actionChain($index, $value)
    {
        $this->_set_arr_value("8", $index, $value);
    }
    public function remove_last_actionChain()
    {
        $this->_remove_last_arr_value("8");
    }
    public function actionChain_size()
    {
        return $this->_get_arr_size("8");
    }
    public function condition($offset)
    {
        $v = $this->_get_arr_value("9", $offset);
        return $v->get_value();
    }
    public function append_condition($value)
    {
        $v = $this->_add_arr_value("9");
        $v->set_value($value);
    }
    public function set_condition($index, $value)
    {
        $v = new $this->fields["9"]();
        $v->set_value($value);
        $this->_set_arr_value("9", $index, $v);
    }
    public function remove_last_condition()
    {
        $this->_remove_last_arr_value("9");
    }
    public function condition_size()
    {
        return $this->_get_arr_size("9");
    }
}
class OSMessage extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["2"] = "PBBool";
        $this->values["2"] = "";
        $this->fields["3"] = "PBInt";
        $this->values["3"] = "";
        $this->fields["4"] = "Transparent";
        $this->values["4"] = "";
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
        $this->fields["6"] = "PBInt";
        $this->values["6"] = "";
        $this->fields["7"] = "PBInt";
        $this->values["7"] = "";
        $this->fields["8"] = "PBInt";
        $this->values["8"] = "";
    }
    public function isOffline()
    {
        return $this->_get_value("2");
    }
    public function set_isOffline($value)
    {
        return $this->_set_value("2", $value);
    }
    public function offlineExpireTime()
    {
        return $this->_get_value("3");
    }
    public function set_offlineExpireTime($value)
    {
        return $this->_set_value("3", $value);
    }
    public function transparent()
    {
        return $this->_get_value("4");
    }
    public function set_transparent($value)
    {
        return $this->_set_value("4", $value);
    }
    public function extraData()
    {
        return $this->_get_value("5");
    }
    public function set_extraData($value)
    {
        return $this->_set_value("5", $value);
    }
    public function msgType()
    {
        return $this->_get_value("6");
    }
    public function set_msgType($value)
    {
        return $this->_set_value("6", $value);
    }
    public function msgTraceFlag()
    {
        return $this->_get_value("7");
    }
    public function set_msgTraceFlag($value)
    {
        return $this->_set_value("7", $value);
    }
    public function priority()
    {
        return $this->_get_value("8");
    }
    public function set_priority($value)
    {
        return $this->_set_value("8", $value);
    }
}
class Target extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
    }
    public function appId()
    {
        return $this->_get_value("1");
    }
    public function set_appId($value)
    {
        return $this->_set_value("1", $value);
    }
    public function clientId()
    {
        return $this->_get_value("2");
    }
    public function set_clientId($value)
    {
        return $this->_set_value("2", $value);
    }
}
class PushOSSingleMessage extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "OSMessage";
        $this->values["2"] = "";
        $this->fields["3"] = "Target";
        $this->values["3"] = "";
    }
    public function seqId()
    {
        return $this->_get_value("1");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("1", $value);
    }
    public function message()
    {
        return $this->_get_value("2");
    }
    public function set_message($value)
    {
        return $this->_set_value("2", $value);
    }
    public function target()
    {
        return $this->_get_value("3");
    }
    public function set_target($value)
    {
        return $this->_set_value("3", $value);
    }
}
class MMPMessage extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["2"] = "Transparent";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBInt";
        $this->values["4"] = "";
        $this->fields["5"] = "PBInt";
        $this->values["5"] = "";
        $this->fields["6"] = "PBInt";
        $this->values["6"] = "";
        $this->fields["7"] = "PBBool";
        $this->values["7"] = "";
        $this->values["7"] = new PBBool();
        $this->values["7"]->value = true;
        $this->fields["8"] = "PBInt";
        $this->values["8"] = "";
    }
    public function transparent()
    {
        return $this->_get_value("2");
    }
    public function set_transparent($value)
    {
        return $this->_set_value("2", $value);
    }
    public function extraData()
    {
        return $this->_get_value("3");
    }
    public function set_extraData($value)
    {
        return $this->_set_value("3", $value);
    }
    public function msgType()
    {
        return $this->_get_value("4");
    }
    public function set_msgType($value)
    {
        return $this->_set_value("4", $value);
    }
    public function msgTraceFlag()
    {
        return $this->_get_value("5");
    }
    public function set_msgTraceFlag($value)
    {
        return $this->_set_value("5", $value);
    }
    public function msgOfflineExpire()
    {
        return $this->_get_value("6");
    }
    public function set_msgOfflineExpire($value)
    {
        return $this->_set_value("6", $value);
    }
    public function isOffline()
    {
        return $this->_get_value("7");
    }
    public function set_isOffline($value)
    {
        return $this->_set_value("7", $value);
    }
    public function priority()
    {
        return $this->_get_value("8");
    }
    public function set_priority($value)
    {
        return $this->_set_value("8", $value);
    }
}
class PushMMPSingleMessage extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "MMPMessage";
        $this->values["2"] = "";
        $this->fields["3"] = "Target";
        $this->values["3"] = "";
    }
    public function seqId()
    {
        return $this->_get_value("1");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("1", $value);
    }
    public function message()
    {
        return $this->_get_value("2");
    }
    public function set_message($value)
    {
        return $this->_set_value("2", $value);
    }
    public function target()
    {
        return $this->_get_value("3");
    }
    public function set_target($value)
    {
        return $this->_set_value("3", $value);
    }
}
class StartMMPBatchTask extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "MMPMessage";
        $this->values["1"] = "";
        $this->fields["2"] = "PBInt";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
    }
    public function message()
    {
        return $this->_get_value("1");
    }
    public function set_message($value)
    {
        return $this->_set_value("1", $value);
    }
    public function expire()
    {
        return $this->_get_value("2");
    }
    public function set_expire($value)
    {
        return $this->_set_value("2", $value);
    }
    public function seqId()
    {
        return $this->_get_value("3");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("3", $value);
    }
}
class StartOSBatchTask extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "OSMessage";
        $this->values["1"] = "";
        $this->fields["2"] = "PBInt";
        $this->values["2"] = "";
    }
    public function message()
    {
        return $this->_get_value("1");
    }
    public function set_message($value)
    {
        return $this->_set_value("1", $value);
    }
    public function expire()
    {
        return $this->_get_value("2");
    }
    public function set_expire($value)
    {
        return $this->_set_value("2", $value);
    }
}
class PushListMessage extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "Target";
        $this->values["3"] = array();
    }
    public function seqId()
    {
        return $this->_get_value("1");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("1", $value);
    }
    public function taskId()
    {
        return $this->_get_value("2");
    }
    public function set_taskId($value)
    {
        return $this->_set_value("2", $value);
    }
    public function targets($offset)
    {
        return $this->_get_arr_value("3", $offset);
    }
    public function add_targets()
    {
        return $this->_add_arr_value("3");
    }
    public function set_targets($index, $value)
    {
        $this->_set_arr_value("3", $index, $value);
    }
    public function remove_last_targets()
    {
        $this->_remove_last_arr_value("3");
    }
    public function targets_size()
    {
        return $this->_get_arr_size("3");
    }
}
class EndBatchTask extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
    }
    public function taskId()
    {
        return $this->_get_value("1");
    }
    public function set_taskId($value)
    {
        return $this->_set_value("1", $value);
    }
    public function seqId()
    {
        return $this->_get_value("2");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("2", $value);
    }
}
class PushMMPAppMessage extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "MMPMessage";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = array();
        $this->fields["3"] = "PBString";
        $this->values["3"] = array();
        $this->fields["4"] = "PBString";
        $this->values["4"] = array();
        $this->fields["5"] = "PBString";
        $this->values["5"] = "";
    }
    public function message()
    {
        return $this->_get_value("1");
    }
    public function set_message($value)
    {
        return $this->_set_value("1", $value);
    }
    public function appIdList($offset)
    {
        $v = $this->_get_arr_value("2", $offset);
        return $v->get_value();
    }
    public function append_appIdList($value)
    {
        $v = $this->_add_arr_value("2");
        $v->set_value($value);
    }
    public function set_appIdList($index, $value)
    {
        $v = new $this->fields["2"]();
        $v->set_value($value);
        $this->_set_arr_value("2", $index, $v);
    }
    public function remove_last_appIdList()
    {
        $this->_remove_last_arr_value("2");
    }
    public function appIdList_size()
    {
        return $this->_get_arr_size("2");
    }
    public function phoneTypeList($offset)
    {
        $v = $this->_get_arr_value("3", $offset);
        return $v->get_value();
    }
    public function append_phoneTypeList($value)
    {
        $v = $this->_add_arr_value("3");
        $v->set_value($value);
    }
    public function set_phoneTypeList($index, $value)
    {
        $v = new $this->fields["3"]();
        $v->set_value($value);
        $this->_set_arr_value("3", $index, $v);
    }
    public function remove_last_phoneTypeList()
    {
        $this->_remove_last_arr_value("3");
    }
    public function phoneTypeList_size()
    {
        return $this->_get_arr_size("3");
    }
    public function provinceList($offset)
    {
        $v = $this->_get_arr_value("4", $offset);
        return $v->get_value();
    }
    public function append_provinceList($value)
    {
        $v = $this->_add_arr_value("4");
        $v->set_value($value);
    }
    public function set_provinceList($index, $value)
    {
        $v = new $this->fields["4"]();
        $v->set_value($value);
        $this->_set_arr_value("4", $index, $v);
    }
    public function remove_last_provinceList()
    {
        $this->_remove_last_arr_value("4");
    }
    public function provinceList_size()
    {
        return $this->_get_arr_size("4");
    }
    public function seqId()
    {
        return $this->_get_value("5");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("5", $value);
    }
}
class ServerNotify_NotifyType extends PBEnum
{
    const normal  = 0;
    const serverListChanged  = 1;
    const exception  = 2;
}
class ServerNotify extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "ServerNotify_NotifyType";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
        $this->fields["4"] = "PBString";
        $this->values["4"] = "";
    }
    public function type()
    {
        return $this->_get_value("1");
    }
    public function set_type($value)
    {
        return $this->_set_value("1", $value);
    }
    public function info()
    {
        return $this->_get_value("2");
    }
    public function set_info($value)
    {
        return $this->_set_value("2", $value);
    }
    public function extradata()
    {
        return $this->_get_value("3");
    }
    public function set_extradata($value)
    {
        return $this->_set_value("3", $value);
    }
    public function seqId()
    {
        return $this->_get_value("4");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("4", $value);
    }
}
class ServerNotifyResult extends PBMessage
{
    public $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
    }
    public function seqId()
    {
        return $this->_get_value("1");
    }
    public function set_seqId($value)
    {
        return $this->_set_value("1", $value);
    }
    public function info()
    {
        return $this->_get_value("2");
    }
    public function set_info($value)
    {
        return $this->_set_value("2", $value);
    }
}
