<!DOCTYPE html>
<html>
    <head>
        <title>Explore Map</title>
        <style>
            canvas{
                pointer-events: none;
                position: absolute;
            }
            .map-pull-left{
                float: left;
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

        <?php include('./library/nav-bar.html'); ?>
        <script src="library/imageMapResizer.js"></script>

        
        <div>
            <div class='map-pull-left'>
                <img src="resources/images/map.bmp"  alt="map" usemap="#mythic-map" id="map-image">
                <map class="mythic-map-obj" name="mythic-map">
                    <area shape="poly" coords="131,76,181,45,227,49,236,59,257,81,262,120,189,160,186,175,97,155,118,94" alt="bird-mtn" href="explore/bird-mtn">
                    <area shape="poly" coords="386,70,436,36,483,54,516,99,450,143,419,156,382,141,375,102,377,84" alt="ice-mtn" href="explore/ice-mtn">
                    <area shape="poly" coords="15,258,118,202,200,234,136,278,201,306,16,419" alt="farm" href="explore/farm">
                    <area shape="poly" coords="352,138,344,162,342,198,342,232,338,237,320,248,316,252,317,282,375,289,417,303,438,290,397,278,445,221,405,196,391,204,387,216,384,236,366,230,365,201,359,191,361,167" alt="swamp" href="explore/swamp">
                    <area shape="poly" coords="522,199,592,162,660,187,668,258,644,283,599,286,570,271,527,251,507,223" alt="mtn-city" href="explore/mtn-city">
                    <area shape="poly" coords="588,353,578,363,575,374,557,389,544,397,537,390,528,401,529,409,521,416,599,445,652,400,640,396,644,384,639,378,633,386,608,377,601,362" alt="dojo" href="explore/dojo">
                    <area shape="poly" coords="168,508,153,476,190,470,162,382,212,351,256,385,218,422,269,426,293,466,264,514,226,540" alt="low-land" href=".explore/low-lands">
                    <area shape="poly" coords="379,336,368,400,341,429,328,458,343,505,548,538,558,519,478,463,461,424,475,404,453,389,421,412,416,360,395,335" alt="plat" href="explore/plateau">
                    <area shape="poly" coords="567,6,679,9,679,153,584,134,639,115,590,94,618,73,544,47,578,19,567,16,530,27,528,8" alt="ocean" href="explore/ocean">
                </map>

            </div>
            <canvas id='myCanvas'></canvas>
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


            $('.mythic-map-obj area').hover(function(){
                myHover($(this));
            }, function(){
                myLeave($(this));
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
                //can.style.zIndex = 11;
                // place the canvas in front of the image
                img.style.zIndex = 0;
                can.style.zIndex = 2;

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
                $('map').imageMapResize();

                //there is currently a bug with chrome and safari that doesnt set webkit stuff instantly
                //so we use this work around so that it causes a 'tick' which will enable all the settings
                //this solution was found on stack overflow
                //http://stackoverflow.com/questions/3485365/how-can-i-force-webkit-to-redraw-repaint-to-propagate-style-changes
                $('map').style.display='none';
                $('map').offsetHeight;
                $('map').style.display='';
            });

            $( window ).resize(function() {
                myInit();
            });


        </script>
    </body>
	<div id="chatbar">
	  <?php include('./library/chat-bar.html'); ?>
	</div>
	
</html>
