<?php session_start();
?>
<!doctype html>
<html>
<head>
    <title>Equip Shop</title>
    <style>
        #shop-container{
            border: solid 1px;
            border-color: black;
        }
        #merchant-container{
            border: solid 1px;
            border-color: red;
        }
        #merchant-img{
            margin-left: auto;
            margin-right: auto;
            display:block;
            height: 250px;
            width: auto;
        }
        .inv_row{
            width: 615px;
            margin-left: auto;
            margin-right: auto;
            display: block;
            overflow: hidden;
        }
        .inv_item{
            border: solid 1px;
            border-color: black;
            float: left;
        }
        .inv_title{
            text-align: center;
        }
        .empty_item{
            border: solid 1px;
            border-color: black;
            float: left;
        }
        #shop-inventory{
            border: solid 1px;
            border-color: blue;
        }
        .popup{
            position: absolute;
            display: none;
            background: #ccc;
            border: 1px solid;
            width: auto;
            height: auto;
            z-index: 3;
        }
    </style>
</head>
<body onload="onInit()">
    <?php include('../library/nav-bar.html'); ?>
    <div id="left-container"></div>
    <div id="main-container" class = "container center-text">
        <div id="shop-container">
            <div id="merchant-container">
                <img id="merchant-img" src="http://img2.wikia.nocookie.net/__cb20130204042403/bloodbrothersgame/images/9/93/Memesi,_Merchant_Figure.png">
            </div>
            <div id="shop-inventory">

            </div>
        </div>
    </div>
    <div id="right-container"></div>

    <div id="item_stat" class="popup" ></div>

    <div id="chatbar">
        <?php include('../library/chat-bar.html'); ?>
    </div>

    <script>
        var stats = [];

        jQuery.extend({
            getValues: function(url, method, data, type) {
                var result = null;
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    dataType: type,
                    //contentType: 'application/json',
                    async: false,
                    success: function(data) {
                        result = jQuery.parseJSON(data);
                    },
                    error: function(xhr){
                        console.log(xhr.responseText);
                        result = jQuery.parseJSON(xhr.responseText);
                    },
                });
                return result;
            }
        });

        function setUpShop(){
            var shop_items = $.getValues("get-shop.php", "GET", "", "application/x-www-form-urlencoded").shop_ary;
            var client_shop = $('#shop-inventory');

            //get the numebr of rows to display for items
            var rows = shop_items.length / 6;
            if((shop_items.length % 6) > 0){
                rows++;
            }

            //make sure rows is lowest integer value.
            rows = Math.floor(rows);

            //add rows to the client shop
            for(var i = 0; i < rows; i++){
                var new_row = document.createElement("DIV");
                new_row.id = 'row'+i;
                new_row.className += 'inv_row';
                client_shop.append(new_row);
            }

            //iterate through each row and populate with items; 6 per row
            client_shop.children().each(function(i){
                for(var j = 0; j < 6; j++){
                    var curr_item = shop_items[(i*6)+j];
                    if(curr_item != undefined){
                        var item_div = document.createElement('DIV');
                        item_div.className += "inv_item";

                        var item_img = document.createElement('IMG');
                        item_img.src = curr_item.base_img;
                        item_img.height = 100;
                        item_img.width = 100;
                        item_img.value = (i*6)+j;
                        item_img.name = curr_item.id;
                        item_img.label = curr_item.name;
                        item_img.price = curr_item.price;
                        $(item_img).attr('data-tooltip', "#item_stat");
                        $(item_div).append(item_img);

                        var item_title = document.createElement('P');
                        item_title.className += 'inv_title';
                        $(item_title).text(curr_item.name + ':' + curr_item.price);
                        $(item_div).append(item_title);

                        $(this).append(item_div);
                        stats.push(curr_item.stats);

                        $(item_img).hover(function(e){
                            var item_stat = $(this).data("tooltip");
                            var stat_height = 0;
                            for(var i = 0; i < stats[this.value].length; i++){
                                var stat_text = document.createElement('P');
                                $(stat_text).text(showStat(stats[this.value][i]));
                                $(item_stat).append(stat_text);
                                stat_height += 32; //magic number height of font
                            }

                            $(item_stat).css({
                                left: e.pageX + 1,
                                top: e.pageY + 1,
                                height: stat_height
                            }).stop().show(100);
                        }, function(){
                            $($(this).data("tooltip")).empty();
                            $($(this).data("tooltip")).hide();
                        });

                        $(item_img).click(function(e){
                            var data = "user_id=<?php echo $_SESSION['curr_id'];?>&item_id=" + this.name;
                            swal({
                                title: "Purchase",
                                text: "Are you sure you want to buy "+this.label+" for "+this.price+"?",
                                showCancelButton: true,
                                confirmButtonText: "Confirm",
                                closeOnConfirm: false
                            }, function(){
                                var res = $.getValues("get-shop.php", "POST", data, "application/x-www-form-urlencoded");
                                if(res.error.length != 0){
                                    var str = "";
                                    for(var i = 0; i < res.error.length; i++){
                                        str += res.error[i] + "\n";
                                    }
                                    swal({
                                        title: "Oops, something is wrong!",
                                        text: str
                                    });
                                } else {
                                    swal({
                                        title: "Got it!",
                                        text: "You bought " + res.bought
                                    });
                                }
                            });

                        });
                    } else{
                        var empty_div = document.createElement('DIV');
                        empty_div.className += "empty_item";

                        var empty_img = document.createElement('IMG');
                        empty_img.height = 100;
                        empty_img.width = 100;
                        $(empty_div).append(empty_img);

                        var empty_text = document.createElement('P');
                        empty_text.className += 'inv_title';
                        $(empty_text).text("Empty");
                        $(empty_div).append(empty_text);

                        $(this).append(empty_div);
                    }
                }
            });
        }

        function showStat(stats){
            if(stats.health != undefined){
                return "Health: " + stats.health;
            } else if(stats.armor != undefined){
                return "Armor: " + stats.armor;
            }
        }

        function onInit(){
            setUpShop();
        }
    </script>

</body>
</html>
