<?php
namespace Admin\Controller;

class ConfigController extends CommonController
{
    protected $config_model;

    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $config_model = D('Config');

        $this->config_model = $config_model;
    }


    /**
     * @description:编辑添加设置
     * @author lee(2017年7月27日)
     */
    public function index()
    {
        if(IS_POST){
            $config_info = array(
                'taxation_formula'    => I('post.info'),
            );

            if($this->config_model->editConfig($config_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $config_info = $this->config_model->findConfig();

            /*$lee = str_replace('合同额',10000,$config_info);
            $result=eval("return $lee;");
            echo $result;*/

            $this->assign('config_info',$config_info);
            $this->display();
        }
    }



}