<!DOCTYPE html>
<html>
    <head>
        <title>Explore Map</title>
        <style>
            canvas
            {
                pointer-events: none;
                position: absolute;
            }
            .map-pull-left{
                float: left;
            }
            .map-pull-right{
                overflow: hidden;
            }
            #hover-loc-name{
                text-align: center;
            }
            #map-image{
                min-height:100%;
                min-width:100%;
                height:auto;
                width:auto;
                position:absolute;
                margin:auto;
            }
        </style>
    </head>
    
    <body onload='myInit()'>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <script src="library/imageMapResizer.min.js"></script>
        <?php include('./library/nav-bar.html'); ?>
        
        <div>
            <div class='map-pull-left'>
                <img src="./resources/images/map.bmp"  alt="map" usemap="#mythic-map" id="map-image">
                <canvas id='myCanvas'></canvas>
                <map class="mythic-map-obj" name="mythic-map">
                    <area shape="poly" coords="131,76,181,45,227,49,236,59,257,81,262,120,189,160,186,175,97,155,118,94" alt="bird-mtn" href="./explore/bird-mtn.php">
                    <area shape="poly" coords="386,70,436,36,483,54,516,99,450,143,419,156,382,141,375,102,377,84" alt="ice-mtn" href="./explore/ice.php">
                    <area shape="poly" coords="15,258,118,202,200,234,136,278,201,306,16,419" alt="farm" href="./explore/farm.php">
                    <area shape="poly" coords="352,138,344,162,342,198,342,232,338,237,320,248,316,252,317,282,375,289,417,303,438,290,397,278,445,221,405,196,391,204,387,216,384,236,366,230,365,201,359,191,361,167" alt="swamp" href="./explore/swamp-tower.php">
                    <area shape="poly" coords="522,199,592,162,660,187,668,258,644,283,599,286,570,271,527,251,507,223" alt="mtn-city" href="./explore/right-mtn.php">
                    <area shape="poly" coords="588,353,578,363,575,374,557,389,544,397,537,390,528,401,529,409,521,416,599,445,652,400,640,396,644,384,639,378,633,386,608,377,601,362" alt="dojo" href="./explore/pagoda.php">
                    <area shape="poly" coords="168,508,153,476,190,470,162,382,212,351,256,385,218,422,269,426,293,466,264,514,226,540" alt="low-land" href=".explore/low-river.php">
                    <area shape="poly" coords="379,336,368,400,341,429,328,458,343,505,548,538,558,519,478,463,461,424,475,404,453,389,421,412,416,360,395,335" alt="plat" href="./explore/plateau.php">
                    <area shape="poly" coords="567,6,679,9,679,153,584,134,639,115,590,94,618,73,544,47,578,19,567,16,530,27,528,8" alt="ocean" href="./explore/ocean.php">
                </map>
            </div>
            <div class='map-pull-right'>
                <img id='hover-loc-name' src='' />
            </div>
        </div>
        
        
        <script>
            var hdc;

            function byId(e){return document.getElementById(e);}

            function drawPoly(coOrdStr){
                var mCoords = coOrdStr.split(',');
                var i, n;
                n = mCoords.length;

                hdc.beginPath();
                hdc.moveTo(mCoords[0], mCoords[1]);
                for (i=2; i<n; i+=2)
                {
                    hdc.lineTo(mCoords[i], mCoords[i+1]);
                }
                hdc.lineTo(mCoords[0], mCoords[1]);
                hdc.fill();
                hdc.stroke();
            }

            function drawRect(coOrdStr){
                var mCoords = coOrdStr.split(',');
                var top, left, bot, right;
                left = mCoords[0];
                top = mCoords[1];
                right = mCoords[2];
                bot = mCoords[3];
                hdc.strokeRect(left,top,right-left,bot-top); 
            }

            function populateTitle(element){
                var title = element.attr('alt');
                var banner = getBanner(title);
                $('#hover-loc-name').attr('src',banner);
            }

            function getBanner(title){
                switch(title){
                    case 'bird-mtn':
                        return './resources/images/banner-birdmtn.jpg';
                    case 'ice-mtn':
                        return './resources/images/banner-icemtn.jpg';
                    case 'farm':
                        return './resources/images/banner-farm.jpg';
                    case 'swamp':
                        return './resources/images/banner-swamp.jpg';
                    case 'mtn-city':
                        return './resources/images/banner-mtncity.jpg';
                    case 'dojo':
                        return './resources/images/banner-dojo.jpg';
                    case 'low-land':
                        return './resources/images/banner-lowland.jpg';
                    case 'plat':
                        return './resources/images/banner-plateaus.jpg';
                    case 'ocean':
                        return './resources/images/banner-ocean.jpg';
                }
            }

            $('.mythic-map-obj area').hover(function(){
                myHover($(this));
                populateTitle($(this));
            }, function(){
                myLeave($(this));
                $('#hover-loc-name').attr('src','./resources/images/banner-explore.jpg');
            });

            function myHover(element){
                var hoveredElement = element;
                var coordStr = element.attr('coords');
                var areaType = element.attr('shape');
                
                switch (areaType)
                {
                    case 'circle':
                    case 'poly':
                        drawPoly(coordStr);
                        break;
                    case 'rect':
                        drawRect(coordStr);
                        break;
                    default:
                        break;
                }
            }

            function myLeave(){
                var canvas = byId('myCanvas');
                hdc.clearRect(0, 0, canvas.width, canvas.height);
            }

            function myInit(){
                // get the target image
                var img = byId('map-image');

                var x,y, w,h;

                // get it's position and width+height
                x = img.offsetLeft;
                y = img.offsetTop;
                w = img.clientWidth;
                h = img.clientHeight;

                // move the canvas, so it's contained by the same parent as the image
                var imgParent = img.parentNode;
                var can = byId('myCanvas');
                imgParent.appendChild(can);

                // place the canvas in front of the image
                can.style.zIndex = 1;

                // position it over the image
                can.style.left = x+'px';
                can.style.top = y+'px';

                // make same size as the image
                can.setAttribute('width', w+'px');
                can.setAttribute('height', h+'px');

                // get it's context
                hdc = can.getContext('2d');

                // set the 'default' values for the colour/width of fill/stroke operations
                hdc.fillStyle = 'rgba(255, 255, 255, 0.3)';
                hdc.strokeStyle = 'rgba(255, 255, 255, 0.5)';
                hdc.lineWidth = 2;
            }
            
            $(function(){
                $('#hover-loc-name').attr('src','./resources/images/banner-explore.jpg');
                $('map').imageMapResize();
            });

            $( window ).resize(function() {
                myInit();
            });


        </script>
    </body>
</html>
