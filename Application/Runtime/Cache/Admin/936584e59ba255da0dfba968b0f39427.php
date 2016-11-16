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
                <div class="am-fl am-cf" id="html_title"><strong class="am-text-primary am-text-lg">Taskcase</strong></div><br/>
                <button type='button' style="float:right;" ov_id="<?php echo ($group_id); ?>" class='am-btn am-btn-default am-btn-xs am-text-secondary am-text-danger'  onclick='add(this)'> <span class='am-icon-pencil-square-o'></span> Edit Item</button>
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


<div class="am-modal am-modal-confirm" id="add_item_modal" style="top:-20%;" tabindex="<?php echo ($v[id]); ?>">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">Edit Item</div>
        <div class="am-modal-bd">
          <label style="display:inline;">Item:</label>
          <input type="text" class="am-modal-prompt-input" id="add_item" style="width:300px;display:inline;border:1px solid #9C9898;"><br/>
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-confirm style="width: 50%;border:1px solid #9C9898;">OK</span>
            <span class="am-modal-btn" data-am-modal-cancel style="width: 50%;border:1px solid #9C9898;">Cancel</span>
        </div>
    </div>
</div>



<script >
function add(obj) {
	var group_id=$(obj).attr('ov_id');
	console.log(group_id);
    $("#add_item").val("");
    $("#add_item_modal").modal({
        relatedTarget:this,
        onConfirm:function(e){
                var arr=e.data;
                console.log(arr);
                $.post("<?php echo U('Admin/Task/index');?>",{'item':arr,'group':group_id},function (data) {
                	location.reload();
                });
                /* var str=("<?php echo U('Admin/Task/index',array('item'=>arr,'group'=>group_id));?>").replace('arr',arr).replace('group_id',group_id);
                location.href=str;  */
        },
        onCancel:function (e) {
            e.close()
        }
    });
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