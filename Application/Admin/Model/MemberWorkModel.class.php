<?php
namespace Admin\Model;

class MemberWorkModel extends BaseModel
{
    protected $tableName = 'member_work';
    
    /**
     * @description:查询用户
     * @author wuyanwen(2016年11月22日)
     */
    public function findEmployee($name, $pwd)
    {
        $where = array(
            'employee_name' => $name,
            'password' => md5($pwd),
            'status'   => parent::NORMAL_STATUS,
        );
        
        $result = $this->where($where)->find();
        
        return $result;
    }
    

    
    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num
     * @return multitype:unknown string
     */
    public function selectAllWrok($num=10,$where='')
    {

        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();

        foreach ($list as & $v){
           $v['project_name'] = M('project')->where('id='.$v['pid'])->getField('project_name');
        }

        return array('page' => $show , 'list' => $list);
    
    }
    
    /**
     * @description:添加后台员工
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     * @return boolean
     */
    public function addEmployee($data)
    {
        return $this->add($data) ? true : false;
    }
    
    /**
     * @description:更新用户信息
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     */
    public function editEmployee($data)
    {
        $where = array(
            'id'    => $data['id'],
        );

        unset($data['id']);
        
        return $this->where($where)->save($data);
    }
    
    /**
     * @description:删除用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $employee_id
     * @return Ambigous <boolean, unknown>
     */
    public function deleteAdminemployee($employee_id)
    {
        $where = array(
            'id' => $employee_id,            
        );
        
        $data = array(
            'status' => parent::DEL_STATUS,
        );
        
        return $this->where($where)->save($data);
    }
    
    
    /**
     * @description:根据id查询用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $employee_id
     */
    public function findAdminemployeeById($employee_id)
    {
        $where = array(
            'id'     => $employee_id,
            'status' => parent::NORMAL_STATUS,
        );
        
        return $this->where($where)->find();
    }
    
    public function findAdminemployeeByName($employee_name)
    {
        $where = array(
            'employee_name' => $employee_name,
            'status'    => parent::NORMAL_STATUS,
        );
        
        
        return $this->where($where)->find();
    }
}