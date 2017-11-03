<?php

/**
 * Created by IntelliJ IDEA.
 * User: zb
 * Date: 16-12-5
 * Time: 下午1:53
 */
class Model_Test extends Smodel
{
    protected $table = "test";

    public function index()
    {
        $this->begin();
        var_dump($this->select("*"));
        var_dump($this->update(array('name' => 'bbbbbc'), ["id" => 1]));
        var_dump($this->insert(array('name'=>'sdfsdfs')));
        $this->commit();
    }
}