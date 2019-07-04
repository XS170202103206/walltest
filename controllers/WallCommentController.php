<?php

namespace app\controllers;
use yii\web\Controller;
use Yii;
use app\models\wallcomment;
use app\models\wallcontent;

class WallCommentController extends Controller{
    public $enableCsrfValidation = false;
    //信息发布
    public function actionGet(){
          $model = new wallcomment();
          $content = new wallcontent();
          if(Yii::$app->request->isPost){
                 $postData = Yii::$app->request->bodyParams;
                 $content_id = $postData['id'];
     //获取内容
     $c_arr = $content->find()->select('*')->where('state = :state',[":state"=>'1'])->andwhere('content_id = :content_id',[":content_id"=>$content_id])->asArray()->all();
          if(!empty($c_arr)){
              //获取评论
           $p_arr = $model->find()->select('*')->where('state = :state',[":state"=>'1'])->andwhere('view_id = :content_id',[":content_id"=>$content_id])->asArray()->all();
          $p_num = $model->find()->select('count(*)')->where('state =:state',[":state"=>'1'])->andwhere('view_id =:content_id',[":view_id=:content_id',[":content_id"=>$content_id])->asArray()->all();
          $p_num = (int)$p_num[0]['count(*)'];
          if($p_num == 0){
               $data = array('content' => $c_arr,'count_p' => $p_num);
               echo json_encode(array('error'=> 0,'message'=>'success','data'=>$data));
         }else{
               $modcontent = array('comment'=>$p_num);
               $content->mod($content_id,$modcontent);
               $data = array('content'=>$c_arr,'comment'=> $p_arr,'count_p'=>$p_num);
               echo json_encode(array('error'=>0,'message'=>'success','data'=> $data));
             }
         }else{
               $data = array('content' => '没有这段内容');
               echo json_encode(array('error'=> 1,'message' => 'fail','data' => $data));
         }
      }
  }


    //信息接收&数据库输入
     public function actionPublish(){
            $model = new wallcomment();
            $content = new wallcontent();
            if(Yii::$app->request->isPost ){
            //输入数据
                 $postData = Yii::$app->request->post();
                 $content_id = $postData['id'];
                 $checkcontent = $content->find()->select('*')->where('state = :state',[":state"=>'1'])->andwhere('content_id = :content_id',[":content_id"=>$content_id])->asArray()->all();
                 if(!empty($checkcontent)){
                     $result = $model->add($postData);
                     if( $result == 0){
                          $data = array('content' => '提交数据成功');
                          echo json_encode(array('error' => 0,'message' => 'success','data'=>$data));
                  }else{
                       $data = array('Content' => '提交数据失败,请@留言,联系公众号~','content'=> $result);
                    echo json_encode(array('error' => 1, 'message' =>fail,'data'=>$data));
            }
        }else{
           $data = array('content' => '错误的ContentID');
           echo json_encode(array('error' => -1,'message'=> fail,'data' => $data));
      }
    }
  }

                    


