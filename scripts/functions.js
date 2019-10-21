<script language="JavaScript" type="text/javascript">
//-----------------------------------------------------------------------------//
//	perloadImgs() - preloads images
//-----------------------------------------------------------------------------//
function preloadImgs(images)
{
	var i = 0;
	var imageArray = new Array();
	imageArray = images.split(',');
	for(i=0; i<=imageArray.length-1; i++)
	{	
		document.write('<div id="preload"><img src="' + imageArray[i] + '" height="0" width="0"/></div>');
	}
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	delimitArray() - generates array from string inputs (PHP to JS usage)
//-----------------------------------------------------------------------------//
function delimitArray(input,delimiter)
{
	var resultArray = input.split(delimiter);

	return resultArray;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	delimitMultiArray() - generates 2D array from string inputs (PHP to JS usage)
//-----------------------------------------------------------------------------//
function delimitMultiArray(input,delimiter,rowdelimiter)
{
	var resultArray = new Array();
	var recordArray = input.split(rowdelimiter);
	for(var i=0;i<recordArray.length;i++)
	{
		resultArray[i] = recordArray[i].split(delimiter);
	}
	return resultArray;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	tooltip (function set) - generates visual tooltips (Source: http://sixrevisions.com/tutorials/javascript_tutorial/create_lightweight_javascript_tooltip/)
//-----------------------------------------------------------------------------//

var tooltip=function()
{
	var id = 'tt';
	var top = 1;
	var left = 1;
	var maxw = 446;
	var speed = 15;
	var timer = 10;
	var endalpha = 90;
	var alpha = 0;
	var tt,t,c,b,h;
	var ie = document.all ? true : false
	
	//reversed tooltip variables
	var idr = 'ttr';
	var ttr,tr,cr,br,hr;
	var alphar = 0;
	
	//item specific variables
	var idi = 'ttitem';
	var tti,ti,ci,bi,hi;
	var alphai = 0;
	var idir = 'ttitemr';
	var ttir,tir,cir,bir,hir;
	var alphair = 0;
	
	//item specific variables - downwards
	var idid = 'ttitemd';
	var ttid,tid,cid,bid,hid;
	var alphaid = 0;
	var idird = 'ttitemrd';
	var ttird,tird,cird,bird,hird;
	var alphaird = 0;
	
	return{
		show:function(v,w){
			if(tt == null){
				tt = document.createElement('div');
				tt.setAttribute('id',id);
				t = document.createElement('div');
				t.setAttribute('id',id + 'top');
				c = document.createElement('div');
				c.setAttribute('id',id + 'cont');
				b = document.createElement('div');
				b.setAttribute('id',id + 'bot');
				tt.appendChild(t);
				tt.appendChild(c);
				tt.appendChild(b);
				document.body.appendChild(tt);
				tt.style.opacity = 0;
				tt.style.filter = 'alpha(opacity=0)';
				document.onmousemove = this.pos;
			}
			tt.style.display = 'block';
			while(v.indexOf("%39") > -1)
			{
					v = v.replace("%39","'");
			}
			c.innerHTML = v;
			tt.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				t.style.display = 'none';
				b.style.display = 'none';
				tt.style.width = tt.offsetWidth;
				t.style.display = 'block';
				b.style.display = 'block';
			}
			if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
			h = parseInt(tt.offsetHeight) + top;
			clearInterval(tt.timer);
			tt.timer = setInterval(function(){tooltip.fade(1)},timer);
		},
				
		pos:function(e){
			var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
			var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
			if(tt != null)
			{
				tt.style.top = (u - h) + 'px';
				tt.style.left = (l + left) + 'px';
			}
			if(ttr != null)
			{
				ttr.style.top = (u - hr) + 'px';
				ttr.style.left = (l - left - ttr.offsetWidth) + 'px';
			}
			if(tti != null)
			{
				tti.style.top = (u - hi) + 'px';
				tti.style.left = (l + left) + 'px';
			}
			if(ttir != null)
			{
				ttir.style.top = (u - hir) + 'px';
				ttir.style.left = (l - left - ttir.offsetWidth) + 'px';
			}
			if(ttid != null)
			{
				ttid.style.top = (u - hid + ttid.offsetHeight + 4) + 'px';
				ttid.style.left = (l + left ) + 'px';
			}
			if(ttird != null)
			{
				ttird.style.top = (u - hird + ttird.offsetHeight + 4) + 'px';
				ttird.style.left = (l - left - ttird.offsetWidth + 4) + 'px';
			}
		},
		
		fade:function(d){
			var a = alpha;
			if((a != endalpha && d == 1) || (a != 0 && d == -1)){
				var i = speed;
				if(endalpha - a < speed && d == 1){
					i = endalpha - a;
				}else if(alpha < speed && d == -1){
					i = a;
				}
				alpha = a + (i * d);
				tt.style.opacity = alpha * .01;
				tt.style.filter = 'alpha(opacity=' + alpha + ')';
			}
			else
			{
				clearInterval(tt.timer);
				if(d == -1){tt.style.display = 'none'}
			}
		},
		
		hide:function(){
			if(tt != null)
			{
				clearInterval(tt.timer);
				tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
			}
			if(ttr != null)
			{
				clearInterval(ttr.timer);
				ttr.timer = setInterval(function(){tooltip.fader(-1)},timer);
			}
			if(tti != null)
			{
				clearInterval(tti.timer);
				tti.timer = setInterval(function(){tooltip.fadei(-1)},timer);
			}
			if(ttir != null)
			{
				clearInterval(ttir.timer);
				ttir.timer = setInterval(function(){tooltip.fadeir(-1)},timer);
			}
			if(ttid != null)
			{
				clearInterval(ttid.timer);
				ttid.timer = setInterval(function(){tooltip.fadeid(-1)},timer);
			}
			if(ttird != null)
			{
				clearInterval(ttird.timer);
				ttird.timer = setInterval(function(){tooltip.fadeird(-1)},timer);
			}
		},
		
		//reversed tooltip
		showrev:function(v,w){
			if(ttr == null){
				ttr = document.createElement('div');
				ttr.setAttribute('id',idr);
				tr = document.createElement('div');
				tr.setAttribute('id',idr + 'top');
				cr = document.createElement('div');
				cr.setAttribute('id',idr + 'cont');
				br = document.createElement('div');
				br.setAttribute('id',idr + 'bot');
				ttr.appendChild(tr);
				ttr.appendChild(cr);
				ttr.appendChild(br);
				document.body.appendChild(ttr);
				ttr.style.opacity = 0;
				ttr.style.filter = 'alpha(opacity=0)';
				document.onmousemove = this.pos;
			}
			ttr.style.display = 'block';
			while(v.indexOf("%39") > -1)
			{
					v = v.replace("%39","'");
			}
			cr.innerHTML = v;
			ttr.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				tr.style.display = 'none';
				br.style.display = 'none';
				ttr.style.width = ttr.offsetWidth;
				tr.style.display = 'block';
				br.style.display = 'block';
			}
			if(ttr.offsetWidth > maxw){ttr.style.width = maxw + 'px'}
			hr = parseInt(ttr.offsetHeight) + top;
			clearInterval(ttr.timer);
			ttr.timer = setInterval(function(){tooltip.fader(1)},timer);
		},
		
		fader:function(dr){
			var ar = alphar;
			if((ar != endalpha && dr == 1) || (ar != 0 && dr == -1)){
				var ir = speed;
				if(endalpha - ar < speed && dr == 1){
					ir = endalpha - ar;
				}else if(alphair < speed && dr == -1){
					ir = ar;
				}
				alphar = ar + (ir * dr);
				ttr.style.opacity = alphar * .01;
				ttr.style.filter = 'alpha(opacity=' + alphar + ')';
			}
			else
			{
				clearInterval(ttr.timer);
				if(dr == -1){ttr.style.display = 'none'}
			}
		},
		
		//Items tooltip
		showitem:function(v,w){
			if(tti == null){
				tti = document.createElement('div');
				tti.setAttribute('id',idi);
				ti = document.createElement('div');
				ti.setAttribute('id',idi + 'top');
				ci = document.createElement('div');
				ci.setAttribute('id',idi + 'cont');
				bi = document.createElement('div');
				bi.setAttribute('id',idi + 'bot');
				tti.appendChild(ti);
				tti.appendChild(ci);
				tti.appendChild(bi);
				document.body.appendChild(tti);
				tti.style.opacity = 0;
				tti.style.filter = 'alpha(opacity=0)';
				document.onmousemove = this.pos;
			}
			tti.style.display = 'block';
			while(v.indexOf("%39") > -1)
			{
					v = v.replace("%39","'");
			}
			ci.innerHTML = v
			tti.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				ti.style.display = 'none';
				bi.style.display = 'none';
				tti.style.width = tti.offsetWidth;
				ti.style.display = 'block';
				bi.style.display = 'block';
			}
			if(tti.offsetWidth > maxw){tti.style.width = maxw + 'px'}
			hi = parseInt(tti.offsetHeight) + top;
			clearInterval(tti.timer);
			tti.timer = setInterval(function(){tooltip.fadei(1)},timer);
		},
		
		fadei:function(di){
			var ai = alphai;
			if((ai != endalpha && di == 1) || (ai != 0 && di == -1)){
				var ii = speed;
				if(endalpha - ai < speed && di == 1){
					ii = endalpha - ai;
				}else if(alphai < speed && di == -1){
					ii = ai;
				}
				alphai = ai + (ii * di);
				tti.style.opacity = alphai * .01;
				tti.style.filter = 'alpha(opacity=' + alphai + ')';
			}
			else
			{
				clearInterval(tti.timer);
				if(di == -1){tti.style.display = 'none'}
			}
		},
		
		//reversed Items tooltip
		showitemrev:function(v,w){
			if(ttir == null){
				ttir = document.createElement('div');
				ttir.setAttribute('id',idir);
				tir = document.createElement('div');
				tir.setAttribute('id',idir + 'top');
				cir = document.createElement('div');
				cir.setAttribute('id',idir + 'cont');
				bir = document.createElement('div');
				bir.setAttribute('id',idir + 'bot');
				ttir.appendChild(tir);
				ttir.appendChild(cir);
				ttir.appendChild(bir);
				document.body.appendChild(ttir);
				ttir.style.opacity = 0;
				ttir.style.filter = 'alpha(opacity=0)';
				document.onmousemove = this.pos;
			}
			ttir.style.display = 'block';
			while(v.indexOf("%39") > -1)
			{
					v = v.replace("%39","'");
			}
			cir.innerHTML = v;
			ttir.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				tir.style.display = 'none';
				bir.style.display = 'none';
				ttir.style.width = ttir.offsetWidth;
				tir.style.display = 'block';
				bir.style.display = 'block';
			}
			if(ttir.offsetWidth > maxw){ttir.style.width = maxw + 'px'}
			hir = parseInt(ttir.offsetHeight) + top;
			clearInterval(ttir.timer);
			ttir.timer = setInterval(function(){tooltip.fadeir(1)},timer);
		},
		
		fadeir:function(dir){
			var air = alphair;
			if((air != endalpha && dir == 1) || (air != 0 && dir == -1)){
				var iir = speed;
				if(endalpha - air < speed && dir == 1){
					iir = endalpha - air;
				}else if(alphair < speed && dir == -1){
					iir = air;
				}
				alphair = air + (iir * dir);
				ttir.style.opacity = alphair * .01;
				ttir.style.filter = 'alpha(opacity=' + alphair + ')';
			}
			else
			{
				clearInterval(ttir.timer);
				if(dir == -1){ttir.style.display = 'none'}
			}
		},
		
		//Items tooltip - downwards
		showitemd:function(v,w){
			if(ttid == null){
				ttid = document.createElement('div');
				ttid.setAttribute('id',idid);
				tid = document.createElement('div');
				tid.setAttribute('id',idid + 'top');
				cid = document.createElement('div');
				cid.setAttribute('id',idid + 'cont');
				bid = document.createElement('div');
				bid.setAttribute('id',idid + 'bot');
				ttid.appendChild(tid);
				ttid.appendChild(cid);
				ttid.appendChild(bid);
				document.body.appendChild(ttid);
				ttid.style.opacity = 0;
				ttid.style.filter = 'alpha(opacity=0)';
				document.onmousemove = this.pos;
			}
			ttid.style.display = 'block';
			while(v.indexOf("%39") > -1)
			{
					v = v.replace("%39","'");
			}
			cid.innerHTML = v
			ttid.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				tid.style.display = 'none';
				bid.style.display = 'none';
				ttid.style.width = ttid.offsetWidth;
				tid.style.display = 'block';
				bid.style.display = 'block';
			}
			if(ttid.offsetWidth > maxw){ttid.style.width = maxw + 'px'}
			hid = parseInt(ttid.offsetHeight) + top;
			clearInterval(ttid.timer);
			ttid.timer = setInterval(function(){tooltip.fadeid(1)},timer);
		},
		
		fadeid:function(did){
			var aid = alphaid;
			if((aid != endalpha && did == 1) || (aid != 0 && did == -1)){
				var iid = speed;
				if(endalpha - aid < speed && did == 1){
					iid = endalpha - aid;
				}else if(alphaid < speed && did == -1){
					iid = aid;
				}
				alphaid = aid + (iid * did);
				ttid.style.opacity = alphaid * .01;
				ttid.style.filter = 'alpha(opacity=' + alphaid + ')';
			}
			else
			{
				clearInterval(ttid.timer);
				if(did == -1){ttid.style.display = 'none'}
			}
		},
		
		//reversed Items tooltip - downwards
		showitemrevd:function(v,w){
			if(ttird == null){
				ttird = document.createElement('div');
				ttird.setAttribute('id',idird);
				tird = document.createElement('div');
				tird.setAttribute('id',idird + 'top');
				cird = document.createElement('div');
				cird.setAttribute('id',idird + 'cont');
				bird = document.createElement('div');
				bird.setAttribute('id',idird + 'bot');
				ttird.appendChild(tird);
				ttird.appendChild(cird);
				ttird.appendChild(bird);
				document.body.appendChild(ttird);
				ttird.style.opacity = 0;
				ttird.style.filter = 'alpha(opacity=0)';
				document.onmousemove = this.pos;
			}
			ttird.style.display = 'block';
			while(v.indexOf("%39") > -1)
			{
					v = v.replace("%39","'");
			}
			cird.innerHTML = v;
			ttird.style.width = w ? w + 'px' : 'auto';
			if(!w && ie){
				tird.style.display = 'none';
				bird.style.display = 'none';
				ttird.style.width = ttird.offsetWidth;
				tird.style.display = 'block';
				bird.style.display = 'block';
			}
			if(ttird.offsetWidth > maxw){ttird.style.width = maxw + 'px'}
			hird = parseInt(ttird.offsetHeight) + top;
			clearInterval(ttird.timer);
			ttird.timer = setInterval(function(){tooltip.fadeird(1)},timer);
		},
		
		fadeird:function(dird){
			var aird = alphaird;
			if((aird != endalpha && dird == 1) || (aird != 0 && dird == -1)){
				var iird = speed;
				if(endalpha - aird < speed && dird == 1){
					iird = endalpha - aird;
				}else if(alphair < speed && dird == -1){
					iird = aird;
				}
				alphaird = aird + (iird * dird);
				ttird.style.opacity = alphaird * .01;
				ttird.style.filter = 'alpha(opacity=' + alphaird + ')';
			}
			else
			{
				clearInterval(ttird.timer);
				if(dird == -1){ttird.style.display = 'none'}
			}
		}
	};
}();
</script>