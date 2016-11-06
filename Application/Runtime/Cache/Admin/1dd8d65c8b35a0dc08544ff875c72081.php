<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<HTML>
<HEAD>
    <TITLE> Case</TITLE>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/qaweb/Public/ztree/css/demo.css" type="text/css">
    <link rel="stylesheet" href="/qaweb/Public/ztree/css/awesomeStyle/awesome.css" type="text/css">
    <script type="text/javascript" src="/qaweb/Public/assets/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/qaweb/Public/ztree/js/jquery.ztree.core.js"></script>
    <script type="text/javascript" src="/qaweb/Public/ztree/js/jquery.ztree.excheck.js"></script>
    <script type="text/javascript" src="/qaweb/Public/ztree/js/jquery.ztree.exedit.js"></script>
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="/qaweb/Public/assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="/qaweb/Public/assets/i/app-icon72x72@2x.png">
    <link rel="stylesheet" href="/qaweb/Public/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/qaweb/Public/assets/css/admin.css">
    <style>
        .am-form-group{
            display: block;
            margin: 5px auto 0 auto;
            border-radius: 0;
            padding: 5px;
            line-height: 1.8rem;
            width: 80%;
            border: 1px solid #dedede;
            -webkit-appearance: none;
            -moz-appearance: none;
            -ms-appearance: none;
            appearance: none;
        }
        div#rMenu {position:absolute; visibility:hidden; top:0;text-align: left;padding: 2px;}
        div#rMenu ul li{
            margin: 1px 0;
            padding: 0 5px;
            cursor: pointer;
            list-style: none outside none;
            background-color: #DFDFDF;
        }
		.blo{
			display:block;
		}
		.non{
			display:none;
		}

    </style>
</HEAD>
<body>
<div class="am-cf admin-main am-padding-top-0">
    <!-- content start -->
    <div class="admin-content" id="content">
        <div class="am-cf am-padding am-padding-bottom-0" id="content-body">
            <div class="am-g">
                <div class="am-fl am-cf" id="html_title"><strong class="am-text-primary am-text-lg">Task</strong> / <?php echo ($task_info[name]); ?></div><br/>
            </div>
        </div>
        <br/>
        <!--Task case--->
        <div class="am-g" style="padding-left:10px;">
           <div class="container" id="edit_page">
              <div class="am-g">
                <div class="am-u-md-12">   
                         <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-title"><a href="javascript:reorder('name');">CaseName</a></th>
                                <th class="table-title"><a href="javascript:reorder('pid');">ItemName</a></th>
                                <th class="table-title"><a href="javascript:reorder('suit');">ItemUnit</a></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
                                <td><?php echo ($v[case_name]); ?></td>
                                <td><?php echo ($v[item_name]); ?></td>
                                <td><?php echo ($v[item_unit]); ?></td>
                            </tr><?php endforeach; endif; ?>
                            </tbody>
                        </table>
                       
                           
                    </div>
                </div>
            </div>
        </div>






<script >
    window.onload=function () {
        tree_fresh();
        var arr=window.location.href.split("/");
        $("#search_tid").find("option[value="+arr[arr.indexOf("tid")+1]+"]").attr('selected', true);
        var result_id=arr.indexOf("result");
        if(result_id!=-1)
            $("#search_result").find("option[value="+arr[result_id+1]+"]").attr('selected', true);

        $("#search_result").attr("onchange","task_show(this)");
    }

    function del(obj) {
        var id=$(obj).attr('task_id');
        if(confirm('Do you want delete this TaskCase ?')){
            $.post("<?php echo U('Admin/Task/case_del');?>",{id:id},function () {
                location.reload();
                //task_show($("#search_tid"));
            });
        }
    }

    //编辑相应taskcase
    function edit(obj) {
        var id=$(obj).attr('task_id');
       /* $.each(taskcase_info,function (k,v) {
            if(v['id']==id){
                $("#edit_id").val(id).hide();
                $("#edit_result").find("option[value="+v.result+"]").attr('selected',true);
                $("#edit_BugID").val(v.BugID);
                $("#edit_comments").val(v.comments);
                $("#edit_driver").val(v.driver);

                return false;
            }
        }); */

        $("#edit_case_modal").modal({
            relatedTarget:this,
            onConfirm:function(e){
                var arr={id:id,driver:e.data['1'],BugID:e.data['0'],Status:e.data['2'],comments:e.data['3'],result:$("#edit_result").val()};
                $.post("<?php echo U('Admin/Task/case_edit');?>",arr,function (data) {
                    location.reload();
                    //task_show($("#search_tid"));
                });
            },
            onCancel:function (e) {
                e.close()
            }
        });
    }

    //添加，删除taskcase
    function add() {
        var tid=$("#search_tid").val();
        if(tid==""||tid==null){
            alert("There is no explicit task!");
        }else{
            var nodes=zTree.getCheckedNodes();
            var arr=new Array();
            $.each(nodes,function (k,v) {
                if(v.id>10000)
                    arr.push(v.id/10000);
            });
            var cids=arr.join(',');
            $.post("<?php echo U('Admin/Task/case_reassign');?>",{cids:cids,tid:tid},function (data) {
                $.post("<?php echo U('Admin/Task/case_index');?>",{ajax:true,tid:tid},function (data) {
                    location.reload();
                    /*$("#edit_table").empty().html(data);
                    tree_fresh();*/
                });
            })
        }
    }

    //task下拉菜单 切换查看task
    function task_show(obj) {
        var tid=$("#search_tid").val();
        var result=$("#search_result").val();
        if(tid!=null&&tid!="") {
            location.href=("<?php echo U('Admin/Task/case_index',array('tid'=>vid,'result'=>'nowresult'));?>").replace('vid',tid).replace('nowresult',result);
            if(result==0){
                location.href=("<?php echo U('Admin/Task/case_index',array('tid'=>vid));?>").replace('vid',tid);
            }
            /*$.post("<?php echo U('Admin/Task/case_index');?>",{ajax:true,tid:tid},function (data) {
                location.href
            });*/
        }
        else
            location.reload();
    }

    //search按钮
    function search() {
    	var search_type=$("#search_type").val();
    	var search_tid=$("#search_tid").val();
    	var search_name=$("#search_name").val();
    	//var arr=("{ajax:true,tid:search_tid,BugID:search_name}").replace("BugID",search_type).replace("search_tid",search_tid).replace("search_name",search_name);
    	if(search_type=='BugID')
        	var arr={ajax:true,tid:$("#search_tid").val(),BugID:$("#search_name").val()};
    	else if(search_type=='result')
            var arr={ajax:true,tid:$("#search_tid").val(),result:$("#search_name").val()};
    	else if(search_type=='Status')
            var arr={ajax:true,tid:$("#search_tid").val(),Status:$("#search_name").val()};
    	else if(search_type=='CaseName')
            var arr={ajax:true,tid:$("#search_tid").val(),CaseName:$("#search_name").val()};
    	else var arr={ajax:true,tid:$("#search_tid").val(),driver:$("#search_name").val()};
         $.post("<?php echo U('Admin/Task/case_index');?>",arr,function (data) {
            page_fresh(data);
        });
    }

    function cancel() {
        zTree.checkAllNodes(false);
        $.each(taskcase_info,function (k,v) {
            var node=zTree.getNodesByParam('id',v['cid']+"0000");
            zTree.checkNode(node['0'],true,true);
        });
    }

    function reorder(name) {
        var arr={ajax:true,tid:$("#search_tid").val(),BugID:$("#search_name").val(),sort:name};
        $.post("<?php echo U('Admin/Task/case_index');?>",arr,function (data) {
            //location.reload();
            page_fresh(data);
        });
    }
    //树对应刷新
    function tree_fresh(){
        var arr=<?php echo ($cid_list); ?>;
        zTree.checkAllNodes(false);
        if(arr!=null){
            var class_count={};
            $.each(arr,function (k,v) {
                var node=zTree.getNodesByParam('id',v['cid']+"0000");
                zTree.checkNode(node['0'],true,true);
                var pid=node['0']['pId'];
                if(class_count[pid]==null){
                    class_count[pid]=1;
                }else{
                    class_count[pid]+=1;
                }
            });
            $.each(class_count,function (k,v) {
                var node=zTree.getNodesByParam('id',k);
                node['0'].name+='('+v+')';
                zTree.updateNode(node['0']);
            });
        }
    }

    //异步刷新页面
    function page_fresh(data) {
        $("#edit_table").empty().html(data);
        tree_fresh();
    }
    function toCaseItem(id) {
        var str=("<?php echo U('Admin/Task/case_index',array('id'=>ppid));?>").replace('ppid',id);
        location.href=str;
    }
</script>

    <div id="rMenu">
        <ul>
            <li id="reassign" onclick="reassign();">Reassign</li>
            <li id="all_result" onclick="set_result();">Batch set result</li>
        </ul>
    </div>

<script src="/qaweb/Public/assets/js/amazeui.min.js"></script>


</body>
</HTML>