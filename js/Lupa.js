/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
function t(id)
{
	return document.getElementById(id);
}

function addEvent(obj,fun,type)
{
    if(obj.addEventListener)
    {
        obj.addEventListener(type,fun,false);
    }
    else 
    	if(obj.attachEvent)
    	{
        	var f=function()
        	{
            	fun.call(obj,window.event);
        	}
        obj.attachEvent('on'+type,f);
        obj[fun.toString()+type]=f;
    	}
    	else
    	{
        	obj['on'+type]=fun;
    	}
} 
function getPos(e)
{
    var ev=e || window.event;
    var obj=ev.target || ev.srcElement;
    obj.style.position='relative'; 
    posX=ev.layerX || ev.offsetX || 0;
    posY=ev.layerY || ev.offsetY || 0;
    return {x:posX,y:posY}
} 
function css(id,prop)
{
    if(window.getComputedStyle)
    {
        return document.defaultView.getComputedStyle(t(id),null).getPropertyValue(prop);
    }
    else
    {
        var re = /(-([a-z]){1})/g;
        if (prop == 'float') prop = 'styleFloat';
        	if (re.test(prop)) 
        	{
            	prop = prop.replace(re, function () 
            	{
                return arguments[2].toUpperCase();
            	});
       	 	}
        return t(id).currentStyle[prop] ? t(id).currentStyle[prop] : null;
    }
} 
function cambiar(pos,rel,e,a,a2,w,h)
{
    var al=parseInt(a);
    var al2=parseInt(a2);
    if(pos.x<(al/2)/rel)
        pos.x=(al/2)/rel;
    if(pos.y<(al2/2)/rel)
        pos.y=(al2/2)/rel;
    if(pos.x>(w)-(al/2)/rel)
        pos.x=(w)-(al/2)/rel;
    if(pos.y>(h)-(al2/2)/rel)
        pos.y=(h)-(al2/2)/rel;
    t('im').style.left=-(rel*pos.x)+(al/2)+'px';
    t('im').style.top=-(rel*pos.y)+(al2/2)+'px';
}

function Lupa()
{
    addEvent(
        t('im0'),
        function(e)
        {
            var al2=css('lupa','height');
            var al=css('lupa','width');
            var pos=getPos(e);
            cambiar(pos,(t('im').width)/this.width,e,al,al2,this.width,this.height);
        },
        'mousemove'
    );
}
