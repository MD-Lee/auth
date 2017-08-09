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
     * @description:首页获取总工时列表
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num
     * @return multitype:unknown string
     */

    public function getAllWrokMember($where=''){
        $where['g.group_id'] = array('neq',27);//员工id 非超级管理员
        $work_member =  M('admin_user')->alias('a')
            ->join('admin_auth_group_access as g on a.id=g.uid')
            ->join('company as c on a.cid=c.id')
            ->join('company_group as cg on a.gid=cg.id')
            ->where($where)->field('a.user_name,a.id,a.wages,c.name,cg.group_name,a.wages')->select();
        return $work_member;
    }


    public function getMemberWorkHours($where){
        $work_hours = $this->where($where)->sum('work_hours');
        return $work_hours;
    }
    //个人分账

    public function getPersonSplitWorkHours($where){
        //总工时
        $work_hours =  M('member_work')->alias('mw')
            ->join('project as p on mw.pid=p.id')
            ->where($where)->field('sum(mw.work_hours) as work_hours')->find();

        return $work_hours['work_hours'];
    }
    public function getPersonSplit($where){

       $person_split =  M('project_member')->alias('pm')
            ->join('project as p on pm.pid=p.id')
            ->where($where)->field('p.money,p.achievements_ratio,pm.member_ratio')->select();
       $split_money = '';
       foreach ($person_split as $v){
        $split_money +=round(($v['money']*$v['achievements_ratio']*$v['member_ratio']/10000),2);
       }
        return $split_money;


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
        foreach ($work_info['pid'] as $k=>$v){
            $data['pid'] = $v ;
            $data['work_hours'] = $work_info['work_hours'][$k] ;
            $data['work_content'] = $work_info['work_content'][$k] ;
            $is_success = $this->add($data) ? true : false;
            if($is_success == false) break;
        }
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
        $data['uid'] = $work_info['uid'];
        $data['created_time'] = time();
        $data['additional_recording_time'] = strtotime($work_info['additional_recording_time']);
        $data['additional_recording'] = $work_info['additional_recording'];
        $data['type'] = 1; //工时记录类型  0正常  1补录
        foreach ($work_info['work_hours'] as $k=>$v){
            $data['work_hours'] = $v ;
            $data['work_content'] = $work_info['work_content'][$k] ;
            $data['pid'] = $work_info['pid'][$k] ;
            $is_success = $this->add($data) ? true : false;
            if($is_success == false) break;
        }
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