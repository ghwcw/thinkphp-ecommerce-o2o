plugin:jquery.Huploadify.js
version:2.1.2
author:吕大豹
blog:www.cnblogs.com/lvdabao
email:lvxiaobao1989@gmail.com
date:2014.02.24
desc/changelog:
1. 修正了第一次将文件完整上传后，再次上传相同文件仍然会发送请求的bug
2. 选择了已完整上传的文件后，文件大小计算的误差矫正


使用方式：

　　首先页面上需要一个容器，通常是一个div，如：

<div id="upload"></div>
　　然后直接调用即可：

$('#upload').Huploadify({
        auto:true,
        fileTypeExts:'*.jpg;*.png;*.jpeg',
        multi:true,
        formData:{key:123456,key2:'vvvv'},
        fileSizeLimit:1024,
        showUploadedPercent:true,
        showUploadedSize:true,
        removeTimeout:9999999,
        uploader:'upload.php',
        onUploadStart:function(){
            console.log('开始上传');
            },
        onInit:function(){
            console.log('初始化');
            },
        onUploadComplete:function(){
            console.log('上传完成');
            },
        onCancel:function(file){
            console.log(file);
        }
});
