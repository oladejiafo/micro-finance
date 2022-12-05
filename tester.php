
 <script src="/codebase/js/top_menu.js?v=140529" type="text/javascript"></script>
        <script src="/codebase/js/dhtmlxcommon.js" type="text/javascript"></script>
        <script>
            //expand/collpase right side block
            function expandThisRightBlock(imgObj){
                if(imgObj.tagName=="DIV"){
                    imgObj = imgObj.getElementsByTagName("IMG")[1];
                }
                if(imgObj.src.indexOf("expand")!=-1){
                    imgObj.src = imgObj.src.replace("expand","collapse");
                    imgObj.alt = "Collapse Block";
                    imgObj.parentNode.parentNode.className = "bl_head_clear";
                    hideContentNextTo(imgObj.parentNode.parentNode,false)
                }else{
                    imgObj.src = imgObj.src.replace("collapse","expand");
                    imgObj.alt = "Expand Block";
                    imgObj.parentNode.parentNode.className = "bl_head_clear_c";
                    hideContentNextTo(imgObj.parentNode.parentNode,true)
                }
            }
            function hideContentNextTo(divObj,hideFl){
                if(hideFl)
                    var displayVal = "none"
                else
                    var displayVal = ""
                var chNodes = divObj.parentNode.childNodes;
                for(var i=0;i<chNodes.length;i++){
                    if(chNodes[i]!=divObj && chNodes[i].tagName)
                        chNodes[i].style.display = displayVal;
                }
            }

            function getFlashMovieObject(movieName)
            {
              if (window.document[movieName])
              {
                  return window.document[movieName];
              }
              if (navigator.appName.indexOf("Microsoft Internet")==-1)
              {
                if (document.embeds && document.embeds[movieName])
                  return document.embeds[movieName];
              }
              else // if (navigator.appName.indexOf("Microsoft Internet")!=-1)
              {
                return document.getElementById(movieName);
              }
            }
            function StopFlashMovie(movieName)
            {
                var flashMovie=getFlashMovieObject(movieName);
                flashMovie.StopPlay();
            }

            function PlayFlashMovie(movieName)
            {
                var flashMovie=getFlashMovieObject(movieName);
                flashMovie.Play();
                //embed.nativeProperty.anotherNativeMethod();
            }

            function RewindFlashMovie(movieName)
            {
                var flashMovie=getFlashMovieObject(movieName);
                flashMovie.Rewind();
            }
            //use the folloeing sytax to use mailto in href: href="javascript:void(dxmail('sales','Get evaluation version'))"
            function dhxmail(name,subj){
                return window.open('mailto:'+name+'@dhtmlx.com?subject='+subj,'_self')
            }
            function dhxmail_html(name,subj){
                var a = "<a href=\"";
                a+="mailto:"+name+"@dhtmlx.com?subject="+subj;
                a+="\">"+name+"@dhtmlx.com</a>";
                return a;
            }
        </script>
        <script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-11031269-1']);
		  _gaq.push(['_setDomainName', 'dhtmlx.com']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>

<link rel="stylesheet" type="text/css" href="http://apps.dhtmlx.com/060514/codebase/dhtmlx.css"> 
<script src="http://apps.dhtmlx.com/060514/codebase/dhtmlx.js"></script> 
<script>
function jr()
{
myCalendar=new dhtmlXCalendarObject(["fromdate","todate"]);
myCalendar.setDateFormat("%d/%m/%y");
myCalendar.hideTime();
myCalendarRem=new dhtmlXCalendarObject("reminder");
myCalendarRem.setDateFormat("%d/%m/%y %H:%i");
var d=new Date();
d.setDate(1);
//document.getElementById("fromdate").value=myCalendar.Ul(null,d);
d.setDate(14);
//document.getElementById("todate").value=myCalendar.Ul(null,d);
d.setDate(1);
d.setHours(10);
d.setMinutes(0);
document.getElementById("reminder").value=myCalendarRem.Ul(null,d);
};

function setSens(inputId,mezh)
{
if(mezh=="min")
{
myCalendar.setSensitiveRange(document.getElementById(inputId).value,null);
}else{
myCalendar.setSensitiveRange(null,document.getElementById(inputId).value);
}
};
dhtmlxEvent(window,"load",jr);
</script> 

