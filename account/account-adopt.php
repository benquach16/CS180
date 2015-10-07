<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 10/6/2015
 * Time: 9:38 PM
 */
?>
<!doctype html>
<html>
<head>
    <title>Account Info</title>
</head>
<body>

    <?php include('../library/nav-bar.html'); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/umd/carousel.js"></script>
    <style>
        .pet-btn{
            background: #383333;
            color: white;
        }
        .pet-btn:hover{
            background: black;
            color:red;
        }
        #pet-carousel, .carousel-inner .item{
            height:300px;
            width: 300px;
            margin: 0 auto;
        }
        .carousel-inner > .item > img{
            margin: 0 auto;
        }
        .carousel {padding: 5px;}
        .carousel-indicators li { visibility: hidden; }

        #pet-type-selection .hover{
            background:black;
            color:red;
        }
    </style>

    <div class="main-container">
        <div id="pet-type-selection" class="btn-group btn-group-justified">
            <a id='dog-btn' type="button" class="btn btn-primary pet-btn">Dog</a>
            <a id='tiger-btn' type="button" class="btn btn-primary pet-btn">Tiger</a>
            <a id='bear-btn' type="button" class="btn btn-primary pet-btn">Bear</a>
            <a id='gorilla-btn' type="button" class="btn btn-primary pet-btn">Gorilla</a>
            <a id='raccoon-btn' type="button" class="btn btn-primary pet-btn">Racoon</a>
            <a id='shark-btn' type="button" class="btn btn-primary pet-btn">Shark</a>
            <a id='falcon-btn' type="button" class="btn btn-primary pet-btn">Falcon</a>
        </div>

        <div id="pet-type-display">
            <div id="pet-carousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li class="item1 active"></li>
                    <li class="item2"></li>
                    <li class="item3"></li>
                    <li class="item4"></li>
                    <li class="item5"></li>
                    <li class="item6"></li>
                    <li class="item7"></li>
                </ol>

                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="http://orig10.deviantart.net/7be3/f/2010/043/7/0/xfx_dog_the_warrior_by_7kive.jpg" alt="dog" width="300" height="300" >
                    </div>
                    <div class="item">
                        <img src="http://orig05.deviantart.net/7248/f/2012/350/2/3/scifi_tiger_warrior_by_thenoremac42-d5o8arl.jpg" alt="tiger" width="300" height="300">
                    </div>
                    <div class="item">
                        <img src="https://s-media-cache-ak0.pinimg.com/736x/f5/88/41/f58841003c3c68289bcfc5e2f765bb4e.jpg" alt="bear" width="300" height="300">
                    </div>
                    <div class="item">
                        <img src="http://static.comicvine.com/uploads/scale_small/11/110802/3138840-six-gun+gorilla.jpg" alt="gorilla" width="300" height="300">
                    </div>
                    <div class="item">
                        <img src="http://orig02.deviantart.net/e650/f/2015/251/c/b/guardian_rocket_raccoon_portrait_art_by_cptcommunist-d98xbum.png" alt="raccoon" width="300" height="300">
                    </div>
                    <div class="item">
                        <img src="http://laughingsquid.com/wp-content/uploads/jawesome_by_mikecorriero-d5wqypd.jpg" alt="shark" width="300" height="300">
                    </div>
                    <div class="item">
                        <img src="http://geekin-out.com/wp-content/uploads/2012/02/Eagle_Warrior_by_GabrielRodriguez.jpg" alt="falcon" width="300" height="300">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#pet-carousel").carousel("pause");

            $(".item1").click(function(){
                $("#pet-carousel").carousel(0);
            });
            $(".item2").click(function(){
                $("#pet-carousel").carousel(1);
            });
            $(".item3").click(function(){
                $("#pet-carousel").carousel(2);
            });
            $(".item4").click(function(){
                $("#pet-carousel").carousel(3);
            });
            $(".item5").click(function(){
                $("#pet-carousel").carousel(4);
            });
            $(".item6").click(function(){
                $("#pet-carousel").carousel(5);
            });
            $(".item7").click(function(){
                $("#pet-carousel").carousel(6);
            });
        });

        function updateHover(val, obj){
            $("#pet-carousel").carousel(val);
            $("#pet-carousel").carousel("pause");
            $("#pet-type-selection .hover").removeClass("hover");
            $(obj).addClass("hover");
        };

        $('#dog-btn').on('mouseover',function(){
            updateHover(0, this);
        });

        $('#tiger-btn').on('mouseover', function(){
            updateHover(1, this);
        });

        $('#bear-btn').on('mouseover', function(){
            updateHover(2, this);
        });

        $('#gorilla-btn').on('mouseover', function(){
            updateHover(3, this);
        });

        $('#raccoon-btn').on('mouseover', function(){
            updateHover(4, this);
        });

        $('#shark-btn').on('mouseover', function(){
            updateHover(5, this);
        });

        $('#falcon-btn').on('mouseover', function(){
            updateHover(6, this);
        });
    </script>

</body>
</html>
