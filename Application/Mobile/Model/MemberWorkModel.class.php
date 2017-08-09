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
        $data['type'] = 1; //工时记录类型  0正常  1补录
        $data['additional_recording_time'] = $work_info['additional_recording_time'];
        $data['additional_recording'] = $work_info['additional_recording'];
        $data['work_hours'] = $work_info['work_hours'];
        $data['work_content'] = $work_info['work_content'] ;
        $is_success = $this->add($data) ? true : false;
        return $is_success;
    }

    


    
    /**
     * @description:根据id查询工时详情
     * @author wuyanwen(2016年12月1日)
     * @param unknown $employee_id
     */
    public function findWorkById($where)
    {
        $wrok_detail = $this->where($where)->find();
        $wrok_detail['project_name'] = M('project')->where('id='.$wrok_detail['pid'])->getField('project_name');
        return $wrok_detail;
    }

}