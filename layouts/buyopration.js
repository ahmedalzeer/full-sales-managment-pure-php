$(document).ready(function () {

    $('#buysearchinput').keyup(function() {
        var q =$(this).val();
        if(q !='')
        {
            $('#buylive_data').html('');
            $.ajax({
                url:'../admin/buyajax.php',
                method:"POSt",
                data:{buysearch:q},
                dataType:'json',
                success:function (data) {
                    console.log(data);
                    $.each(data,function (key,value) {
                        $('#buylive_data').append('<div id="buymoveresult" style="background: #d3d9df; margin-bottom: 3px;">'
                            +value.item_name+'</div>');
                    });
                }
            });
        }

    });
    $(document).on('click', '#buymoveresult', function () {
        var buttonn = $(this).text();
        var fullprice =0;
        $.ajax({
            url: '../admin/buyajax2.php',
            method: "POSt",
            data: {item_name: buttonn},
            dataType: 'json',
            success: function (data) {
                $.each(data,function (key,va) {

                    $('#buyform_item').append('<tr id="buyremoverow" class="buyform" style="margin-bottom: 3px;">'
                        +'<td><div class="form-group">'
                        +'<label>الصنف</label>'
                        +'<input type="text" id="itemname" name="item_name" class="buyitemname form-control" value="'+va.item_name+'">'
                        +'<input type="hidden" name="i['+va.item_id+']" value="'+va.item_id+'">'
                        +'</div></td><td><div class="form-group">'
                        +'<label>الكمية</label>'
                        +'<input type="text" name="buyprice['+va.item_id+']" id="buymount'+va.item_id+'" class="buymount form-control" value="1">'
                        +'</div></td><td><div class="form-group">'
                        +'<label>السعر</label>'
                        +'<input type="text" name="price" id="buyprice'+va.item_id+'" class="buyprice form-control" value="'+va.sellprice+'">'
                        +'</div></td><td><div class="form-group"><i class="fa fa-close fa-3x red"></i></div></td></tr>');

                });
            }
        });

    });
    $(document).on('dblclick','#buyremoverow',function () {
        h=confirm('هل تريد حذف هذا الصنف');
        if (h==true){
            $(this).remove();
        }

    });
    $(document).on('change','.buyform',function () {
        var $btn = $(this);
        var dd=$btn.find('.buyitemname').val();
        $.ajax({
            url: '../admin/buyajax2.php',
            method: "POSt",
            data: {buyww : dd},
            dataType: 'json',
            success: function (data) {
                $.each(data,function (key,val) {
                    hh= $('#buymount'+val.item_id).val();
                    totalprice = hh*val.sellprice;
                    $('#buyprice'+val.item_id).val(totalprice);
                });
            }
        });


    });
    $(document).on("click",'#buytotalres', function(){
        var sum=0;
        $(".buyprice").each(function(){

            sum += parseInt($(this).val());
        });
        $("#buyfullprice").val(sum);
    });
    $(document).on('keyup','#buyform_sale',function () {
        staymount=$('#buypaymount').val()-$('#buyfullprice').val();
        $('#buystaymount').val(Math.abs(staymount));
    });




});