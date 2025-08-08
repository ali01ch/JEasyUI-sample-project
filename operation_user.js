var url;
function newUser(){
    $('#dlg').dialog('open').dialog('center').dialog('setTitle','کاربر جدید');
    $('#entry-fm').form('clear');
    url = 'operation_user.php';
}
function editUser(){
    var row = $('#users').datagrid('getSelected')
    if(row){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','ویرایش کاربر');
        $('#entry-fm').form('load' , row);
        url = 'operation_user.php?id='+row.id;
    }
}
function saveUser(){
    $('#entry-fm').form('submit',{
        url: url,
        iframe: false,
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            $('#dlg').dialog('close');
            $('#users').datagrid('reload');
        }
    });
}
function removeUser(){
    var row = $('#users').datagrid('getSelected');
    if (row){
        $.messager.confirm({title:'حذف کاربر' ,msg:' آیا از حذف کاربر مطمن هستید؟', ok: 'بله' ,cancel: 'خیر',fn: function(r){
            if (r){
                $.post('operation_user.php?id='+row.id+'&remove="true"',{},function(response){
                    if (response.success){
                        $('#users').datagrid('reload');
                    } else {
                        $.messager.show({ 
                            title: 'Error',
                            msg: response.errorMsg
                        });
                    }
                },'json');
            }
        }});
    }
}