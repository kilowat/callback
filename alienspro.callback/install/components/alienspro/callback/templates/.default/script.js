/****************************PHONE MASK PLUGIN**********************************/
(function(e){function t(){var e=document.createElement("input"),t="onpaste";return e.setAttribute(t,""),"function"==typeof e[t]?"paste":"input"}var n,a=t()+".mask",r=navigator.userAgent,i=/iphone/i.test(r),o=/android/i.test(r);e.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},dataName:"rawMaskFn",placeholder:"_"},e.fn.extend({caret:function(e,t){var n;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof e?(t="number"==typeof t?t:e,this.each(function(){this.setSelectionRange?this.setSelectionRange(e,t):this.createTextRange&&(n=this.createTextRange(),n.collapse(!0),n.moveEnd("character",t),n.moveStart("character",e),n.select())})):(this[0].setSelectionRange?(e=this[0].selectionStart,t=this[0].selectionEnd):document.selection&&document.selection.createRange&&(n=document.selection.createRange(),e=0-n.duplicate().moveStart("character",-1e5),t=e+n.text.length),{begin:e,end:t})},unmask:function(){return this.trigger("unmask")},mask:function(t,r){var c,l,s,u,f,h;return!t&&this.length>0?(c=e(this[0]),c.data(e.mask.dataName)()):(r=e.extend({placeholder:e.mask.placeholder,completed:null},r),l=e.mask.definitions,s=[],u=h=t.length,f=null,e.each(t.split(""),function(e,t){"?"==t?(h--,u=e):l[t]?(s.push(RegExp(l[t])),null===f&&(f=s.length-1)):s.push(null)}),this.trigger("unmask").each(function(){function c(e){for(;h>++e&&!s[e];);return e}function d(e){for(;--e>=0&&!s[e];);return e}function m(e,t){var n,a;if(!(0>e)){for(n=e,a=c(t);h>n;n++)if(s[n]){if(!(h>a&&s[n].test(R[a])))break;R[n]=R[a],R[a]=r.placeholder,a=c(a)}b(),x.caret(Math.max(f,e))}}function p(e){var t,n,a,i;for(t=e,n=r.placeholder;h>t;t++)if(s[t]){if(a=c(t),i=R[t],R[t]=n,!(h>a&&s[a].test(i)))break;n=i}}function g(e){var t,n,a,r=e.which;8===r||46===r||i&&127===r?(t=x.caret(),n=t.begin,a=t.end,0===a-n&&(n=46!==r?d(n):a=c(n-1),a=46===r?c(a):a),k(n,a),m(n,a-1),e.preventDefault()):27==r&&(x.val(S),x.caret(0,y()),e.preventDefault())}function v(t){var n,a,i,l=t.which,u=x.caret();t.ctrlKey||t.altKey||t.metaKey||32>l||l&&(0!==u.end-u.begin&&(k(u.begin,u.end),m(u.begin,u.end-1)),n=c(u.begin-1),h>n&&(a=String.fromCharCode(l),s[n].test(a)&&(p(n),R[n]=a,b(),i=c(n),o?setTimeout(e.proxy(e.fn.caret,x,i),0):x.caret(i),r.completed&&i>=h&&r.completed.call(x))),t.preventDefault())}function k(e,t){var n;for(n=e;t>n&&h>n;n++)s[n]&&(R[n]=r.placeholder)}function b(){x.val(R.join(""))}function y(e){var t,n,a=x.val(),i=-1;for(t=0,pos=0;h>t;t++)if(s[t]){for(R[t]=r.placeholder;pos++<a.length;)if(n=a.charAt(pos-1),s[t].test(n)){R[t]=n,i=t;break}if(pos>a.length)break}else R[t]===a.charAt(pos)&&t!==u&&(pos++,i=t);return e?b():u>i+1?(x.val(""),k(0,h)):(b(),x.val(x.val().substring(0,i+1))),u?t:f}var x=e(this),R=e.map(t.split(""),function(e){return"?"!=e?l[e]?r.placeholder:e:void 0}),S=x.val();x.data(e.mask.dataName,function(){return e.map(R,function(e,t){return s[t]&&e!=r.placeholder?e:null}).join("")}),x.attr("readonly")||x.one("unmask",function(){x.unbind(".mask").removeData(e.mask.dataName)}).bind("focus.mask",function(){clearTimeout(n);var e;S=x.val(),e=y(),n=setTimeout(function(){b(),e==t.length?x.caret(0,e):x.caret(e)},10)}).bind("blur.mask",function(){y(),x.val()!=S&&x.change()}).bind("keydown.mask",g).bind("keypress.mask",v).bind(a,function(){setTimeout(function(){var e=y(!0);x.caret(e),r.completed&&e==x.val().length&&r.completed.call(x)},0)}),y()}))}})})(jQuery);
/*********************************************************************************/
var alienspro_callback = function(lang){
	var clock=function(){
		var canvas, ctx;
		var clockRadius = 80;
		var clockImage;

		function clear() { 
		    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
		}

		function drawScene() { 
		    clear(); 
	
		    var date = new Date();
		    var hours = date.getHours();
		    var minutes = date.getMinutes();
		    var seconds = date.getSeconds();
		    hours = hours > 12 ? hours - 12 : hours;
		    var hour = hours + minutes / 60;
		    var minute = minutes + seconds / 60;
		
		    ctx.save();
		  
		    ctx.drawImage(clockImage, 0, 0, 160, 160);

		    ctx.translate(canvas.width / 2, canvas.height / 2);
		    ctx.beginPath();
  
		    ctx.font = '14px Arial';
		    ctx.fillStyle = '#003768';
		    ctx.textAlign = 'center';
		    ctx.textBaseline = 'middle';
		    for (var n = 1; n <= 12; n++) {
		        var theta = (n - 3) * (Math.PI * 2) / 12;
		        var x = clockRadius * 0.7 * Math.cos(theta);
		        var y = clockRadius * 0.7 * Math.sin(theta);
		        ctx.fillText(n, x, y);
		    }

		    ctx.save();
		    var theta = (hour - 3) * 2 * Math.PI / 12;
		    ctx.rotate(theta);
		    ctx.beginPath();
		    ctx.moveTo(-15, -5);
		    ctx.lineTo(-15, 5);
		    ctx.lineTo(clockRadius * 0.5, 1);
		    ctx.lineTo(clockRadius * 0.5, -1);
		    ctx.fill();
		    ctx.restore();

		    ctx.save();
		    var theta = (minute - 15) * 2 * Math.PI / 60;
		    ctx.rotate(theta);
		    ctx.beginPath();
		    ctx.moveTo(-15, -4);
		    ctx.lineTo(-15, 4);
		    ctx.lineTo(clockRadius * 0.8, 1);
		    ctx.lineTo(clockRadius * 0.8, -1);
		    ctx.fill();
		    ctx.restore();

		    ctx.save();
		    var theta = (seconds - 15) * 2 * Math.PI / 60;
		    ctx.rotate(theta);
		    ctx.beginPath();
		    ctx.moveTo(-15, -3);
		    ctx.lineTo(-15, 3);
		    ctx.lineTo(clockRadius * 0.9, 1);
		    ctx.lineTo(clockRadius * 0.9, -1);
		    ctx.fillStyle = '#003768';
		    ctx.fill();
		    ctx.restore();

		    ctx.restore();
		}
		
		    canvas = document.getElementById('canvas');
		    ctx = canvas.getContext('2d');

		clockImage = new Image();
		clockImage.src = '/bitrix/components/alienspro/callback/templates/.default/images/cface.png';
		drawScene();
		    setInterval(drawScene, 1000); 
		
	};

	var date = new Date();
	var currentTimeZoneOffsetInHours = "GMT+"+-date.getTimezoneOffset()/60;	
	$('.ui-dialog').wrap('<div class="abc" />');

	var dialog = $('#callback-block').dialog({
		autoOpen: false,
	    height: 'auto',
	    width: 350,
	    modal: true,
	    title:lang.title,
	    draggable: false,
	    resizable: false,
	    close: function(event, ui){
		        $(".alienspro-callback").filter(function(){
		            if ($(this).text() == "")
		            {
		                return true;
		            }
		            return false;
		        }).remove();

		     	$.each($('#callback-block input'),function(key,value){
		    			$(value).removeClass('req');
		    	});
		}, 
	    create: function(event, ui){
        	$('.ui-dialog').wrap('<div class="alienspro-callback" />');
		},
		open: function(event, ui){
		    $('.ui-widget-overlay').wrap('<div class="alienspro-callback" />');
		    clock();
		},
	});
	form = dialog.find( "form" ).on( "submit", function( event ) {
		
	    event.preventDefault();
	    $('.send-button').attr("disabled", true);
	    
	    $.ajax({
	    	method:'post',
	    	data:{
	    		user_name:$('#user_name').val(),
	    		user_phone:$('#user_phone').val(),
	    		user_email:$('#user_email').val(),
	    		user_theme:$('#user_theme').val(),
	    		user_time:$('#time-after').text()+'-'+$('#time-before').text()+' '+currentTimeZoneOffsetInHours,
	    		PARAMS_HASH:$('#PARAMS_HASH').val(),
	    		captcha_sid:$('#captcha_sid').val(),
	    		captcha_word:$('#captcha_word').val(),
	    		sessid:$('#sessid').val(),
	    		ajax:'y',
	    	},
	    	success:function(msg){
	    		$('.send-button').attr("disabled", false);

	    		var err = (JSON.parse(msg));
	    		
	    		if(err.success=='no'){
		    		$.each($('#callback-block input'),function(key,value){
		    			$(value).removeClass('req');
		    		});
		    		$.each(err,function(key,value){		
		    			if(value==true){	
		    				$('#'+key).addClass('req');
		    			}
		    		});
					captchaload();
		    	}else{
		    		var msgNodes='';   
		    		msgNodes += '<div id="dialog-message">';
					msgNodes +=		'<p class="success-msg">'+err.success+'</p>';
					msgNodes +=	'</div>';
		    		dialog.dialog("close");
		    		    $( msgNodes).dialog({
					      modal: true,
					      title:lang.title,
					      draggable: false,
	   					  resizable: false,
					      close: function(event, ui){
						        $(".alienspro-callback").filter(function(){
						            if ($(this).text() == "")
						            {
						                return true;
						            }
						            return false;
						        }).remove();
								$.each($('#callback-block input'),function(key,value){
			    					$(value).removeClass('req');
			    				});
							},
 
						    create: function(event, ui){
					        	$('.ui-dialog').wrap('<div class="alienspro-callback" />');
							},
							open: function(event, ui){
							    $('.ui-widget-overlay').wrap('<div class="alienspro-callback" />');
							},
						      buttons: {
						        Ok: function() {
						          $( this ).dialog( "close" );
						        }
						      }
					    });
		    	}
	    	}
	    })
	});

	$('#open-btn').click(function(){
		dialog.dialog( "open" );
	});

	$('#reload-captcha').click(function(){
		captchaload()
	});
	
	function captchaload(){
				$.ajax({
			method:'POST',
			data:{reload_captcha:'y'},
			success:function(msg){
				$('#captcha_sid').val(msg);
				$('#captcha_img').attr('src','/bitrix/tools/captcha.php?captcha_sid='+msg)
			}
		});
	}
};





