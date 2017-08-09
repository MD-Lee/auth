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
     * @param unknown type 1首页获取项目 无条数限制
     * @return multitype:unknown string
     */
    public function selectAllProject($num=10,$where='',$type='')
    {
        /*$where = array(
            'status' => parent::NORMAL_STATUS,
        );*/
        if(!$type){
            $count      = $this->where($where)->count();
            $page       = new \Think\Page($count,$num);
            $show       = $page->show();
            $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        }else{
            $list       = $this->where($where)->select();
            $show       = '';
        }


        foreach ($list as & $v){
            //财务审核状态
            if( $v['finance_status']==0){
                $v['finance_status_name'] = "未审核";
            }elseif($v['finance_status'] == 1){
                $v['finance_status_name'] = "审核通过";
            }else{
                $v['finance_status_name'] = "已分帐";
            }
            $v['status_name'] = $v['status']==1?"已完工":"进行中";



            //运营成本
            $cost = unserialize($v['cost']);
            $operate_cost = '';
            foreach ($cost as $cv){
                $operate_cost +=$cv;
            }
            //人工成本计算
           $uid_list = M('project_member')->where('pid='.$v['id'])->field('eid')->select();

            $person_cost ='';
           foreach ($uid_list as $u){
               $wages = M('admin_user')->where('id='.$u['eid'])->getField('wages');//个人工资
               $where['pid'] = $v['id'];
               $where['uid'] = $u['eid'];
               $person_sum_time = M('member_work')->where($where)->sum('work_hours');//个人总录入工时
              // $person_sum_time +=$person_sum_time;
               $person_cost += $person_sum_time*($wages/176);//人工成本=工时*个人工资/(21*8) 21天8小时
           }

            $v['sum_work_hours'] = $person_sum_time; //工时合计

            $v['person_cost'] =round( $person_cost,2);//人工成本

            $v['sum_cost'] =  round(($person_cost+$operate_cost),2);//总成本 =人工成本+运营成本

            //总利润＝项目合同额 — 税费（合同额/（1+税率）*税率＊（1+12.5%））－人工成本 －运营成本
            $taxation_formula = M('config')->where('id=1')->getField('taxation_formula');//税费公式
            $taxation_formula= str_replace('合同额',$v['money'],$taxation_formula);
            $taxation = eval("return $taxation_formula;");
            /*$lee = str_replace('合同额',10000,$config_info);
                       $result=eval("return $lee;");
                       echo $result;*/

            $v['sum_profit'] = round(($v['money']- $taxation- $v['sum_cost']),2) ;//总利润


            //总绩效＝总利润＊10%
            $v['sum_ratio'] = $v['sum_profit']*($v['achievements_ratio']/100);//总绩效

            //盈利率＝总利润/合同额
            $v['profit_margin'] =  round(($v['sum_profit']/$v['money']),2)*100;
            $v['profit_margin'] = $v['profit_margin'] ?$v['profit_margin']."%":'';
        }
        return array('page' => $show , 'list' => $list);
    
    }
    //首页公司列表
    public  function mainCompany($where){
        $list = $this->where($where)->field('money,cost,id')->select();

        $operate_cost = '';
        $person_cost ='';
        $sum_ratio ='';
        $profit_margin ='';
        $sum_money ='';
        $person_sum_times ='';
        $person_costs ='';
        $person_sum_time='';
        $operate_costs='';
        foreach ($list as $v){
            $sum_money +=$v['money'];
            //人工成本计算
            $uid_list = M('project_member')->where('pid='.$v['id'])->field('eid')->select();

            foreach ($uid_list as $u){
                $wages = M('admin_user')->where('id='.$u['eid'])->getField('wages');//个人工资
                $where['pid'] = $v['id'];
                $where['uid'] = $u['eid'];
                $person_sum_time = M('member_work')->where($where)->sum('work_hours');//个人总录入工时
                // $person_sum_time +=$person_sum_time;
                $person_cost = $person_sum_time*($wages/176);//人工成本=工时*个人工资/(21*8) 21天8小时
            }
            $person_costs +=$person_cost;
            $person_sum_times +=$person_sum_time;

            //运营成本
            $cost = unserialize($v['cost']);

            foreach ($cost as $cv){
                $operate_cost +=$cv;
            }

            $sum_cost =  round(($person_cost+$operate_cost),2);//总成本 =人工成本+运营成本

            //总利润＝项目合同额 — 税费（合同额/（1+税率）*税率＊（1+12.5%））－人工成本 －运营成本
            $taxation_formula = M('config')->where('id=1')->getField('taxation_formula');//税费公式
            $taxation_formula= str_replace('合同额',$v['money'],$taxation_formula);
            $taxation = eval("return $taxation_formula;");
            /*$lee = str_replace('合同额',10000,$config_info);
                       $result=eval("return $lee;");
                       echo $result;*/

            $sum_profit = round(($v['money']- $taxation- $sum_cost),2) ;//总利润


            //总绩效＝总利润＊10%
            $sum_ratio += $sum_profit*0.01;//总绩效

            //盈利率＝总利润/合同额
            $profit_margin +=  round(($sum_ratio/$v['money']),2)*100;


        }

        $r_info['operate_cost'] = $operate_cost;
        $r_info['person_sum_times'] = $person_sum_times;
        $r_info['sum_money'] = $sum_money;
        $r_info['sum_ratio'] = $sum_ratio;
        $r_info['profit_margin'] = $profit_margin."%";
        $r_info['person_cost'] = round( $person_costs,2);
        return $r_info;
    }

    /**
     * @description:首页工时占比
     * @author wuyanwen(2016年12月1日)
     * @param unknown type 1首页获取项目 无条数限制
     * @return multitype:unknown string
     */
    public function hours_ratio($where='')
    {

            $list  = $this->where($where)->select();
            $lee = '';
        foreach ($list as & $v){
            //运营成本
            $cost = unserialize($v['cost']);
            $operate_cost = '';
            foreach ($cost as $cv){
                $operate_cost +=$cv;
            }
            //人工成本计算
            $uid_list = M('project_member')->where('pid='.$v['id'])->field('eid')->select();
            $person_cost ='';
            foreach ($uid_list as $u){
                $wages = M('admin_user')->where('id='.$u['eid'])->getField('wages');//个人工资
                $where['pid'] = $v['id'];
                $where['uid'] = $u['eid'];
                $person_sum_time = M('member_work')->where($where)->sum('work_hours');//个人总录入工时
                // $person_sum_time +=$person_sum_time;
                $person_cost += $person_sum_time*($wages/176);//人工成本=工时*个人工资/(21*8) 21天8小时
            }

            $v['sum_work_hours'] = $person_sum_time; //工时合计
            $v['hours_ratio'] =round( (($person_sum_time/176)*100),2);

            $v['person_cost'] =round( $person_cost,2);//人工成本

            $v['sum_cost'] =  round(($person_cost+$operate_cost),2);//总成本 =人工成本+运营成本

            //总利润＝项目合同额 — 税费（合同额/（1+税率）*税率＊（1+12.5%））－人工成本 －运营成本
            $taxation_formula = M('config')->where('id=1')->getField('taxation_formula');//税费公式
            $taxation_formula= str_replace('合同额',$v['money'],$taxation_formula);
            $taxation = eval("return $taxation_formula;");
            /*$lee = str_replace('合同额',10000,$config_info);
                       $result=eval("return $lee;");
                       echo $result;*/

            $v['sum_profit'] = round(($v['money']- $taxation- $v['sum_cost']),2) ;//总利润



            //盈利率＝总利润/合同额
            $v['profit_margin'] =  round(($v['sum_profit']/$v['money']),2)*100;
            $v['profit_margin'] = $v['profit_margin'] ?$v['profit_margin']:'';


        }
        foreach ($list as $k=>$v){
            $project_name[$k] = $v['project_name'];
            $profit_margin[$k] = $v['profit_margin'];
            $hours_ratio[$k] = $v['hours_ratio'];
        }
        $lee['project_name']=json_encode($project_name);
        $lee['profit_margin']=json_encode($profit_margin);
        $lee['hours_ratio']=json_encode($hours_ratio);

        return  $lee;

    }
    /**
     * @description:添加后台项目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     * @return boolean
     */
    public function addProject($project_info)
    {

          //修改 添加项目
            $company_member = $project_info['checkmember']['company_member'];
            if($project_info['project_id']){

                $pid = $project_info['project_id'];

                if($company_member){
                    M('project_member')->where('pid='.$pid)->delete();
                }

            }else{

                $data['project_name'] = $project_info['project_name'];
                $data['cid'] = $project_info['cid'];
                $data['money'] = $project_info['money'];
                $data['create_time'] = $project_info['create_time'];
                $pid =  $this->add($data);

                if(empty($pid)){
                    $rdata['content']  = "添加失败";
                    $rdata['error'] = true;
                    return $rdata;
                }
            }

            if(!empty($company_member)){

                $member_ratio_value = $project_info['checkmember']['member_ratio_value'];
                $datas['pid'] =   $pid;
                foreach ($company_member as $k=> $v){

                    $datas['eid'] = $v['id'] ;
                    $datas['member_ratio'] =$member_ratio_value[$k] ;

                    $is_success = M('project_member')->add($datas) ? false : true;

                    if($is_success == true) {
                        $content = "添加小组成员失败,请编辑项目添加";
                        break;
                    }else{
                        $content = "添加成功";
                    };
                }
            }else{
                $is_success = false;
                $content = "添加成功";
            }

        $rdata['content']  = $content;
        $rdata['error'] = $is_success;
        return $rdata;


    }
    
    /**
     * @description:更新项目信息
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     */
    public function editProject($data)
    {

       // Array (
        // [cost] => a:2:{s:7:"成本6";s:1:"5";s:7:"成本7";s:1:"7";}
        // [checkmember] => Array ( [company_member] => Array ( [0] => Array ( [id] => 15 [user_name] => admin ) )
        // [member_ratio_value] => Array ( [0] => 8 [1] => ) )
        // [id] => 2
        // [status] => 2 )
        $where = array(
            'id'    => $data['id'],
        );
        $this->where($where)->setField('cost',$data['cost']);
        $company_member = $data['checkmember']['company_member'];
        $member_ratio_value = $data['checkmember']['member_ratio_value'];
       if($company_member){
           foreach ($company_member as $k=> $v){
               $map['pid'] = $data['id'];
               $map['eid'] = $v['id'];
               $datas['eid'] = $v['id'] ;
               $datas['member_ratio'] =$member_ratio_value[$k] ;
               $this_project_member = M('project_member')->where($map)->find();
               if($this_project_member){
                    if($this_project_member['member_ratio'] !=$member_ratio_value[$k]){
                        $is_success = M('project_member')->where($map)->setField('member_ratio',$member_ratio_value[$k])? true : false;
                        if($is_success == false) break;
                    }else{
                        $is_success  = true;
                    }
               }else{
                   $datas['pid'] = $data['id'];
                   $is_success = M('project_member')->add($datas) ? true : false;
                   if($is_success == false) break;
               }
           }
       }

        if($is_success)$this->where($where)->setField('status',$data['status']);

        return $is_success;
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
     * @description:根据id查询项目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $Project_id
     */
    public function findProjectById($Project_id)
    {
        $where = array(
            'id'     => $Project_id
        );
        $project_info = $this->where($where)->find();
        $project_info['company_name'] = M('company')->where('id='.$project_info['cid'])->getField('name');
        $project_info['project_member'] =
            M('project_member')
            ->join('admin_user as a on project_member.eid=a.id')
            ->where('project_member.pid='.$project_info['id'])->field('project_member.*,a.user_name')->select();

//项目个人分账
        $person_cost = '';
        foreach ($project_info['project_member'] as & $v){
            $map['pid'] = $v['pid'];
            $map['uid'] = $v['eid'];
            $wages = M('admin_user')->where('id='.$v['eid'])->getField('wages');//个人工资
            $v['auth_type_name'] = M('admin_auth_group_access')->join('admin_auth_group as b on admin_auth_group_access.group_id = b.id')->where('admin_auth_group_access.uid='.$v['eid'])->getField('b.title');

            $v['work_hours'] = M('member_work')->where($map)->sum('work_hours');
            $person_cost +=  $v['work_hours']*($wages/176);//人工成本=工时*个人工资/(21*8) 21天8小时
            $v['member_ratio_money'] = round($project_info['money']*($project_info['achievements_ratio']/100)*($v['member_ratio']/100),2);
        }

        $project_member = '';
        foreach ($project_info['project_member'] as $value){
            $project_member  .= $value['user_name']."&nbsp;".$value['member_ratio'].'%'."\n";
            //$project_member .=$member;
        }

        $project_info['show_project_member'] = $project_member;
        $project_info['cost_project_member'] = unserialize($project_info['cost']);
        //运营成本
        $cost = unserialize($project_info['cost']);
        $operate_cost = '';
        foreach ($cost as $cv){
            $operate_cost +=$cv;
        }
        //总利润＝项目合同额 — 税费（合同额/（1+税率）*税率＊（1+12.5%））－人工成本 －运营成本
        $taxation_formula = M('config')->where('id=1')->getField('taxation_formula');//税费公式
        $taxation_formula= str_replace('合同额',$project_info['money'],$taxation_formula);
        $taxation = eval("return $taxation_formula;");
        $project_info['taxation'] = round($taxation,2);//税费
        /*$lee = str_replace('合同额',10000,$config_info);
                   $result=eval("return $lee;");
                   echo $result;*/
        $sum_cost =$operate_cost+ $person_cost;
        $project_info['operate_cost']  = $operate_cost; //运营成本
        $project_info['person_cost']  = $person_cost; //人工成本
        $project_info['sum_profit'] = round(($project_info['money']- $taxation- $sum_cost),2) ;//总利润
        //盈利率＝总利润/合同额
        $project_info['profit_margin'] =  round(($project_info['sum_profit']/$project_info['money']),2)*100;
        $project_info['profit_margin'] = $project_info['profit_margin'] ?$project_info['profit_margin']."%":'';


        return $project_info;
    }
    
    public function findProjectByName($Project_name)
    {
        $where = array(
            'project_name' => $Project_name
        );
        
        
        return $this->where($where)->find();
    }

    public function addProjectMember($project_info)
    {
        //Array (
        // [pid] => 1
        // [project_name] => 项目名称
        // [money] => 3 )
        // Array ( [company_member] =>
        // Array ( [0] => Array ( [id] => 17 [user_name] => wuyawnen )
        //          [1] => Array ( [id] => 19 [user_name] => admin2 ) )
        // [member_ratio_value] => Array ( [0] => 2 [1] => 3 [2] => ) )
        $data['pid'] = $project_info['pid'];
        $data['project_name'] = $project_info['project_name'];
        $data['money'] = $project_info['money'];
        $data['create_time'] = $project_info['create_time'];
        $pid =  $this->add($data);
        $company_member = $project_info['checkmember']['company_member'];
        $member_ratio_value = $project_info['checkmember']['member_ratio_value'];
        $datas['pid'] =   $pid;
        foreach ($company_member as $k=> $v){

            $datas['eid'] = $v['id'] ;
            $datas['member_ratio'] =$member_ratio_value[$k] ;

            $is_success = M('project_member')->add($datas) ? true : false;

            if($is_success == false) break;
        }
        session('checkmember',null);
        return $is_success;
    }

}