<?php
namespace Admin\Model;

use Think\Model;

class BaseModel extends Model
{
    const NORMAL_STATUS = 1;
    const DEL_STATUS    = 2;
    const PAGE_LIMIT = 15;
    public  function findAllCompany(){
        return M('company')->select();
    }
    public function findGroup($cid){
        $where['cid'] = $cid;
        return M('company_group')->where($where)->select();
    }
}