<?php
namespace Admin\Controller;
use Think\Controller;
class AjaxController  extends  Controller
{
    protected $company_model;
    protected $company_group_model;

    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $company_model = D('Company');
        $this->company_model = $company_model;

    }
    
    /**
     * @description:获取公司小组
     * @author wuyanwen(2016年12月1日)
     */
    public function getGroup()
    {
       I('get.cid','','trim')?$cid= I('get.cid','','trim'):'';
       if($cid) $group_info = $this->company_model->findGroup($cid);
       $data['group_info'] = $group_info?$group_info: '';
        return  $this->ajaxReturn($data);

    }
    /**
     * @description:导出用户表
     * @author wuyanwen(2016年12月1日)
     */
    public  function userExport(){

        I('get.cid')?$where['cid'] =I('get.cid'):'' ;
        I('get.gid')?$where['gid'] =I('get.gid'):'' ;

        $info =  M('admin_user')->where($where)->field('id,user_name,tpassword')->select();

        $title = array('序号','用户名','系统码');
        $name = '员工表';

          echo  $this->exportexcel($info,$title,$name);
          exit;

    }

    public function eximport(){

        $upload = new \Think\Upload();
        $upload->maxSize   =     3145728 ;
        $upload->exts      =     array('xls', 'csv', 'xlsx');
        $upload->rootPath  =      './Public';
        $upload->savePath  =      '/excel/';
        $info   =   $upload->upload();
        if(!$info){

            $this->error($upload->getError());
        }else{
            $filename='./Public/'.$info['excel']['savepath'].$info['excel']['savename'];
            $data=$this->import_excel($filename);

            unset($data[1]);
           foreach ($data as $k=>$v){
                $create_data['user_name'] = $v[0];
                $create_data['password'] = md5($v[1]);
                $create_data['tpassword'] = $v[1];
                $create_data['sex'] = $v[2];
                $create_data['wages'] = $v[3];
                $create_data['mobile'] = $v[4];
                $create_data['create_time'] = date('Y-m-d',time());
                M('admin_user')->add($create_data);

           }
            $this->success('导入成功','/User/index');
        }
        /*// 导入xls格式的数据
        $data=$this->import_excel('./Public/111.xls');
       print_r($data);die;*/
    }
    function import_excel($file){
        // 判断文件是什么格式
        $type = pathinfo($file);
        $type = strtolower($type["extension"]);
        $type=$type==='csv' ? $type : 'Excel5';
        ini_set('max_execution_time', '0');
        Vendor('PHPExcel.PHPExcel');
        // 判断使用哪种格式
        $objReader = \PHPExcel_IOFactory::createReader($type);
        $objPHPExcel = $objReader->load($file);
        $sheet = $objPHPExcel->getSheet(0);
        // 取得总行数
        $highestRow = $sheet->getHighestRow();
        // 取得总列数
        $highestColumn = $sheet->getHighestColumn();
        //循环读取excel文件,读取一条,插入一条
        $data=array();
        //从第一行开始读取数据
        for($j=1;$j<=$highestRow;$j++){
            //从A列读取数据
            for($k='A';$k<=$highestColumn;$k++){
                // 读取单元格
                $data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
            }
        }
        return $data;
    }
    /**
     * 导出订单函数  保存为excle表格
     *
     */
    function exportexcel($data=array(),$title=array(),$filename='report'){
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Transfer-Encoding:binary");
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);

            }
            echo implode("\n",$data);
        }
    }
}