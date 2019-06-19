<?php
/**
 *
 * @author: xaboy<365615158@qq.com>
 * @day: 2017/11/13
 */

namespace app\admin\model\system;

use traits\ModelTrait;
use basic\ModelBasic;

/**
 * 数据列表 model
 * Class SystemGroupData
 * @package app\admin\model\system
 */
class SystemGroupData extends ModelBasic
{
    use ModelTrait;

    /**
     * 根据where条件获取当前表中的前20条数据
     * @param $params
     * @return array
     */
    public static function getList($params){
        $model = new self;
        if($params['gid'] !== '') $model = $model->where('gid',$params['gid']);
        if($params['status'] !== '') $model = $model->where('status',$params['status']);
        $model = $model->order('sort desc,id ASC');
        return self::page($model,function($item,$key){
            $info = json_decode($item->value,true);
            foreach ($info as $index => $value) {
                if($value["type"] == "checkbox")$info[$index]["value"] = implode(",",$value["value"]);
                if($value["type"] == "upload" || $value["type"] == "uploads"){
                    $html_img = '';
                    if(is_array($value["value"])){
                        foreach ($value["value"] as $img) {
                            $html_img .= '<img class="image" data-image="'.$img.'" width="45" height="45" src="'.$img.'" /><br>';
                        }
                    }else{
                        $html_img = '<img class="image" data-image="'.$value["value"].'" width="45" height="45" src="'.$value["value"].'" />';
                    }
                    $info[$index]["value"] = $html_img;
                }
            }
            $item->value = $info;
        });
    }

    /**获得组合数据信息+组合数据列表
     * @param $config_name
     * @param int $limit
     * @return array|bool|false|\PDOStatement|string|\think\Model
     */
    public static function getGroupData($config_name,$limit = 0)
    {
        $group = SystemGroup::where('config_name',$config_name)->field('name,info,config_name')->find();
        if(!$group) return false;
        $group['data'] = self::getAllValue($config_name,$limit);
        return $group;
    }

    /**
     * 获取单个值
     * @param $config_name
     * @param int $limit
     * @return mixed
     */
    public static function getAllValue($config_name,$limit = 0){
        $model = new self;
        $model->alias('a')->field('a.*,b.config_name')->join('system_group b','a.gid = b.id')->where(array("b.config_name"=>$config_name,"a.status"=>1))->order('sort desc,id ASC');
        if($limit > 0) $model->limit($limit);
        $data = [];
        $result = $model->select();
        if(!$result) return $data;
        $result = $result->toArray();
        foreach ($result as $key => $value) {
            $data[$key]["id"] = $value["id"];
            $fields = json_decode($value["value"],true);
            foreach ($fields as $index => $field) {
                if($field['type'] === 'radio') {
                    $data[$key][$index] = self::getGroupRadioValue($value['gid'],$field["value"]);
                }else $data[$key][$index] = $field["value"];
            }
        }
        return $data;
    }

    public static function tidyList($result)
    {
        $data = [];
        if(!$result) return $data;
        foreach ($result as $key => $value) {
            $data[$key]["id"] = $value["id"];
            $fields = json_decode($value["value"],true);
            foreach ($fields as $index => $field) {
                $data[$key][$index] = $field['type'] == 'upload' ? (isset($field["value"][0]) ? $field["value"][0]: ''):$field["value"];
            }
        }
        return $data;
    }


    /**
     * 根据id获取当前记录中的数据
     * @param $id
     * @return mixed
     */
    public static function getDateValue($id){
        $value = self::alias('a')->where(array("id"=>$id))->find();
        $data["id"] = $value["id"];
        $fields = json_decode($value["value"],true);
        foreach ($fields as $index => $field) {
            if($field['type'] === 'radio') {
                $data[$index] = self::getGroupRadioValue($value['gid'],$field["value"]);
            }else $data[$index] = $field["value"];
        }
        return $data;
    }

    /**
     * TODO radio 根据值获取参数
     * @param $id
     * @param $value
     * @return mixed
     */
    public static function getGroupRadioValue($id,$value){
        $groupData = SystemGroup::getField($id);
        foreach ($groupData['fields'] as $key=>&$item){
           if($item['type'] == 'radio'){
               $params = explode("\n",$item["param"]);
               if(is_array($params) && !empty($params)){
                   foreach ($params as $index => &$v) {
                       $vl = explode('=>',$v);
                       if(isset($vl[0]) && isset($vl[1]) && count($vl) && $vl[1] === $value) return $vl[0];
                   }
               }
           }
        }
        return $value;
    }

    /*
     * 获取app首页banner图
     */
    public function GetBanerList($params)
    {
        $data = [];
       // $res = SystemGroupData::all(['gid'=>$params['gid'],'status'=>$params['status']]);
        $res = self::where(['gid'=>$params['gid'],'status'=>$params['status']])
            ->order('sort', 'asc')
           // ->field(['id','cate_name'])
            ->select();

        if (!empty($res)){
            foreach ($res as $value){
                $res = json_decode($value['value'],true);
                $data[] = [
                        'url' => $res['url']['value'],
                       'img' => $res['pic']['value'],
                ];
            }
        }
        return $data;
    }



    public function HotSearch()
    {
        $gid = 62;
        $res = self::where(['gid'=>$gid,'status'=>1])
            ->order('sort', 'desc')
            ->select();
        if (!empty($res)){
            foreach ($res as $value){
                $res = json_decode($value['value'],true);
                $data = [
                    'name' => $res['name']['value'],
                ];
            }
        }

        return $data;
    }



}