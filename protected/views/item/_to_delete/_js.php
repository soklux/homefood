<script>
    var id=1;
    var price_range=[{arrID:'',from_quantity:'',to_quantity:'',price:0,start_date:'',end_date:''}];
    function addPriceRange(){
        $('#price-range').append('\
			<div class="range-'+id+'">\
			<hr style="width:90%; margin-left:0px;">\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="text" class="txt-from-qty'+id+' form-control" placeholder="From" onkeyUp="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="text" class="txt-to-qty'+id+' form-control" placeholder="To" onkeyUp="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="text" class="txt-price'+id+' form-control" placeholder="Price" onkeyUp="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="date" class="dt-start-date'+id+' form-control" placeholder="Start Date" title="Satrt Date" onChange="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2">\
                <div class="form-group col-sm-12">\
				    <input type="date" class="dt-end-date'+id+' form-control" placeholder="End Date" title="End Date" onChange="getValue('+id+')">\
				</div>\
			</div>\
			<div class="col-sm-2"><input type="button" value="X" class="btn btn-danger" onClick="removePriceRange('+id+')"></div>\
		</div>\
			');
        price_range.push({arrID:id,from_quantity:'',to_quantity:'',price:0,start_date:'',end_date:''});
        console.log(price_range);
        id=id+1;

    }

    function removePriceRange(rid){
        $('.range-'+rid).html('');
        price_range.forEach(function(v,i){
            if(price_range[i].arrID==rid){
                price_range.splice(i,1);
            }
        })
    }

    function getValue(rid=''){
        price_range.forEach(function(v,i){
            if(price_range[i].arrID==rid){
                price_range[i].from_quantity=$('.txt-from-qty'+rid).val();
                price_range[i].to_quantity=$('.txt-to-qty'+rid).val();
                price_range[i].price=$('.txt-price'+rid).val();
                price_range[i].start_date=$('.dt-start-date'+rid).val();
                price_range[i].end_date=$('.dt-end-date'+rid).val();
            }
        });
        console.log(price_range)
    }

   /* $('#item-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            type:'post',
            url:'<?php // Yii::app()->createUrl('item/saveItem')?>',
            data:{
                Item:
                    {
                        item_number:$('.txt-item-number').val(),
                        name:$('.txt-item-name').val(),
                        reorder_level:$('.txt-reorder-level').val(),
                        location:$('.txt-location').val(),
                        description:$('.txt-description').val(),
                    },
                data:price_range
            },
            beforeSend:function(data){
                $('.waiting').slideDown();
            },
            success:function(data){
                $('.waiting').slideUp();
            }
        })
    });*/

</script>