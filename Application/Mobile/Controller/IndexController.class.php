<?php
namespace Mobile\Controller;

use Think\Controller;

class IndexController extends CommonController {
    protected $work_model;


    public function index()
    {
        $work_model = D('MemberWork');

        $this->work_model = $work_model;

        $user_info = session('user_info');
        $where['uid'] = $user_info['id'];

        $work_info = $this->work_model->selectAllWrok($where);

        //echo D('MemberWork')->getLastSql();
        $this->assign('work_info',$work_info);
        $this->display();
    }
    /**
     * @description:添加工时
     * @author wuyanwen(2016年12月1日)
     */
    public function addWork()
    {
        $user_info = session('user_info');
        $uid = $user_info['id'];
        if(IS_POST){
            //Array (
            // [pid] => Array ( [0] => 2 [1] => 2 )
            // [work_hours] => Array ( [0] => 1 [1] => 3 ) [
            //work_content] => Array ( [0] => 去 [1] => 订单 )

            $work_info = array(
                'pid'      => I('post.pid'),
                'work_hours'      => I('post.work_hours'),
                'work_content'      => I('post.work_content'),
                'uid'      => $uid,
                'created_time'      => time(),
            );

            if(D('MemberWork')->addWork($work_info)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $project_member_model = D('ProjectMember');
            $project_list = $project_member_model->getProjectListByUid($uid);

            $this->assign('project_list', $project_list);

            $this->display();
        }
    }

    //工时详情
    public function  detailWork(){
        $member_work_id = I('id');
        $work_model = D('MemberWork');

        $this->work_model = $work_model;

        $user_info = session('user_info');
        $where['uid'] = $user_info['id'];
        $where['id'] = $member_work_id;
        $work_info_detail = $this->work_model->findWorkById($where);
        $this->assign('work_info_detail', $work_info_detail);

        $this->display();
    }

    //补录
    public function makeupWork()
    {
        $user_info = session('user_info');
        $uid = $user_info['id'];
        if(IS_POST){
            //Array (
            // [additional_recording_time] => 2017-07-25
            // [additional_recording] => 333
            // [work_hours] => Array ( [0] => 5 )
            // [work_content] => Array ( [0] => 4 )
            // [mid] => 1 )
            $work_info = array(
                'pid'      => I('post.pid'),
                'additional_recording_time'      => I('post.additional_recording_time'),
                'additional_recording'      => I('post.additional_recording'),
                'work_hours'      => I('post.work_hours'),
                'work_content'      => I('post.work_content'),
                'uid'      => $uid,
            );

            if(D('MemberWork')->addMakeupWork($work_info)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $project_member_model = D('ProjectMember');
            $project_list = $project_member_model->getProjectListByUid($uid);

            $this->assign('project_list', $project_list);


            $this->display();
        }
    }

}