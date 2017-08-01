<?php
namespace Mobile\Model;

class MemberWorkModel extends BaseModel
{
    protected $tableName = 'member_work';
    


    
    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num
     * @return multitype:unknown string
     */
    public function selectAllWrok($where='')
    {

        //$count      = $this->where($where)->count();
      //  $page       = new \Think\Page($count,$num);
       // $show       = $page->show();
        $list       = $this->where($where)->select();

        foreach ($list as & $v){
           $v['project_name'] = M('project')->where('id='.$v['pid'])->getField('project_name');
        }

        return $list;
    
    }
    
    /**
 * @description:添加工时
 * @author wuyanwen(2016年12月1日)
 * @param unknown $data
 * @return boolean
 */
    public function addWork($work_info)
    {

        $data['uid'] = $work_info['uid'];
        $data['created_time'] = $work_info['created_time'];
       $data['pid'] = $work_info['pid'] ;
            $data['work_hours'] = $work_info['work_hours'] ;
            $data['work_content'] = $work_info['work_content'] ;
            $is_success = $this->add($data) ? true : false;


        return $is_success;
    }
    /**
     * @description:补录工时
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     * @return boolean
     */
    public function addMakeupWork($work_info)
    {
        $where['uid'] = $work_info['uid'];
        $where['pid'] =  $work_info['pid'];
        $mid = M('member_work')->where($where)->getField('id');
        $data['mid'] = $mid ;
        $data['additional_recording_time'] = $work_info['additional_recording_time'];
        $data['additional_recording'] = $work_info['additional_recording'];


            $data['work_hours'] = $work_info['work_hours'];
            $data['work_content'] = $work_info['work_content'] ;

            $is_success = M('makeup_member_work')->add($data) ? true : false;



        return $is_success;
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