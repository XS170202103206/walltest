<?php

namespace app\controllers;
use yii\web\Controller;
use Yii;
use app\models\wallcontent;

class WallContentController extends Controller{
    public $enableCsrfValidation = false;
    //信息发布
    public function actionGet(){
         $model =new wallcontent();
         if(Yii::$app->request->isPost){
                $postData = Yii::$app->request->bodyParams;
                $first = $_POST['first'];
                $last = $_POST['last'];
                $len = $last - $first;
                $sql = "select * from catch_wallcontent where state = 1 order by content_id desc limit $first,$len";
                $data = wallcontent::findBysql($sql)->asArray()->all();
                echo json_encode(array('error' => 0,'message' =>'success','data'=>$data,));
           }
    }


//信息接收&数据库输入
      public function actionPublish(){
            $model =new wallcontent();
            if(Yii::$app->request->isPost ){
                 $postData = Yii::$app->request->post();
                 $result = $model->add($postData);
                 if($result == 0){
                       $data = array('content' => '提交数据成功');
              echo json_encode(array('error'=> 0,'message'=> 'success','data' =>$data));
             }else{
                 $data = array('Content' => '提交数据失败,请@留言,联系公众号~','content'=>$result);
             echo json_encode(array('error' => 1, 'message' =>fail, 'data' => $data));
        }
     }
  }
      public function actionLike(){
           $model = new content();
           if(Yii::$app->request->isPost ){
            $postData = Yii::$app->request->post();
            $content_id = $postData['id'];
            $likecount = $postData['dzSum'];
            $c_arr = $model->find()->select('*')->where('state = :state',[":state"=>'1'])->andwhere('content_id = :content_id;,[":content_id"=>$content_id])->asArray()->all();
            if(empty($c_arr)){
                $data = array('content' =>'点赞成功');
               echo json_encode(array('error' => -1, 'message' => fail, 'data' => $data));
}else {
                  $modcontent = array('likecount'=>$likecount);
                  $model->mod($content_id,$modcontent);
                  $data = array('content'=>'点赞成功','count_p'=> $likecount);
           echo json_encode(array('error' => 0, 'message' => 'success', 'data' => $data));
            }
        }
    } 



public function actionRedischeck($IP){
		$redis = Yii::$app->redis->get($IP);//获取键为$IP的值
        	if($redis){
        		$difftime  = time() - $redis;//对比时间差
        		if( $difftime > 7200 ){
        			Yii::$app->redis->set($IP, time());//更新$IP键值
        			$tip = 0;
        			return $tip;
        		}else{
        			$tip = -1;
        			return $tip;
        		} 
        	}else{
        		Yii::$app->redis->set($IP, time());//设置$IP键值
        		$tip = 1;
        		return $tip;
        	}
	}


}       


