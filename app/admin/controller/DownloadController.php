<?php
/**
 * 下载中心
 * @author zhang qing <490702087@qq.com>
 * @since  2016/9/18 0018 下午 14:42
 */

namespace app\admin\controller;

class DownloadController extends CommonController{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb[]=array(
            'text'  =>'下载中心'
        );

    }

    /**
     * 文章管理-首页
     * @author zhang qing <490702087@qq.com>
     */
    public function index(){
        $this->breadcrumb[]=array(
            'text'  =>'信息管理'
        );
        $this->assign('breadcrumb', $this->breadcrumb);
        $this->display();
    }

    /**
     * 文章管理-列表
     * @author zhang qing <490702087@qq.com>
     */
    public function pagelist(){
        if (IS_POST) {
            $ret=$this->ctx->DownloadManager->getList();
            $this->ajaxReturn($ret);
        }else{
            $ret=$this->ctx->DownloadCategoryManager->getCategory();
            $this->assign('categorys', $ret);

            $this->assign('is_pass', I('get.is_pass'));

            // 每个操作key不要随便修改，并且不同操作的key不要一样，前台有根据判断
            if (I('get.is_pass')) {
                $action_list=array(
                    0=>'操作', 1=>'推荐', 2=>'取消推荐', 3=>'加入回收站'
                );
            }else{
                $action_list=array(
                    0=>'操作', 1=>'推荐', 2=>'取消推荐', 4=>'彻底删除', 5=>'从回收站还原'
                );
            }
            $this->assign('action_list', $action_list);

            $this->display();
        }
    }

    /**
     * 栏目管理-添加/修改
     * @author zhang qing <490702087@qq.com>
     */
    public function show(){
        $this->assign('upload_file_accept', ''.str_replace('|', ', ', C('UPLOAD_FILE_EXT')));
        $this->assign('upload_file_ext', '"'.str_replace('|', '","', C('UPLOAD_FILE_EXT')).'"');
        $this->assign('upload_file_maxsize', C('UPLOAD_FILE_MAXSIZE'));

        $map=$this->ctx->DownloadModel->findByShow(I('id'));
        if ($map['file']) {
            $map['file']=$this->ctx->UploadModel->getFileRecord($map['file']);
        }
        $this->assign('map', $map);

        $ret=$this->ctx->DownloadCategoryManager->getCategory();
        $this->assign('categorys', $ret);

        $this->display();
    }

    /**
     * 文章-保存
     * @author zhang qing <490702087@qq.com>
     */
    public function save(){
        $ret=$this->ctx->DownloadManager->save();
        $this->ajaxReturn($ret);
    }

    /**
     * 文章管理-设置是否显示
     * @author zhang qing <490702087@qq.com>
     */
    public function setPass(){
        $ret=$this->ctx->DownloadManager->setPass();
        $this->ajaxReturn($ret);
    }

    public function setRecommend(){
        $ret=$this->ctx->DownloadManager->setRecommend();
        $this->ajaxReturn($ret);
    }

    /**
     * 文章管理-删除记录
     * @author zhang qing <490702087@qq.com>
     */
    public function remove(){
        $ret=$this->ctx->DownloadManager->remove();
        $this->ajaxReturn($ret);
    }
}