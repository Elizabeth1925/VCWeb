 <h2>Registro de Estudiantes</h2> 
    <link rel="stylesheet" type="text/css" href="jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="jquery/themes/color.css">
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="jquery/jquery.easyui.min.js"></script>
    
    <div style="text-align:center;margin:0 auto;width:90%;">
    <table id="dg" title="My Users" class="easyui-datagrid" style="width:100%;height:550px"
            url="models/seleccionar.php"
            toolbar="#toolbar" pagination="true" pageSize="10" pageList="[10,20,30,50]"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="ced_est" width="50">Cédula</th>
                <th field="nom_est" width="50">Nombre</th>
                <th field="ape_est" width="50">Apellido</th>
                <th field="tel_est" width="50">Teléfono</th>
                <th field="dir_est" width="50">Dirección</th>
            </tr>
        </thead>
    </table>
    </div>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Eliminar Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="generarReporte()">Reportes</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="reporteGeneral()"> Reporte Jasper</a>

        <span style="margin-left:30px">
            <input id="cedula_buscar" type="text" placeholder="Buscar por Cédula" style="width:150px;padding:5px;">
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="buscarPorCedula()">Buscar</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-clear" plain="true" onclick="limpiarBusqueda()">Limpiar</a>
        </span>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>Información del Estudiante</h3>
            <div style="margin-bottom:10px">
                <input name="ced_est" class="easyui-textbox" required="true" label="Cédula:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="nom_est" class="easyui-textbox" required="true" label="Nombre:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="ape_est" class="easyui-textbox" required="true" label="Apellido:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="tel_est" class="easyui-textbox" required="true" label="Teléfono:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="dir_est" class="easyui-textbox" required="true" label="Dirección:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancelar</a>
    </div>
    <script type="text/javascript">
        var url;
        // Configurar idioma español para easyui
        $.extend($.fn.datagrid.defaults.editors, {});
        $.extend($.fn.datagrid.defaults, {
            pageText: 'Pagina {from} a {to} de {total} registros'
        });
        $.extend($.fn.pagination.defaults, {
            beforePageText: 'Pagina',
            afterPageText: 'de {pages}',
            displayMsg: 'Mostrando {from} a {to} de {total} elementos'
        });
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Usuario');
            $('#fm').form('clear');
            url = 'models/guardar.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Usuario');
                $('#fm').form('load',row);
                url = 'models/editar.php';
            }
        }
        function saveUser(){
            $('#fm').form('submit',{
                url: url,
                iframe: false,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = JSON.parse(result);
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $.messager.show({
                            title: 'Éxito',
                            msg: result.message
                        });
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirmar','¿Está seguro de que desea eliminar este estudiante?',function(r){
                    if (r){
                        $.get('models/borrar.php',{ced_est:row.ced_est},function(result){
                            if (result.success){
                                $.messager.show({
                                    title: 'Éxito',
                                    msg: result.message
                                });
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
        function generarReporte(){
            window.open('reporte1.php', '_blank');
        }

        function buscarPorCedula(){
         var cedula = document.getElementById('cedula_buscar').value.trim();
         if(cedula == ''){
         alert("Ingrese cédula");
         return;
         }
            $('#dg').datagrid('load',{
         cedula: cedula,
            t: new Date().getTime()
        });
        }

        function limpiarBusqueda(){
          document.getElementById('cedula_buscar').value = '';

         $('#dg').datagrid('load',{
        t: new Date().getTime()
          });
        }
function reporteGeneral(){
    window.open('reporteJasper.php','_blank');
}

    </script>

