
function uploadOneImage(dialog_title, input_selector) {
    openUploadDialog(dialog_title, function (dialog, files) {
        console.log(files);
        console.log(input_selector);
        $(input_selector).val(files[0].img_url);
        $(input_selector + '-preview').attr('src', files[0].img_url);
    }, 1, 'image');
}

/**
 * 打开文件上传对话框
 * @param dialog_title 对话框标题
 * @param callback 回调方法，参数有（当前dialog对象，选择的文件数组，你设置的extra_params）
 * @param extra_params 额外参数，object
 * @param multi 是否可以多选
 * @param filetype 文件类型，image,video,audio,file
 */
function openUploadDialog(dialog_title, callback, multi, filetype) {
    multi      = multi ? multi : 0;
    filetype   = filetype ? filetype : 'image';
    var params = '&multi=' + multi + '&filetype=' + filetype;
    var id = new Date().getTime();
    layer.open({
        type: 2,
        area: ['800px', '500px'],
        id: id,
        fixed : true,
        resize:false,
        shadeClose: true,
        scrollbar: false,
        btn: ['确定', '取消'],
        shade:0.4,
        title: dialog_title,
        content: '/admin/upload.upload/uploadImage?'+params,
        yes:function (index) {
            if (typeof callback == 'function') {
                var frameId=document.getElementById(id).getElementsByTagName("iframe")[0].id;
                var files = $('#'+frameId)[0].contentWindow.get_selected_files();
                console.log(files);
                if (files && files.length > 0) {
                    callback.apply(this, [this, files]);
                } else {
                    return false;
                }
            }
            layer.close(index);
        }
    });
}