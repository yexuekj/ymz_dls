<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [

    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,

    // 默认模块名
    'default_module'         => 'admin',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Login',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,

    // 视图输出字符串内容替换
    'view_replace_str'       => [],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => Env::get('think_path') . 'tpl/dispatch_jump.tpl',
    'dispatch_error_tmpl'    => Env::get('think_path') . 'tpl/dispatch_jump.tpl',

    // 异常页面的模板文件
    'exception_tmpl'         => Env::get('think_path') . 'tpl/think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'         => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '\\app\\common\\exception\\BaseException',

    // mongo
//    "mongo_db"              => [
//        // 数据库类型
//        'type'           => '\think\mongo\Connection',
//        // 设置查询类
//        'query'			 => '\think\mongo\Query',
//        // 服务器地址
//        'hostname'       => '47.104.182.146',
//        // 集合名
//        'database'       => 'wechat',
//        // 用户名
//        'username'       => '',
//        // 密码
//        'password'       => '',
//        // 端口
//        'hostport'       => '27017',
//
//        'pk_convert_id'  => true,
//
//        'pk'             => 'id'
//    ],

    'host_name' => 'http://finc.dadoyi.com',

    // MIME
    'mime_type'             => [
        [".3gp" , "video/3gpp"],
        [".apk" , "application/vnd.android.package-archive"],
        [".asf" , "video/x-ms-asf"],
        [".avi" , "video/x-msvideo"],
        [".bin" , "application/octet-stream"],
        [".bmp" , "image/bmp"],
        [".c", "text/plain"],
        [".class" , "application/octet-stream"],
        [".conf" , "text/plain"],
        [".cpp" , "text/plain"],
        [".doc" , "application/msword"],
        [".docx" , "application/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        [".xls" , "application/vnd.ms-excel"],
        [".xlsx" , "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"],
        [".exe" , "application/octet-stream"],
        [".gif" , "image/gif"],
        [".gtar" , "application/x-gtar"],
        [".gz", "application/x-gzip"],
        [".h" , "text/plain"],
        [".htm" , "text/html"],
        [".html" , "text/html"],
        [".jar" , "application/java-archive"],
        [".java" , "text/plain"],
        [".jpeg" , "image/jpeg"],
        [".jpg" , "image/jpeg"],
        [".js" , "application/x-javascript"],
        [".log" , "text/plain"],
        [".m3u" , "audio/x-mpegurl"],
        [".m4a" , "audio/mp4a-latm"],
        [".m4b" , "audio/mp4a-latm"],
        [".m4p" , "audio/mp4a-latm"],
        [".m4u" , "video/vnd.mpegurl"],
        [".m4v" , "video/x-m4v"],
        [".mov" , "video/quicktime"],
        [".mp2" , "audio/x-mpeg"],
        [".mp3" , "audio/x-mpeg"],
        [".mp4" , "video/mp4"],
        [".mpc" , "application/vnd.mpohun.certificate"],
        [".mpe" , "video/mpeg"],
        [".mpeg" , "video/mpeg"],
        [".mpg"  , "video/mpeg"],
        [".mpg4" , "video/mp4"],
        [".mpga" , "audio/mpeg"],
        [".msg" , "application/vnd.ms-outlook"],
        [".ogg" , "audio/ogg"],
        [".pdf" , "application/pdf"],
        [".png" , "image/png"],
        [".pps" , "application/vnd.ms-powerpoint"],
        [".ppt" , "application/vnd.ms-powerpoint"],
        [".pptx" , "application/vnd.openxmlformats-officedocument.presentationml.presentation"],
        [".prop" , "text/plain"],
        [".rc" , "text/plain"],
        [".rmvb" , "audio/x-pn-realaudio"],
        [".rtf" , "application/rtf"],
        [".sh" , "text/plain"],
        [".tar" , "application/x-tar"],
        [".tgz" , "application/x-compressed"],
        [".txt" , "text/plain"],
        [".wav" , "audio/x-wav"],
        [".wma" , "audio/x-ms-wma"],
        [".wmv" , "audio/x-ms-wmv"],
        [".wps" , "application/vnd.ms-works"],
        [".xml" , "text/plain"],
        [".z" , "application/x-compress"],
        [".zip", "application/x-zip-compressed"],
        [".zip", "application/zip"],
    ],

    'data_base_1' => [
        'type'            => 'mysql',
        // 服务器地址
        'hostname'        => '47.116.73.115',
        // 数据库名
        'database'        => 'supplier',
        // 用户名
        'username'        => 'supplier',
        // 密码
        'password'        => 'j8PCpfT6MfkjcciR',
        // 端口
        'hostport'        => '3306',
    ],
    'data_base_2' => [
        'type'            => 'mysql',
        // 服务器地址
        'hostname'        => '47.116.73.115',
        // 数据库名
        'database'        => 'supplier',
        // 用户名
        'username'        => 'supplier',
        // 密码
        'password'        => 'j8PCpfT6MfkjcciR',
        // 端口
        'hostport'        => '3306',
    ],

    // 主控制站 域名获取
    'data_base_3' => [
        'type'            => 'mysql',
        // 服务器地址
        'hostname'        => '47.103.152.142',
        // 数据库名
        'database'        => 'master_control',
        // 用户名
        'username'        => 'master_control',
        // 密码
        'password'        => 'ymz@2020',
        // 端口
        'hostport'        => '3306',
    ],
];
