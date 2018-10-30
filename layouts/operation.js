$(document).ready(function () {

    $('#searchinput').keyup(function() {
        var q =$(this).val();
        if(q !='')
        {
            $('#live_data').html('');
            $.ajax({
                url:'../admin/saleajax.php',
                method:"POSt",
                data:{search:q},
                dataType:'json',
                success:function (data) {
                    console.log(data);
                    $.each(data,function (key,value) {
                        $('#live_data').append('<div id="moveresult" style="background: #d3d9df; margin-bottom: 3px;">'
                            +value.item_name+'</div>');
                    });
                }
            });
        }

    });
    $('#searchdash').keyup(function() {
        var q =$(this).val();
        if(q !='')
        {
            $('#live_dashdata').html('');
            $.ajax({
                url:'../admin/saleajax.php',
                method:"POSt",
                data:{search:q},
                dataType:'json',
                success:function (data) {
                    console.log(data);
                    $.each(data,function (key,value) {
                        $('#live_dashdata').append('<li style="background: #d3d9df; margin-bottom: 3px;">'
                            +'  '+value.item_name+'  '+'<i class="fa fa-arrow-circle-left"></i>'+' '+value.sellprice+'</li>');
                    });
                }
            });
        }

    });
    $(document).on('click', '#moveresult', function () {
        var buttonn = $(this).text();
        var fullprice =0;
        $.ajax({
            url: '../admin/saleajax2.php',
            method: "POSt",
            data: {item_name: buttonn},
            dataType: 'json',
            success: function (data) {
                $.each(data,function (key,va) {
                    var v = va.stay_mount - va.sell_mount;
                    if(v <=0){ vv = 0}else{ vv = 1}
                    $('#form_item').append('<tr id="removerow" class="form" style="margin-bottom: 3px;">'
                        +'<td><div class="form-group">'
                        +'<label>الصنف</label>'
                        +'<input type="text" id="itemname" name="item_name" class="itemname form-control" value="'+va.item_name+'">'
                        +'<input type="hidden" name="i['+va.item_id+']" value="'+va.item_id+'">'
                        +'</div></td><td><div class="form-group">'
                        +'<label>الكمية</label> '+'  '+v
                        +'<input type="text" name="buyprice['+va.item_id+']" id="mount'+va.item_id+'" class="mount form-control" value="'+vv+'">'
                        +'</div></td><td><div class="form-group">'
                        +'<label>السعر</label>'
                        +'<input type="text" name="price" id="price'+va.item_id+'" class="buyprice form-control" value="'+va.sellprice+'">'
                        +'</div></td><td><div class="form-group"><i class="fa fa-close fa-3x red"></i></div></td></tr>');

                });
                }
        });

    });
    $(document).on('dblclick','#removerow',function () {
        h=confirm('هل تريد حذف هذا الصنف');
        if (h==true){
            $(this).remove();
        }

    });
    $(document).on('change','.form',function () {
        var $btn = $(this);
        var dd=$btn.find('.itemname').val();
        $.ajax({
            url: '../admin/saleajax2.php',
            method: "POSt",
            data: {ww : dd},
            dataType: 'json',
            success: function (data) {
                $.each(data,function (key,val) {
                    hh= $('#mount'+val.item_id).val();
                    totalprice = hh*val.sellprice;
                    $('#price'+val.item_id).val(totalprice);
                });
            }
        });


    });
    $(document).on("click",'#totalres', function(){
        var sum=0;
        $(".buyprice").each(function(){

                sum += parseInt($(this).val());
        });
        $("#fullprice").val(sum);
    });
    $(document).on('keyup','#form_sale',function () {
        staymount=$('#paymount').val()-$('#fullprice').val();
        $('#staymount').val(Math.abs(staymount));
    });




});