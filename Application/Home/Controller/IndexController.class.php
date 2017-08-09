<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $is_mobile = isMobile();

        $is_mobile?$this->redirect('/Mobile/index'):$this->redirect('/Admin/index');
    }
}