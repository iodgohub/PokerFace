<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit();

/**
 * <strong style="color:red;">PokerFace，伪造一个后台界面，防止非管理员进入网站后台。</strong>
 * 
 * @package PokerFace
 * @author 壹介凡俗
 * @version 0.11
 * @link https://iodgo.com/archives/PokerFace.html
 */
class PokerFace_Plugin implements Typecho_Plugin_Interface
{

    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('admin/common.php')->begin = array('PokerFace_Plugin', 'hello');
        Typecho_Plugin::factory('Widget_Logout')->logout = array('PokerFace_Plugin', 'hibaby');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @statics
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
        return _t('关闭插件。');
    }

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $pokerface = new Typecho_Widget_Helper_Form_Element_Textarea('pokerface', NULL, "",
			_t('PokerFace伪造后台代码'), _t('这里填入伪造的<strong style="color:red;">HTML代码</strong>，用于游客访问'));
        $form->addInput($pokerface); 
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

    public static function hello()
    {
        Typecho_Widget::widget('Widget_User')->to($user);
        Typecho_Widget::widget('Widget_Options')->to($options);
        if(!$user->pass('editor', true)){
            echo Helper::options()->plugin('PokerFace')->pokerface;
            exit();
        }
    }
    public static function hibaby(){
        $url = Helper::options()->siteUrl;
        Header("Location:$url"); 
        @session_destroy();
        exit();
    }
}
