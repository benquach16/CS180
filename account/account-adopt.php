<?php session_start();
?>
<!doctype html>
<html>
<head>
    <title>Adopt Pet</title>
</head>
<body>

    <?php include('../library/nav-bar.html'); ?>

    <!-- we should check if pet party is full before allowing user to create a pet-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
    <link rel="stylesheet" href="../resources/css/modal-stylesheet.css">
    <style>
        .navbar{
            z-index: 3;
        }
        #pet-type-selection{
            z-index: 2;
            position: absolute;
        }
        .pet-btn{
            background: #383333;
            color: white;
        }
        .pet-btn:hover{
            background: black;
            color:red;
        }
        body{
            background: grey;
        }
        .trans3d
        {
            -webkit-transform-style: preserve-3d;
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform-style: preserve-3d;
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform-style:preserve-3d;
            -ms-transform: translate3d(0, 0, 0);
            transform-style:preserve-3d;
            transform: translate3d(0, 0, 0);

            /*-webkit-backface-visibility: hidden;
             -moz-backface-visibility: hidden;
             -ms-backface-visibility:hidden;
             backface-visibility:hidden;*/
        }

        #contentContainer
        {
            position:absolute;
            margin-left:-500px;
            margin-top:-500px;
            left:50%;
            top:50%;
            width:1000px;
            height:1000px;
            z-index: 1;
        }

        #carouselContainer
        {
            position:absolute;
            margin-left:-500px;
            margin-top:-500px;
            left:50%;
            top:50%;
            width:1000px;
            height:1000px;
        }

        .carouselItem
        {
            width:320px;
            height:230px;
            position:absolute;
            left:50%;
            top:50%;
            margin-left:-160px;
            margin-top:-90px;
            visibility:hidden;
        }

        .carouselItemInner
        {
            width:320px;
            height:320px;
            position:absolute;
            /*
            background-color:rgba(255, 255, 255, .75);
            border:10px solid rgba(255, 255, 255, .5);
            */
            color:aqua;
            font-size:72px;
            left:50%;
            top:50%;
            margin-left:-160px;
            margin-top:-90px;
            text-align:center;
            padding-top:0px;

        }

        .carouselItem:not(.active) > .carouselItemInner > img{
            opacity: 0.4;
        }

        .carouselItemInner img{
            position: relative;
        }

        #pet-type-selection .hover{
            background:black;
            color:white;
        }
        input[type="radio"] {
            vertical-align:middle;
        }

    </style>
    <header>
        <div id="pet-type-selection" class="btn-group btn-group-justified">
            <a id='dog-btn' type="button" class="btn btn-primary pet-btn" value="Dog">Dog</a>
            <a id='lion-btn' type="button" class="btn btn-primary pet-btn" value="Lion">Lion</a>
            <a id='bear-btn' type="button" class="btn btn-primary pet-btn" value="Bear">Bear</a>
            <a id='gorilla-btn' type="button" class="btn btn-primary pet-btn" value="Gorilla">Gorilla</a>
            <a id='raccoon-btn' type="button" class="btn btn-primary pet-btn" value="Racoon">Racoon</a>
            <a id='shark-btn' type="button" class="btn btn-primary pet-btn" value="Shark">Shark</a>
            <a id='bunny-btn' type="button" class="btn btn-primary pet-btn" value="Bunny">Bunny</a>
            <a id='lizard-btn' type="button" class="btn btn-primary pet-btn" value="Lizard">Lizard</a>
        </div>
    </header>

    <div id="contentContainer" class="trans3d">
        <section id="carouselContainer" class="trans3d">
            <figure id="item1" class="carouselItem trans3d active prev">
                <div class="carouselItemInner trans3d">
                    <img src="http://orig10.deviantart.net/7be3/f/2010/043/7/0/xfx_dog_the_warrior_by_7kive.jpg" alt="dog" width="300" height="300" >
                </div>
            </figure>
            <figure id="item2" class="carouselItem trans3d">
                <div class="carouselItemInner trans3d">
                    <img src="../resources/images/leo.png" alt="lion" width="300" height="300">
                </div>
            </figure>
            <figure id="item3" class="carouselItem trans3d">
                <div class="carouselItemInner trans3d">
                    <img src="https://s-media-cache-ak0.pinimg.com/736x/f5/88/41/f58841003c3c68289bcfc5e2f765bb4e.jpg" alt="bear" width="300" height="300">
                </div>
            </figure>
            <figure id="item4" class="carouselItem trans3d">
                <div class="carouselItemInner trans3d">
                    <img src="http://static.comicvine.com/uploads/scale_small/11/110802/3138840-six-gun+gorilla.jpg" alt="gorilla" width="300" height="300">
                </div>
            </figure>
            <figure id="item5" class="carouselItem trans3d">
                <div class="carouselItemInner trans3d">
                    <img src="http://orig02.deviantart.net/e650/f/2015/251/c/b/guardian_rocket_raccoon_portrait_art_by_cptcommunist-d98xbum.png" alt="raccoon" width="300" height="300">
                </div>
            </figure>
            <figure id="item6" class="carouselItem trans3d">
                <div class="carouselItemInner trans3d">
                    <img src="../resources/images/Sharknado.png" alt="shark" width="300" height="300">
                </div>
            </figure>
            <figure id="item7" class="carouselItem trans3d">
                <div class="carouselItemInner trans3d">
                    <img src="../resources/images/bunny_trans.gif" alt="bunny" width="300" height="300">
                </div>
            </figure>
            <figure id="item8" class="carouselItem trans3d">
                <div class="carouselItemInner trans3d">
                    <img src="/resources/images/gator.png" alt="lizard" width="300" height="300">
                </div>
            </figure>
        </section>
    </div>

    <!-- Modal -->
    <div id="adoptModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id='myModalLabel'>Adopt Pet</h4>
                </div>
                <div class="modal-body">
                    <div class='modal-body-inner'>
                        <div class="modal-left">
                            <form action='create-pet.php' method='POST' autocomplete="off" class="form-horizontal modal-cell" id='adopt-pet-form'>
                                <div class="form-group">
                                    <input type="hidden" name="pet-type" id="pet-type-input" />
                                    <div class='col-md-12' style="margin: auto; ">
                                        <input id='mod_user' class='form-control input-sm' type='text' name='pet-name' placeholder='Pet Name'/>
                                    </div>
                                    <div class='radio col-md-12'>
                                        <label for="gender_m" >
                                            <input id='gender_m' type='radio' name='gender' value="male"/>male
                                        </label>
                                    </div>
                                    <div class='radio col-md-12'>
                                        <label for="gender_f" >
                                            <input id='gender_f' type='radio' name='gender' value="female"/>female
                                        </label>
                                    </div>
                                </div>

                                <button id='adopt_submit' class=' mod-btn' type='submit' name='submit' value=false >Adopt</button>
                            </form>
                        </div>
                        <div class='mod-show-pet'>
                            <img src="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mod-btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        var w, container, carousel, item, radius, itemLength, rY, ticker, fps;
        var mouseX = 0;
        var mouseY = 0;
        var mouseZ = 0;
        var addX = 0;


        // fps counter created by: https://gist.github.com/sharkbrainguy/1156092,
        // no need to create my own :)
        var fps_counter = {

            tick: function ()
            {
                // this has to clone the array every tick so that
                // separate instances won't share state
                this.times = this.times.concat(+new Date());
                var seconds, times = this.times;

                if (times.length > this.span + 1)
                {
                    times.shift(); // ditch the oldest time
                    seconds = (times[times.length - 1] - times[0]) / 1000;
                    return Math.round(this.span / seconds);
                }
                else return null;
            },

            times: [],
            span: 20
        };
        var counter = Object.create(fps_counter);



        $(document).ready( init )

        function init()
        {
            w = $(window);
            container = $( '#contentContainer' );
            carousel = $( '#carouselContainer' );
            item = $( '.carouselItem' );
            itemLength = $( '.carouselItem' ).length;
            fps = $('#fps');
            rY = 360 / itemLength;
            radius = Math.round( (250) / Math.tan( Math.PI / itemLength ) );

            // set container 3d props
            TweenMax.set(container, {perspective:600})
            TweenMax.set(carousel, {z:-(radius)})

            // create carousel item props

            for ( var i = 0; i < itemLength; i++ )
            {
                var $item = item.eq(i);
                var $block = $item.find('.carouselItemInner');

                //thanks @chrisgannon!
                TweenMax.set($item, {rotationY:rY * i, z:radius, transformOrigin:"50% 50% " + -radius + "px"});

                animateIn( $item, $block )
            }

            // set mouse x and y props and looper ticker
            //window.addEventListener( "mousemove", onMouseMove, false );

            $('#dog-btn').on('mouseover', function(){
                btnCmd(1, this);
            });
            $('#lion-btn').on('mouseover', function(){
                btnCmd(2, this);
            });
            $('#bear-btn').on('mouseover', function(){
                btnCmd(3, this);
            });
            $('#gorilla-btn').on('mouseover', function(){
                btnCmd(4, this);
            });
            $('#raccoon-btn').on('mouseover', function(){
                btnCmd(5, this);
            });
            $('#shark-btn').on('mouseover', function(){
                btnCmd(6, this);
            });
            $('#bunny-btn').on('mouseover', function(){
                btnCmd(7, this);
            });
            $('#lizard-btn').on('mouseover', function(){
                btnCmd(8, this);
            });
            //ticker = setInterval( looper, 1000/60 );

        }

        function btnCmd($int, $obj){
            setActive($int);
            goImage($int);
            $("#pet-type-selection .hover").removeClass("hover");
            $($obj).addClass("hover");
        }

        function goImage($int){
            var rotation_incr = 360 / ($( '.carouselItem' ).length);
            var test_rot = -($int - 1)*rotation_incr;

            TweenMax.to( carousel, 1, { rotationY:test_rot , ease:Quint.easeOut } );

        }

        function setActive($val){
            var name = '#item' + $val;
            $('#carouselContainer .prev').removeClass('prev');
            $('#carouselContainer .active').addClass('prev');
            $('#carouselContainer .active').removeClass('active');
            $(name).addClass('active');
        }

        function animateIn( $item, $block )
        {
            var $nrX = 360 * getRandomInt(2);
            var $nrY = 360 * getRandomInt(2);

            var $nx = -(2000) + getRandomInt( 4000 );
            var $ny = -(2000) + getRandomInt( 4000 );
            var $nz = -4000 +  getRandomInt( 4000 );

            var $s = 1.5 + (getRandomInt( 10 ) * .1);
            var $d = 1 - (getRandomInt( 8 ) * .1);

            TweenMax.set( $item, { autoAlpha:1, delay:$d } );
            TweenMax.set( $block, { z:$nz, rotationY:$nrY, rotationX:$nrX, x:$nx, y:$ny, autoAlpha:0} );
            TweenMax.to( $block, $s, { delay:$d, rotationY:0, rotationX:0, z:0,  ease:Expo.easeInOut} );
            TweenMax.to( $block, $s-.5, { delay:$d, x:0, y:0, autoAlpha:1, ease:Expo.easeInOut} );
        }

        function getRandomInt( $n )
        {
            return Math.floor((Math.random()*$n)+1);
        }

        $('.pet-btn').on('click', function(){
            $('#adoptModal').modal('show');
            $('#myModalLabel').text("Adopt a " + $(this).attr("value"));
            $('#pet-type-input').attr('value', $(this).attr("value"));
            //console.log($(this).attr("value"));
        });
    </script>


</body>
</html>
