plugin:jquery.Huploadify.js
version:2.1.2
author:����
blog:www.cnblogs.com/lvdabao
email:lvxiaobao1989@gmail.com
date:2014.02.24
desc/changelog:
1. �����˵�һ�ν��ļ������ϴ����ٴ��ϴ���ͬ�ļ���Ȼ�ᷢ�������bug
2. ѡ�����������ϴ����ļ����ļ���С�����������


ʹ�÷�ʽ��

��������ҳ������Ҫһ��������ͨ����һ��div���磺

<div id="upload"></div>
����Ȼ��ֱ�ӵ��ü��ɣ�

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
            console.log('��ʼ�ϴ�');
            },
        onInit:function(){
            console.log('��ʼ��');
            },
        onUploadComplete:function(){
            console.log('�ϴ����');
            },
        onCancel:function(file){
            console.log(file);
        }
});
