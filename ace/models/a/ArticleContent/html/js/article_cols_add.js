layui.use(['layer', 'form'], function () {
    var form = layui.form;
    var layer = layui.layer;
    // var layedit = layui.layedit;


    $('#form_control').submit(function (e) {
        e.preventDefault();
        submitForm();
    });


    // 监听“选择类型”select
    form.on('select(filterType)', function (data) {

        $('#extra').html('');
        form.render();

        var type = data.value;
        switch (type) {
            case "":
                cleanOption(); // 清空下面所有数据
                break;
            case "string":
            case "integer":
                stringOption(); // 选择了字符串
                break;
            case "text": // 选择了文字域
                textOption();
                break;
            case "mediumText": // 选择了文章
                mediumTextOption();
                break;
            case "file":
                fileOption();
                break;
            case "custom": // 选择了自定义组件
                customOption();
                break;
            default:
                alert("无效操作!");
                break;
        }

    });


    // 监听“表现形式”select
    form.on('select(filterView)', function (data) {
        var view = data.value;
        switch (view) {
            case "input":
            case "password":
                setDefaultInput();
                break;
            case "timer":
                setDefaultTimer();
                break;
            case "radio":
            case "checkbox":
            case "select":
                setDefaultExplode();
                break;
            case "textarea":
                textAreaDefault();
                break;
            case "markdown":
                setMarkdownDefault();
                break;
            case "ueditor":
                setUeditorDefault();
                break;
            case "simple_img_upload":
            case "simple_file_upload":
            case "multi_img_upload":
            case "multi_file_upload":
                setUploadDefault();
                break;
            default:
                alert("无效操作");
                break;
        }


    });


    var cleanOption = function () {
        $("#view").html("");
        $("#extra").html("");
        form.render(); //更新全部
    };

    var stringOption = function () {

        $("#view").html("");
        var html = `
        <option value="">请下拉选择</option>
        <option value="input">输入框</option>
        <option value="password">密码输入框</option>
        <option value="timer">时间选择器</option>
        <option value="radio">单选</option>
        <option value="checkbox">多选</option>
        <option value="select">下拉框</option>
        `;
        $("#view").html(html);

        form.render(); //更新全部
    };

    var intOption = function () {
        $("#view").html("");
        var html = `
        <option value="">无</option>
        <option value="input">输入框</option>
        <option value="password">密码输入框</option>
        <option value="radio">单选</option>
        <option value="checkbox">多选</option>
        <option value="select">下拉框</option>    
        `;
        $("#view").html(html);
        form.render(); //更新全部
    };

    var textOption = function () {
        $("#view").html("");
        var html = `
        <option value="">无</option>
        <option value="textarea">空编辑器</option>
        <option value="markdown">markdown编辑器</option>
        <option value="ueditor">Ueditor编辑器</option>    
        `;
        $("#view").html(html);
        form.render(); //更新全部
    };
    var mediumTextOption = function () {
        $("#view").html("");
        var html = `
        <option value="">无</option>
        <option value="textarea">空编辑器</option>
        <option value="markdown">markdown编辑器</option>
        <option value="ueditor">Ueditor编辑器</option>    
        `;
        $("#view").html(html);
        form.render(); //更新全部
    };
    var customOption = function () {
        // extra
        $("#view").html("");
        var html = `
        <option value="custom">自定义</option>   
        `;
        $("#view").html(html);

        $("#extra").html("");
        html = `
            <div class="layui-form-item">
                <label class="layui-form-label">自定义表现形式</label>
                <div class="layui-input-block">
                    <input type="text" id="customView" name="title" lay-verify="required" autocomplete="off" placeholder="请输入 自定义的表现形式，可参考文档" class="layui-input">
                </div>
            </div>
        `;
        $("#extra").html(html);

        form.render(); //更新全部

    };

    var fileOption = function () {
        $("#view").html("");
        var html = `
          <option value="">无</option>
          <option value="simple_img_upload">单图上传</option>
          <option value="simple_file_upload">单文件上传</option>
          <option value="multi_img_upload">多图上传</option>
          <option value="multi_file_upload">多文件上传</option>
         `;
        $("#view").html(html);
        form.render(); //更新全部
    };

    var setDefaultInput = function () {
        $("#extra").html("");
        var html = `
            <div class="layui-form-item">
                <label class="layui-form-label">字段默认值</label>
                <div class="layui-input-block">
                    <input type="text" id="defaultValue" name="title" lay-verify="" autocomplete="off" placeholder="请输入 字段默认值。可选" class="layui-input">
                </div>
            </div>
        `;
        $("#extra").append(html);

        form.render(); //更新全部
    };

    var setDefaultTimer = function () {

    };

    var setDefaultExplode = function () {
        $("#extra").html("");
        var html = `
            <div class="layui-form-item">
                <label class="layui-form-label">选项</label>
                <div class="layui-input-block">
                    <input type="text" id="options" name="title" lay-verify="required" autocomplete="off" placeholder="请输入 单选框/多选框/下拉框的候选选项,使用|号分割。必填" class="layui-input">
                </div>
            </div>
    
            <div class="layui-form-item">
                <label class="layui-form-label">默认选中项</label>
                <div class="layui-input-block">
                    <input type="text" id="defaultValue" name="title" lay-verify="" autocomplete="off" placeholder="请输入 默认选中项。可选" class="layui-input">
                </div>
            </div>
            `;
        $("#extra").append(html);

        form.render(); //更新全部
    };

    var setMarkdownDefault = function () {
        $("#extra").html("");
        var html = `
    <div class="layui-form-item">
    <label class="layui-form-label">请输入文字域默认值</label>
    <div class="layui-input-block">
    <div id="editormd"></div>
    </div>
    </div>
    
    <link rel="stylesheet" href="editor/css/editormd.min.css">
    
    <script src="editor/editormd.min.js" type="text/javascript"></script>
         <script >
           var editor = editormd("editormd", {
                height: 300,
                saveHTMLToTextarea : true,
                path : "editor/lib/"
            });
    </script>
        `;
        $("#extra").html(html);

        form.render(); //更新全部
    };

    var setUeditorDefault = function () {
        $("#extra").html("");


        var html = `
    <div class="layui-form-item">
    <label class="layui-form-label">请输入文字域默认值</label>
    <div class="layui-input-block">
    <script id="container" name="content" type="text/plain">
    这里写你的初始化内容
</script>
    </div>
    </div>

    <!-- 实例化编辑器 -->
       <script type="text/javascript">
             var ue = UE.getEditor('container');
       </script> 
        `;
        $("#extra").html(html);

        form.render(); //更新全部
    };

    var setUploadDefault = function () {
        $("#extra").html("");
        var html = `

                                            <div class="layui-form-item">
                                            <label class="layui-form-label">保存路径</label>
                                            <div class="layui-input-block">
                                                <input type="text" id="savepath" name="title" value="/data/Upload/" lay-verify="required" autocomplete="off" placeholder="请输入 上传文件的保存路径" class="layui-input">
                                            </div>
                                            </div>
        `;
        html += `
                                            <div class="layui-form-item">
                                            <label class="layui-form-label">允许上传的后缀名</label>
                                            <div class="layui-input-block">
                                                <input type="text" id="ext" name="title" lay-verify="required" autocomplete="off" placeholder="请输入 允许上传的后缀名，使用|号连接，置空为允许全部后缀名" class="layui-input">
                                            </div>
                                            </div>
        `;
        html += `
                                            <div class="layui-form-item">
                                            <label class="layui-form-label">命名规则</label>
                                            <div class="layui-input-inline">
                                                <select id="name_rule" name="interest" lay-verify="required">
                                                    <option value="">请下拉选择</option>
                                                    <option value="file_name">原文件名</option>
                                                    <option value="timestamp">时间戳</option>
                                                    <option value="random_timestamp">时间戳+8位随机字符</option>
                                                </select>
                                            </div>
                                            </div>
        `;

        $("#extra").html(html);

        form.render(); //更新全部
    };

    var textAreaDefault = function () {
        $("#extra").html("");
        var html = `
        <div class="layui-form-item layui-form-text">
          <label class="layui-form-label">默认内容</label>
          <div class="layui-input-block">
              <textarea id="editor" placeholder="请输入 默认内容" class="layui-textarea"></textarea>
          </div>
        </div>
     `;
        $("#extra").append(html);

        form.render(); //更新全部
    };


    // 监听字段表单提交
    var submitForm = function () {
        var name = $("#name").val(); // 名称
        var comment = $("#comment").val(); // 入库时候的描述
        var required = $('input[name="required"]:checked').val(); // 是否必填
        var show = $('input[name="show"]:checked').val(); // 是否显示在列表字段中
        var type = $("#type option:selected").val(); //类型
        if (type == 'file' || type == 'custom') {
            type = 'text'; //如果是文件上传类或自定义类，则定义这个字段是text
        }
        var view = $("#view option:selected").val(); // 表现形式
        switch (view) {
            case "radio":
            case "checkbox":
            case "select":
                view += "->" + $("#options").val();
                form.render(); //更新全部
                break;
            case "custom":
                view = $("#customView").val();
                form.render(); //更新全部
                break;
            case "simple_img_upload":
            case "simple_file_upload":
            case "multi_img_upload":
            case "multi_file_upload":
                view += "->" + $("#savepath").val() + ";" + $("#ext").val() + ";" + $("#name_rule option:selected").val();
                form.render(); //更新全部
                break;
            default:
                break;

        }
        var options; // 对表现形式的补充
        var default_value = $("#defaultValue").val(); // 默认值
        var validate = $("#validate").val(); // 验证规则
        var obj = {};

        obj.show = show; //

        obj.name = name;
        obj.comment = comment;
        obj.type = type;
        obj.view = view;


        if (view == "markdown") {
            default_value = encodeURI(editor.getHTML());
        } else if (view == "textarea") {
            default_value = $("#editor").text();
        }

        if (default_value != "" && typeof (default_value) != "undefined") {
            obj.default = default_value;
        }
        if (validate != "" && typeof (validate) != "undefined") {
            if (required == "required") {
                obj.validate = validate + "|required";
            } else {
                obj.validate = validate;
            }

        }
        if (validate == "" || typeof (validate) == "undefined") {
            if (required == "required") {
                obj.validate = required;
            }
        }

        var data = {};
        data.name = name;
        data.info = JSON.stringify(obj);
        parent.renderModuleTable(data); // 把数据添加到父页面的表格中
        // console.log(obj);
        var i = parent.layer.getFrameIndex(window.name);
        parent.layer.close(i);
    }


})