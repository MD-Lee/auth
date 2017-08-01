<?php
namespace Mobile\Controller;
use Think\Controller;


class CommonController extends Controller {
    

    /**
     * @description:错误返回
     * @author wuyanwen(2016年11月22日)
     * @param string $msg
     * @param unknown $fields
     */
    protected function ajaxError($msg='', $fields=array())
    {
        header('Content-Type:application/json; charset=utf-8');
        $data = array('status'=>'error', 'msg'=>$msg, 'fields'=>$fields);
        echo json_encode($data);
        exit;
    }
    
    protected function ajaxSuccess($msg, $_data=array())
    {
        header('Content-Type:application/json; charset=utf-8');
        $data = array('status'=>'success', 'msg' => $msg ,'data'=>$_data);
        echo json_encode($data);
        exit;
    }
}