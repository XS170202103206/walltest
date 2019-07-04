<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class wallcontent extends ActiveRecord{
      public static function tableName(){
               return "{{%wallcontent}";
     }

      public  function rules(){
           return[
               ['content','required','message'=>'提交的内容不能为空~'],
               ['content','string','max' => 600],
       ];
    }

       public function add($data){
           if($data){
                //处理性别数据
                $checksex = $data['formSex'];
                if($checksex == "man"){
                         $sex = 2;
                 }else{
                     $sex = 1;
                 }
                //头像
                $Url_B = array("0" =>"https://image.myzhbit.cn/%E8%A1%A8%E7%99%BD%E5%A2%99/URL1.jpg");
                $Url_G = array("0" => "https://image.myzhbit.cn/%E8%A1%A8%E7%99%BD%E5%A2%99/URL2.jpg");
                $Url_r = 0;
                if($sex == 2) {
                      $url = $Url_B[$Url_r];
                 }else{ 
                      $url = $Url_G[$Url_r];
                }
                //创建时间
                date_default_timezone_set('PRC');
                $Createtime=date('Y-m-d H:i:s');
                //输入数据库
                $this->content = $data['formContent'];
                $this->nickname = $data['formName'];
                $this->sex = $sex;
                $this->createtime = $Createtime;
                $this->url = $url;
                $this->likecount = 0;
                $result = $this->save();
                if($result){
                      $error = 0;
                      return $error;
                  }else{
                      $error = $this->getErrors();
                      return $error;
                 }else{
                      $error = 2;
                      return $error;
                  }
            }

        public function mod($id,$include){
               //评论数增加
               $condition = [
                      'content_id' => $id,
               ];
           $keys = array_keys($include);
               if($keys[0] == 'comment'){
                    $data = [
                       'count_p' => $include['comment']
                   ];
                }else if($keys[0] == 'likecount'){
                     $data = [
                       'likecount' => $include['likecount']
                     ];
               }
               $result = self::updateAll($data,$condition);
               return $result;
            }
  
     }

               
