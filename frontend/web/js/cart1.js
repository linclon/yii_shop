/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/
function totalPrice()
{
	var total = 0;
	$(".col5 span").each(function(){
		total += parseFloat($(this).text());
	});

	$("#total").text(total.toFixed(2));
}

$(function(){
	
	//减少
	$(".reduce_num").click(function(){
		var amount = $(this).parent().find(".amount");
		if (parseInt($(amount).val()) <= 1){
			alert("商品数量最少为1");
		} else{
			$(amount).val(parseInt($(amount).val()) - 1);
		}

		var num = parseInt($(amount).val());
		var tr = $(this).closest("tr");
		var goods_id = tr.attr('data-goods-id');
		$.post('/cart/change?status=edit',{goods_id:goods_id,num:num},function(data){
			if(data == 'success'){
				//修改成功
				$(amount).val(num);
				//小计
				var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
				tr.find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});
				$("#total").text(total.toFixed(2));
			}else{
				console.debug('修改失败!');
			}		});
	});

	//增加
	$(".add_num").click(function(){

		var amount = $(this).parent().find(".amount");
		var num = parseInt($(amount).val()) + 1;

		var tr = $(this).closest("tr");
		var goods_id = tr.attr('data-goods-id');
		$.post('/cart/change?status=edit',{goods_id:goods_id,num:num},function(data){

			if(data == 'success'){
				//修改成功
				$(amount).val(num);
				//小计
				var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
				tr.find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});
				$("#total").text(total.toFixed(2));
			}else{
				console.debug('修改失败!');
			}
		});
	});

	//直接输入
	$(".amount").blur(function(){
		if (parseInt($(this).val()) < 1){
			alert("商品数量最少为1");
			$(this).val(1);
		}
		var amount = $(this).parent().find(".amount");
		var num = parseInt($(amount).val());
		var tr = $(this).closest("tr");
		var goods_id = tr.attr('data-goods-id');
		$.post('/cart/change?status=edit',{goods_id:goods_id,num:num},function(data){
			if(data == 'success'){
				//修改成功
				$(amount).val(num);
				//小计
				var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
				tr.find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});
				$("#total").text(total.toFixed(2));
			}else{
				console.debug('修改失败!');
			}
		});
	});

	$(".btn_del").click(function(){
		if(confirm('确定删除该信息吗?')){
			var tr = $(this).closest("tr");
			var goods_id = tr.attr('data-goods-id');
			$.post('/cart/change?status=del',{goods_id:goods_id},function(data){
				if(data == 'success'){
					//后台删除成功
					tr.remove();
					totalPrice();
				}
			});
		}
	});



});