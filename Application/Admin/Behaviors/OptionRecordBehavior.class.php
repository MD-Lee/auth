<?php
namespace Admin\Behaviors;

use Admin\Model\AdminMenuModel;

class OptionRecordBehavior extends \Think\Behavior{

    public function run(&$param){
         if(MODULE_NAME =='Admin'){
            $name = CONTROLLER_NAME . '/' . ACTION_NAME;

            /* @var $admin_menu_model \Admin\Model\AdminMenuModel */
            $admin_menu_model = D('AdminMenu');

            $opt_name = $admin_menu_model->selectMenuInfoByName($name);
            $opt_name = $opt_name['title'];
            $user_info = session('user_info');
            $option_info = array(
                'opt_name' => $opt_name,
                'opt_user' => $user_info['user_name'],
                'opt_time' => time(),
            );
        }


    }
}