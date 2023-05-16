
    // 利用json来写
    //主要功能：当我切换点击类型的时候，就要获取当前这个最新的类型的他下面有那些属性{所有属性}（根据类型的id获取到这类型下面有那些属性）
    // 选定select,根据select的name来选定他的name是等于type_id,当他的值change（值发送改变的）的时候就执行里面的命名函数
    $("select[name=type_id]").change(function () {
    var type_id = $(this).val();
    //通过ajax的异步请求获取当前类型下面的属性
    $.ajax({
    type:"POST",
    url:"{:url('Attr/ajaxGetAttr')}", //通过类型的id获取属性的方法在attr控制下面的AjaxGetAttr方法
    data:{type_id:type_id}, //发送的参数
    dataType:"json",//接收的数据格式是json格式
    success:function(data){ //我们获取——经过异步的请求或去的数据就是data
    var html = ''; //定义一个空的字符串
    $(data).each(function (k,v){  //date是一个二维数组 ，每次都会把一条记入给了v，一个v就代表一个属性
    // html+=v.attr_name+":<input type='text'/><br>";
    if (v.attr_type == 1){
    //单选处理
    html+="<div class='form-group'>"
    html+= "<label class='col-sm-2 control-label no-padding-right'>"+v.attr_name+"</label>";
    var attrValuesArr = v.attr_values.split(",") //对他进行拆分 split函数是拆分把一个字符串分割成字符串数组
    //等拆分的数组放到这里  //addrow(this) 是定义一个方法 并把他自己传递进去，this就是把自己传递进去 自己就是a标签这个元素
    html+="<div class='col-sm--6'><a class='a-btn' onclick='addrow(this);' href='#'>[+]</a>";
    html+="<select name='goods_attr["+v.id+"][]'>";//goods_attr 后面加[] 是要以数组的形式处理上传 因为他是多个上传
    html+="<option value=''>请选择</option>";
    //循环得到的数组
    for (var i=0; i<attrValuesArr.length; i++){
    //循环选项 (循环的属性值是attrValuesArr里的i)
    html+="<option value='"+attrValuesArr[i]+"'>"+attrValuesArr[i]+"</option>";
}
    html+="</select>";
    html+="<input type='text'  placeholder='价格' class='form-control price' name='attr_price[]'  >";//attr_price 后面加[] 是要以数组的形式处理上传 因为他是多个上传
    html+="</div></div> ";




}else {
    //唯一处理
    if (v.attr_values){
    html+="<div class='form-group'>"
    html+= "<label class='col-sm-2 control-label no-padding-right'>"+v.attr_name+"</label>";
    var attrValuesArr = v.attr_values.split(",") //对他进行拆分 split函数是拆分把一个字符串分割成字符串数组
    //等拆分的数组放到这里
    html+="<div class='col-sm--6'>";
    html+="<select name='goods_attr["+v.id+"]'>";
    html+="<option value=''>请选择</option>";
    //循环得到的数组
    for (var i=0; i<attrValuesArr.length; i++){
    //循环选项 (循环的属性值是attrValuesArr里的i)
    html+="<option value='"+attrValuesArr[i]+"'>"+attrValuesArr[i]+"</option>";
}
    html+="</select>";
    html+="</div></div> ";

}else {
    //单行文本框
    html+="<div class='form-group'>"
    html+= "<label class='col-sm-2 control-label no-padding-right'>"+v.attr_name+"</label>";
    var attrValuesArr = v.attr_values.split(",") //对他进行拆分 split函数是拆分把一个字符串分割成字符串数组
    //等拆分的数组放到这里
    html+="<div class='col-sm--6'>";
    html+="<input type='text'  name='goods_attr["+v.id+"]'   class='form-control price' >"
    html+="</div></div> ";
}


}
});
    $("#attr_list").html(html);//用css定义的id属性来选择 ,直接把定义的var html 放进去
}
})
})

    //addrow方法可以对select加一对减一
    function addrow(o) {
    //定义最外层的div 他下面的副记标签的父记标签 parent()就是父记标签的意思是
    var div=$(o).parent().parent();
    if ($(o).html()  == '[+]'){
    //clone()函数就复制克隆
    var newdiv=div.clone();//clone是克隆方法，克隆方法生成被选元素的副本，包含子节点、文本和属性。
    newdiv.find('a').html('[-]');//利用find函数去查询到newdiv里的a标签，在利用html把a标签里面的'+'修改成'-'
    div.after(newdiv);
}else {
    //remove函数
    //方法移除被选元素，包括所有的文本和子节点。
    // 该方法也会移除被选元素的数据和事件。
    //删除所有匹配的元素。
    div.remove();
}
}





