<?php

namespace app\model;

use think\Db;
use think\Model;

class BaseModel extends Model
{
    protected $indexAjaxParams;

    protected $db = false;

    protected $db_config = [];

    public function indexAjax($params)
    {
        $data = [];
        $this->indexAjaxParam($params);
        $action = isset($_REQUEST['action_export']) ? $_REQUEST['action_export'] : '';  //导出
        $alias = $this->indexAjaxParams['alias'];
        $field = $this->indexAjaxParams['field'];
        $join = $this->indexAjaxParams['join'];
        $where = $this->indexAjaxParams['where'];
        $order = $this->indexAjaxParams['order'];
        $page_status = $this->indexAjaxParams['page_status'];
        $select = $this->indexAjaxParams['select'];
        $count = $this->indexAjaxParams['count'];
        $page = $this->indexAjaxParams['page'] ?? 1;
        $limit = $this->indexAjaxParams['limit'] ?? 10;

        if($this->db){
            $model = Db::connect($this->db_config)->table($this->table)->alias($alias)
                ->field($field)
                ->join($join);
        }else{
            $model = Db::table($this->table)->alias($alias)
                ->field($field)
                ->join($join);
        }



        if($where){
             $model->where($where);
        }
        if($order){
            $model->order($order);
        }

        if($count){
            $data[] = $model->count();
        }

        if($page_status &&  $action != 'export'){
            if($select){
                $data[] = $model->page($page,$limit)->select();
            }else{
                $data[] = $model->page($page,$limit)->find();
            }
        }else{
            if($select){
                $data[] = $model->select();
            }else{
                $data[] = $model->find();
            }
        }

        return $data;
    }

    public function indexAjaxParam($params)
    {
        if(isset($params['page'])){
            $this->indexAjaxParams['page'] = $params['page'] ?? 1;
            unset($params['page']);
        }
        if(isset($params['limit'])){
            $this->indexAjaxParams['limit'] = $params['limit'] ?? 10;
            unset($params['limit']);
        }
        $this->indexAjaxParams['where'] = array_merge($this->indexAjaxParams['where'],$params);

    }


}