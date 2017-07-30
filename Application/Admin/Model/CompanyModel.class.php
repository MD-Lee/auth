<?php
namespace Admin\Model;

class CompanyModel extends BaseModel
{
    protected $tableName = 'company';

    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num
     * @return multitype:unknown string
     */
    public function selectAllCompany($num=10)
    {
        $count      = $this->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
    
        return array('page' => $show , 'list' => $list);
    
    }
    
    /**
     * @description:添加公司
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     * @return boolean
     */
    public function addCompany($data)
    {
        return $this->add($data) ? true : false;
    }
    
    /**
     * @description:更新公司信息
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     */
    public function editCompany($data)
    {
        $where = array(
            'id'    => $data['id'],
        );

        unset($data['id']);
        
        return $this->where($where)->save($data);
    }
    
    /**
     * @description:删除公司
     * @author wuyanwen(2016年12月1日)
     * @param unknown $user_id
     * @return Ambigous <boolean, unknown>
     */
    public function deleteCompany($company_id)
    {
        $where = array(
            'id' => $company_id,
        );

        return $this->where($where)->delete();
    }
    
    
    /**
     * @description:根据id查询用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $user_id
     */
    public function findCompanyById($company_id)
    {
        $where = array(
            'id'     => $company_id,
        );
        
        return $this->where($where)->find();
    }
    
    public function findCompanyByName($company_name)
    {
        $where = array(
            'name' => $company_name,
        );
        
        
        return $this->where($where)->find();
    }

    public function getGroupByCid($cid){
        $where = array(
            'id' => $cid,
        );
         return M('company_group')->where($where)->select();
    }
}