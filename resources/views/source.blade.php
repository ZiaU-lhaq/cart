<!-- Copyright Epic Games, Inc. All Rights Reserved. -->
<!DOCTYPE HTML>
<html>
<head>
	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
	<link rel="icon" type="image/png" sizes="96x96" href="/images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
	<link type="text/css" rel="stylesheet" href="player.css">
    <script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script type="text/javascript" src="scripts/webRtcPlayer.js"></script>
    <script type="text/javascript" src="scripts/app.js"></script>

	<meta name="facebook-domain-verification" content="se1hfp2bsf2vfh857rk9eohra3k225" />

</head>

<script type="application/javascript">
var myIp;
function getIP(json) {
	myIp = json.ip;
}
</script>
<script type="application/javascript" src="https://api.ipify.org?format=jsonp&callback=getIP"></script>

<script>

addResponseEventListener("handle_responses", myHandleResponseFunction);
var TName = '1';
var TID = '1';

function myHandleResponseFunction(data) {
    console.warn("Response received!");
    switch (data) {
        case "ReloadCart":
			ReloadCart();
			break;
		case "ReloadChat":
			ReloadChat();
			break;
		case "ReloadUpload":
			ReloadUpload();
			break;
		case "Check":
			Check();
			break;
		case "CSC":
			CSC();
			break;
		case "ShowIframe":
			ShowIframe();
			break;
		case "HideIframe":
			HideIframe();
			break;
		case "IP":
			IP();
			break;
		case "Kick":
			location.reload();
			break;
		case "SpaceRent":
			window.open("https://www.realm-verse.com/vendors");
			break;
    }
	const message = JSON.parse(data);
	if (message.Call = "StartCall"){
		const Name = message.Name;
		const ID = message.Id;
		StartCall(Name,ID);
	}
}

function Check() {
	let descriptor = {
		Check: true
	}
	emitUIInteraction(descriptor);
}

function CSC() {
	let descriptor = {
		CSC: false
	}
	emitUIInteraction(descriptor);
}

function IP() {
	let descriptor = {
		IP: myIp
	}
	emitUIInteraction(descriptor);
}

function ReloadCart() {
	const iframe = document.getElementById("shopping_iframe");
	iframe.src = "https://cart.realm-verse.com/cart";
}

function ReloadChat() {
	const iframe = document.getElementById("shopping_iframe");
	iframe.src = "https://staging.smartercallcenter.com/Chat/chat-box.php";
}

function ReloadUpload() {
	const iframe = document.getElementById("shopping_iframe");
	iframe.src = "https://cart.realm-verse.com/art_upload";
}

function ShowIframe() {
	overlay = document.getElementById('overlay');
    overlay.classList.add("overlay-shown");
}

function HideIframe() {
	overlay = document.getElementById('overlay');
    overlay.classList.remove("overlay-shown");
}

function StartCall(name,id) {
	TName = name;
	TID = id;
	const ciframe = document.getElementById("call_iframe");
	ciframe.src = "/call.html?name="+ name +"&id="+ id;
	document.getElementById("end_call").style.display = "block";
	document.getElementById("mute_call").style.display = "block";
	document.getElementById("unmute_call").style.display = "none";
}

function StopCall() {
	const ciframe = document.getElementById("call_iframe");
	ciframe.src = "/blank.html";
	document.getElementById("end_call").style.display = "none";
	document.getElementById("mute_call").style.display = "none";
	document.getElementById("unmute_call").style.display = "none";
}

function MuteCall() {
	const ciframe = document.getElementById("call_iframe");
	ciframe.src = "/blank.html";
	document.getElementById("end_call").style.display = "block";
	document.getElementById("mute_call").style.display = "none";
	document.getElementById("unmute_call").style.display = "block";
}

function UnMuteCall() {
	const ciframe = document.getElementById("call_iframe");
	ciframe.src = "/call.html?name="+ TName +"&id="+ TID;
	document.getElementById("end_call").style.display = "block";
	document.getElementById("mute_call").style.display = "block";
	document.getElementById("unmute_call").style.display = "none";
}

</script>

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '834399241116915');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=834399241116915&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<body onload="load()">
	<div id="text" class="server">Connecting to server ...</div>
	<div id="playerUI">
		<div id="player"></div>
		<div id="overlay" class="overlay text-light bg-dark">
			<div>
				<div id="overlayButton">+</div>
			</div>
			<div id="overlaySettings">
				<div id="fillWindow" style="display: none;">
					<div class="settings-text">Enlarge Display to Fill Window</div>
					<label class="tgl-switch">
						<input type="checkbox" id="enlarge-display-to-fill-window-tgl" class="tgl tgl-flat" checked>
						<div class="tgl-slider"></div>
					</label>
				</div>
				<div id="shopping">
					<iframe name="shopping_iframe" src="https://cart.realm-verse.com/cart" id="shopping_iframe" style="height:75vh;width:100%;background-color:white;" title="Realm-Verse Cart"></iframe>
				</div>
				<div id="call">
					<div name="mute_call" id="mute_call" style="display:none; width:100%;height:100%;">
						<button style="width:100%; height:100%; padding:2%; color:black; background-color:yellow; border:solid; border-radius:10px;" onclick="MuteCall();">Mute Call</button>
					</div>
					<div name="unmute_call" id="unmute_call" style="display:none; width:100%;height:100%;">
						<button style="width:100%; height:100%; padding:2%; color:black; background-color:green; border:solid; border-radius:10px;" onclick="UnMuteCall();">UnMute Call</button>
					</div>
					<div name="end_call" id="end_call" style="display:none; width:100%;height:100%;">
						<button style="width:100%; height:100%; padding:2%; color:white; background-color:red; border:solid; border-radius:10px;" onclick="StopCall();">End Call</button>
					</div>
					<iframe name="call_iframe" src="/blank.html" id="call_iframe" style="display:none; height:0vh; width:100%; border:none;"></iframe>
				</div>
			</div>
		</div>
	</div>
	<div id="loader"></div>
</body>
</html>

<script>
function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 2000);

    function checkReady() {
        if (document.getElementsByTagName('body')[0] !== undefined) {
            window.clearInterval(intervalID);
            callback.call(this);
        }
    }
}

function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
}

onReady(function () {
    show('playerUI', true);
    show('text', false);
	show('loader', false);
});
</script>
