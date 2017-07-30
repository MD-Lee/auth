<?php
namespace Admin\Model;

class ProjectModel extends BaseModel
{
    protected $tableName = 'project';
    
    /**
     * @description:查询用户
     * @author wuyanwen(2016年11月22日)
     */
    public function findProject($name, $pwd)
    {
        $where = array(
            'Project_name' => $name,
            'password' => md5($pwd),
            'status'   => parent::NORMAL_STATUS,
        );
        
        $result = $this->where($where)->find();
        
        return $result;
    }
    
    /**
     * 根据id更新用户登录时间
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     * @param unknown $id
     */
    public function updateLoginTime($id)
    {
        $where = array(
            'id' => $id,
        );
        $saveData = array(
            'lastlogin_time' => time(),
        );
        return $this->where($where)->save($saveData);
    }
    
    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num
     * @return multitype:unknown string
     */
    public function selectAllProject($num=10,$where='')
    {
        /*$where = array(
            'status' => parent::NORMAL_STATUS,
        );*/
    
        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
    
        return array('page' => $show , 'list' => $list);
    
    }
    
    /**
     * @description:添加后台项目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     * @return boolean
     */
    public function addProject($data)
    {
        return $this->add($data) ? true : false;
    }
    
    /**
     * @description:更新项目信息
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     */
    public function editProject($data)
    {
        $where = array(
            'id'    => $data['id'],
        );

        unset($data['id']);


        return $this->where($where)->save($data);
    }


    /**
     * @description:删除项目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $Project_id
     * @return Ambigous <boolean, unknown>
     */
    public function deleteProject($Project_id)
    {
        $where = array(
            'id' => $Project_id,            
        );
        

        return $this->where($where)->delete();
    }
    
    
    /**
     * @description:根据id查询用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $Project_id
     */
    public function findProjectById($Project_id)
    {
        $where = array(
            'id'     => $Project_id
        );
        
        return $this->where($where)->find();
    }
    
    public function findProjectByName($Project_name)
    {
        $where = array(
            'project_name' => $Project_name,
            'status'    => parent::NORMAL_STATUS,
        );
        
        
        return $this->where($where)->find();
    }

    public function addProjectMember($project_info)
    {

        $data['pid'] = $project_info['pid'];

        foreach ($project_info['eid'] as $k=> $v){

            $data['eid'] = $v ;
            $data['member_ratio'] =$project_info['member_ratio'][$k] ;

            $is_success = M('project_member')->add($data) ? true : false;

            if($is_success == false) break;
        }
        return $is_success;
    }

}