<?php

namespace app\admin\controller;
use think\Db;

class Api extends Base {
    /*
     * 获取地区
     */
    public function getRegion(){
        $parent_id = I('get.parent_id/d');
        $data = M('region')->where("parent_id", $parent_id)->select();
        $html = '';
        if($data){
            foreach($data as $h){
                $html .= "<option value='{$h['id']}'>{$h['name']}</option>";
            }
        }
        echo $html;
    }

    public function getGoodsSpec(){
        $goods_id = I('get.goods_id/d');
        $temp = DB::name('spec_goods_price')->field("GROUP_CONCAT(`key` SEPARATOR '_' ) as goods_spec_item")->where('goods_id', $goods_id)->select();
        $goods_spec_item = $temp[0]['goods_spec_item'];
        $goods_spec_item = array_unique(explode('_',$goods_spec_item));
        if($goods_spec_item[0] != ''){
            $spec_item = DB::query("SELECT i.*,s.name FROM __PREFIX__spec_item i LEFT JOIN __PREFIX__spec s ON s.id = i.spec_id WHERE i.id IN (".implode(',',$goods_spec_item).") ");
            $new_arr = array();
            foreach($spec_item as $k=>$v){
                $new_arr[$v['name']][] = $v;
            }
            $this->assign('specList',$new_arr);
        }
       return $this->fetch();
    }
    /*
     * 获取商品价格
     */
    public function getSpecPrice(){
        $spec_id = I('post.spec_id/d');
        $goods_id = I('get.goods_id/d');
        if(!is_array($spec_id)){
            exit;
        }
        $item_arr = array_values($spec_id);
        sort($item_arr);
        $key = implode('_',$item_arr);
        $goods = M('spec_goods_price')->where(array('key'=>$key,'goods_id'=>$goods_id))->find();
        $info = array(
            'status' => 1,
            'msg' => 0,
            'data' =>$goods['price'] ? $goods['price'] : 0
        );
        exit(json_encode($info));
    }

    //商品价格计算
    public function calcGoods(){
        $goods_id = I('post.goods/d'); // 添加商品id
        $price_type = I('post.price') ? I('post.price') : 3; // 价钱类型
        $goods_info = M('goods')->where(array('goods_id'=>$goods_id))->find();
        if(!$goods_info['goods_id'] > 0)
            exit; // 不存在商品
        switch($price_type){
            case 1:
                $goods_price = $goods_info['market_price']; //市场价
                break;
            case 2:
                $goods_price = $goods_info['shop_price']; //市场价
                break;
            case 3:
                $goods_price = I('post.goods_price'); //自定义
                break;
        }

        $goods_num = I('post.goods_num/d'); // 商品数量

        $total_price = $goods_price * $goods_num; // 计算商品价格

        $info = array(
            'status'=>1,
            'msg'=>'',
            'data'=>$total_price
        );
        exit(json_encode($info));

    }

}