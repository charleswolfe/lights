
if (document.images) {
	onpressed = new Image(); onpressed.src="./images/switch_on_pressed.png";
	offpressed = new Image(); offpressed.src="./images/switch_off_pressed.png";
	onup = new Image(); onup.src="./images/switch_on_up.png";
	offup = new Image(); offup.src="./images/switch_off_up.png";
} 

function switch_leds(json) {
	obj = JSON.parse(json);
        i =0;
        while(obj[i]) {
		document[obj[i].id+"led"].src='images/led_off.png';
                if (obj[i].state == 'i') {
                        document[obj[i].id+"led"].src='images/led_on.png';
                }
                i++;
        }
}

function switch_flipped(who) {
	var base_switch = who.substring(0,3);

	if (endsWith(who,'on')){
		console.log("turn on");

	$.ajax({ url: 'http://'+window.location.host+'/action.php',
         data: {cmd: 'set', switch:base_switch, pos: 'on'},
         type: 'post',
         success: function(output) {
			switch_leds(output);
                  }
		});
	} 
	if (endsWith(who,'off')){
        $.ajax({ url: 'http://'+window.location.host+'/action.php',
         data: {cmd: 'set', switch:base_switch, pos: 'off'},
         type: 'post',
         success: function(output) {
			switch_leds(output);
                  }
                });
        }
}


function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}


function change(picName,imgName)
{
	if (document.images) {
		imgOn=eval(imgName + ".src");
		document[picName].src= imgOn;
	}
} 

window.onload=function(){
	//Shopw status of lights when we first start page
	$.ajax({ url: 'http://'+window.location.host+'/action.php',
         data: {cmd: 'list'},
         type: 'post',
         success: function(output) {
                        switch_leds(output);
                  }
                });
};




