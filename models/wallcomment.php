<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class wallcomment extends ActiveRecord{
        public static function tableName(){
            return "{{%wallcomment}}";
    }

        public function rules(){
          return[
              ['comment','required','message' => '提交的内容不能为空~'],
              ['comment','string','max' => 600],
         ];
  }

        public function add($data){
             if($data){
			//头像与昵称的输入
			$Url_c = array('0' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment1.jpg",
		                   '1' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment2.jpg",
		                   '2' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment3.jpg",
		                   '3' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment4.jpg",
		                   '4' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment5.jpg",
		                   '5' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment6.jpg",
		                   '6' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment7.jpg",
		                   '7' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment8.jpg",
		                   '8' => "http://olohq71tr.bkt.clouddn.com/unsleep/Conmment9.jpg" );
            $Name = array('0' => "绅士",
            	          '1' => "青年",
            	          '2' => "博士",
            	          '3' => "白领",
            	          '4' => "演员",
            	          '5' => "旅者",
            	          '6' => "导演",
            	          '7' => "小鬼", 
            	          '8' => "神父");
            $r = rand(0,8);
            $Url = $Url_c[$r];
            $Nickname = $Name[$r];
            //创建时间
            date_default_timezone_set('PRC');
            $Createtime = date('Y-m-d H:i:s');
            //输入数据库
            $this->comment = $data['content'];
            $this->view_id = $data['id'];
            $this->nickname = $Nickname;
            $this->createtime = $Createtime;
            $this->url = $Url;
            $result = $this->save();
             if($result){
                   $error = 0;
                   return $error;
              }else{
                   $error = $this->getErrors();
                   return $errorl
              }
          }else{
                    $error = 2;
                    return $error;
              }
          }
 

}
