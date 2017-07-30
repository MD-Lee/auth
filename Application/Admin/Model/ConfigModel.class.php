<?php
namespace Admin\Model;

class  ConfigModel extends BaseModel
{
    protected $tableName = 'config';
    
    /**
     * @description:查询设置
     * @author wuyanwen(2016年11月22日)
     */
    public function findConfig()
    {
        $where = array(
            'id' => 1,

        );
        
        $result = $this->where($where)->getField('taxation_formula');
        
        return $result;
    }
    /**
     * @description:更新设置信息
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     */
    public function editConfig($data)
    {
        $where = array(
            'id'    => 1,
        );

        unset($data['id']);
        
        return $this->where($where)->save($data);
    }

}