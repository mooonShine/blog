<?php

/**
 * Description of Smodel
 *
 * @author Sgenmi
 * @date 2014-02-18 02:30
 */
class Smodel extends Medoo
{

    public function loginfo($action, $content)
    {
        $table = $this->table;
        $this->table = "log";
        $s = new Component_Session();
        $ui = $s->get("userinfo");
        if (!$ui) {
            throw  new Exception("用户信息丢失");
            return false;
        }
        $this->insert([
            'op_name' => $ui['uname'],
            'op_id' => $ui["uid"],
            'op_content' => $content,
            'op_action' => $action,
            'op_time' => time(),
            'op_date' => strtotime(date('Y-m-d', time())),
        ]);
        $this->table = $table;
    }
}