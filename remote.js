
if (document.images)
{
onpressed = new Image(); onpressed.src="../images/switch_on_pressed.png";
offpressed = new Image(); offpressed.src="../images/switch_off_pressed.png";
onup = new Image(); onup.src="../images/switch_on_up.png";
offup = new Image(); offup.src="../images/switch_off_up.png";
} 

var sw1off = document.getElementById('sw1off');
	sw1off.onclick = function (){switch_flipped("sw1off")}; 
var sw1on = document.getElementById('sw1on');
	sw1on.onclick = function (){switch_flipped("sw1on")}; 

var sw2off = document.getElementById('sw2off');
        sw2off.onclick = function (){switch_flipped("sw2off")};
var sw2on = document.getElementById('sw2on');
        sw2on.onclick = function (){switch_flipped("sw2on")};

 sw1off.state = 'off';
 sw1on.state = 'off';
 sw2off.state = 'off';
 sw2on.state = 'off';

    function switch_flipped(who) {
console.log("what:"+who+" ");

var base_switch = who.substring(0,3);

if (endsWith(who,'on')){
console.log("turn on");
	document[base_switch+"led"].src='images/led_on.png';
} 
if (endsWith(who,'off')){
console.log("ends off");
	document[base_switch+"led"].src='images/led_off.png';
}

    };

function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}


function change(picName,imgName)
{
if (document.images)
{
imgOn=eval(imgName + ".src");
document[picName].src= imgOn;
}
} 

//we need to know if we are now on, or now off
//we need to know what switch was chnaged  who



//we should call the backbone, tell it

//set colors from rpc return


