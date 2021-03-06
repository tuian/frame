<?php
/**
 * 单页系统
 * @author zhang qing <490702087@qq.com>
 * @since  2016/9/18 0018 下午 14:42
 */

namespace app\admin\controller;

class PageController extends CommonController{

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb[]=array(
            'text'  =>'单页系统'
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
        $this->assign('classid', I('classid'));
        $this->display();
    }

    /**
     * 文章管理-列表
     * @author zhang qing <490702087@qq.com>
     */
    public function pagelist(){
        if (IS_POST) {
            $ret=$this->ctx->PageManager->getList();
            $this->ajaxReturn($ret);
        }else{
            $this->assign('is_pass', I('get.is_pass'));
            $this->assign('classid', I('get.classid/d'));

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
        $this->assign('upload_image_accept', 'image/'.str_replace('|', ', image/', C('UPLOAD_IMAGE_EXT')));
        $this->assign('upload_image_ext', '"'.str_replace('|', '","', C('UPLOAD_IMAGE_EXT')).'"');
        $this->assign('upload_image_maxsize', C('UPLOAD_IMAGE_MAXSIZE'));

        $map=$this->ctx->PageModel->findByShow(I('id'));
        if ($map['pic']) {
            $map['pic']=$this->ctx->UploadModel->getPicRecord($map['pic']);
        }
        $this->assign('map', $map);

        $this->display();
    }

    /**
     * 文章-保存
     * @author zhang qing <490702087@qq.com>
     */
    public function save(){
        $ret=$this->ctx->PageManager->save();
        $this->ajaxReturn($ret);
    }

    /**
     * 文章管理-设置是否显示
     * @author zhang qing <490702087@qq.com>
     */
    public function setPass(){
        $ret=$this->ctx->PageManager->setPass();
        $this->ajaxReturn($ret);
    }

    public function setRecommend(){
        $ret=$this->ctx->PageManager->setRecommend();
        $this->ajaxReturn($ret);
    }
	
	/**
     * 单页直显
     * @author zhang.qing <zhang.qing@immomo.com>
     */
    public function single(){
        $this->assign('upload_image_accept', 'image/'.str_replace('|', ', image/', C('UPLOAD_IMAGE_EXT')));
        $this->assign('upload_image_ext', '"'.str_replace('|', '","', C('UPLOAD_IMAGE_EXT')).'"');
        $this->assign('upload_image_maxsize', C('UPLOAD_IMAGE_MAXSIZE'));
        $this->breadcrumb[]=array(
            'text'  =>'产品简介'
        );
        $this->assign('breadcrumb', $this->breadcrumb);

        $map=$this->ctx->PageModel->findByShow(I('id'));
        if ($map['pic']) {
            $map['pic']=$this->ctx->UploadModel->getPicRecord($map['pic']);
        }
        $this->assign('map', $map);

        $this->display();
    }

    /**
     * 文章管理-删除记录
     * @author zhang qing <490702087@qq.com>
     */
    public function remove(){
        $ret=$this->ctx->PageManager->remove();
        $this->ajaxReturn($ret);
    }
}