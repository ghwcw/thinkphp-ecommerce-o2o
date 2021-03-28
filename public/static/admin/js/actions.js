/*页面 全屏-添加*/
function o2o_edit(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}


/*添加或者编辑 缩小的屏幕*/
function o2o_s_edit(title,url,w,h){
    layer_show(title,url,w,h);
}


/*删除*/
function o2o_del(url){
    layer.confirm('确认要删除吗？',function(index){
        // alert(url);
        location.assign(url);
    });
}


//解决h-ui日期插件标签与tp冲突的问题
function selecttime(flag){
    if(flag==1){
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }else{
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:startTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }
}

// 排序
$('input[class=listorder]').blur(function () {
    let id = $(this).attr('attr-id');   // 获取input数据id
    let listorder = $(this).val();      // 获取用户输入的排序号
    let postData = {
        'id': id,
        'listorder':listorder
    };
    let postUrl = SCOPE.listorder_url;  // 获取需要推送的url地址
    // jQuery ajax推送数据
    $.ajaxSetup({async: true});
    $.post(postUrl, postData, function (result) {
        if (result.code===1){
            location.href=result.data;
        }else {
            alert(result.msg);
        }
    }, 'json');

});


/**
 * 获取省所属城市
 */
$('.select.cityId').click(function () {
    let provId = $(this).val();
    let url = SCOPE.get_city_url;
    $.get(url, {'provId':provId}, function (result) {
        // console.log(result);
        if(!result){ return; }
        let data = result.data;
        if(data.length>0){
            //动态添加城市option元素
            let html_str = '<option value="-1">--请选择--</option>';
            $.each(data, function (index, value) {
                html_str += '<option value="'+value.id+'">'+value.name+'</option>';
            });
            // console.log(html);
            $('.select.se_city_id').html(html_str);
        }else {
            // $('.select.se_city_id').empty();
            $('.select.se_city_id').html('<option value="-1">--请选择--</option>');
        }

    });
    if($(this).val()==='-1'){
        $('.select.se_city_id option:first').attr('selected',true);
    }
});


/**
 * 获取服务子分类
 */
$('.select.categoryId').click(function () {
    let cateId = $(this).val();
    let url = SCOPE.get_cate_url;
    $.get(url, {'parent_id':cateId}, function (result) {
        // console.log(result);
        if(!result){ return; }
        let data = result.data.data;
        if(data.length>0){
            //动态添加子分类input元素
            let html_str = '';
            $.each(data, function (index, value) {
                // console.log(value);
                html_str += "<label for='sub-cate"+index+"'>";
                html_str += "<input type='checkbox' id='sub-cate"+index+"' name='sub-cate[]' value='"+value.id+"' class='checkbox'>"+value.name+"</label>&nbsp;&nbsp;&nbsp;";
            });
            $('.check-box.se_category_id').html(html_str);

        }else {
            $('.check-box.se_category_id').empty();
        }

    });
    if($(this).val()=='-1'){
        $('.check-box.se_category_id').empty();
    }
});

/**
 * 上传图片
 */
$('#file_upload').Huploadify({
    auto:false,
    fileTypeExts:'*.jpg;*.png;*.jpeg',
    multi:true,
    // formData:{},
    fileSizeLimit:1024,
    showUploadedSize:true,
    uploader:SCOPE.image_uplaod,    //处理上传方法
    onUploadStart:function(){
        // console.log('开始上传');
    },
    onUploadSuccess:function(file, data){
        console.log('上传成功');
        // console.log(file);
        let jsonData = JSON.parse(data);
        let filePath = (jsonData.data).replace(/\\/g, '/');
        console.log(filePath);
        $('#upload_org_code_img').attr('src', SCOPE.public_path+filePath).show();
        $('#file_upload_image').attr('value', filePath);
    },
    onUploadError:function(file){
        // console.log('上传失败');
        // console.log(file);
    },
    onCancel:function(file){
        // console.log('取消上传');
        // console.log(file);
    }
});

/**
 * 上传图片
 */
$('#file_upload_other').Huploadify({
    auto:false,
    fileTypeExts:'*.jpg;*.png;*.jpeg',
    multi:true,
    // formData:{},
    fileSizeLimit:1024,
    showUploadedSize:true,
    uploader:SCOPE.image_uplaod,    //处理上传方法
    onUploadStart:function(){
        // console.log('开始上传');
    },
    onUploadSuccess:function(file, data){
        console.log('上传成功');
        // console.log(file);
        let jsonData = JSON.parse(data);
        let filePath = (jsonData.data).replace(/\\/g, '/');
        console.log(filePath);
        $('#upload_org_code_img_other').attr('src', SCOPE.public_path+filePath).show();
        $('#file_upload_image_other').attr('value', filePath);
    },
    onUploadError:function(file){
        // console.log('上传失败');
        // console.log(file);
    },
    onCancel:function(file){
        // console.log('取消上传');
        // console.log(file);
    }
});


//门店申请
function saveBusiLoc() {
    let postData = $('#form-article-add').serializeArray();     //form序列化
    let flag=true;
    $.each(postData, function (index, obj) {
        if(obj.name==='name'){
            let name=obj.value;
            if(!name){
                layer.alert('分店名称不能为空');
                flag=false;
            }
        }
    });
    if (flag===false) return;

    let postUrl = SCOPE.save_busiloc_url;       //后台方法地址
    $.post(postUrl, postData, function (result) {
        if(result.code===1){
            layer.alert(result.msg, {yes: function () {
                location.reload();
            }});
        }else{
            layer.alert(result.code+': '+result.msg);
        }

    });

}

//团购商品申请
function saveGrobuy() {
    let postData = $('#form-grobuy-add').serializeArray();     //form序列化
    let flag=true;
    $.each(postData, function (index, obj) {
        if(obj.name==='name'){
            let name=obj.value;
            if(!name.toString().trim()){
                layer.alert('团购商品名称不能为空');
                flag=false;
            }
        }
        if(obj.name==='category_id'){
            let category_id=obj.value;
            if(category_id<1){
                layer.alert('请选所属分类');
                flag=false;
            }
        }
    });
    if (flag===false) return;

    let postUrl = SCOPE.save_grobuy_url;       //后台方法地址
    $.post(postUrl, postData, function (result) {
        if(result.code===1){
            layer.alert(result.msg, {yes: function () {
                    location.reload();
                }});
        }else{
            layer.alert(result.code+': '+result.msg);
        }

    });

}


//推荐位添加
function saveRecom() {
    let postData = $('#form-recom-add').serializeArray();     //form序列化
    let flag=true;
    $.each(postData, function (index, obj) {
        if(obj.name==='title'){
            let title=obj.value;
            if(!title.toString().trim()){
                layer.alert('推荐位标题不能为空');
                flag=false;
            }
        }
        if(obj.name==='type'){
            let type=obj.value;
            if(type<1){
                layer.alert('请选所属分类');
                flag=false;
            }
        }
    });
    if (flag===false) return;

    let postUrl = SCOPE.save_recom_url;       //后台方法地址
    $.post(postUrl, postData, function (result) {
        if(result.code===1){
            layer.alert(result.msg, {yes: function () {
                    location.reload();
                }});
        }else{
            layer.alert(result.code+': '+result.msg);
        }

    });

}



