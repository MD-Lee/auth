<?php
namespace Admin\Model;

class ProjectMemberModel extends BaseModel
{
    protected $tableName = 'project_member';



    /**
     * @description:更新公司小组
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     */
    public function editCompanyGroup($data)
    {
        $where = array(
            'id'    => $data['id'],
        );


        unset($data['id']);

        return $this->where($where)->save($data);
    }
    /**
     * @description:添加公司小组
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     * @return boolean
     */
    public function addCompanyGroup($group_info)
    {

        $data['cid'] = $group_info['cid'];
        foreach ($group_info['group_name'] as $v){

        $data['group_name'] = $v ;

        $is_success = $this->add($data) ? true : false;

        if($is_success == false) break;
        }
        return $is_success;
    }

    /**
     * @description:根据group_name查询公司小组是否存在
     * @author wuyanwen(2016年12月1日)
     * @param unknown $group_info
     */
    public function findCompanyGroupByName($group_info)
    {
        $cid = $group_info['cid'];

        $group_name = $group_info['group_name'];

        $hsa = false;
        foreach ($group_name as $v){
            $where = array(
                'group_name' => $v,
                'cid' => $cid,
            );
           $result = $this->where($where)->find();
           if($result){
               $hsa = true;
               break;
           }
        }

        return $hsa;
    }
    /**
     * @description:根据id查询公司小组
     * @author wuyanwen(2016年12月1日)
     * @param unknown $company_id
     */
    public function findCompanyGroupById($group_id)
    {
        $where = array(
            'id'     => $group_id,
        );

        return $this->where($where)->find();
    }


    /**
     * @description:删除公司小组
     * @author wuyanwen(2016年12月1日)
     * @param unknown $user_id
     * @return Ambigous <boolean, unknown>
     */
    public function deleteCompanyGroup($group_id)
    {
        $where = array(
            'id' => $group_id,
        );
        return $this->where($where)->delete();
    }

    /**
     * @description:公司下所有公司小组
     * @author wuyanwen(2016年12月1日)
     * @param unknown $user_id
     * @return Ambigous <boolean, unknown>
     */
    public function getAllCompanyGroupById($company_info)
    {
        foreach ($company_info['list'] as & $v) {
            $where = array(
                    'cid' => $v['id'],
            );
            $v['group_list']  = $this->where($where)->select();
        }



        return $company_info;

    }

}