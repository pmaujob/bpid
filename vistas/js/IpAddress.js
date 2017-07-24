
function getIp() {

    window.RTCPeerConecction = window.RTCPeerConecction || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
    var pc = new RTCPeerConnection({iceServers: []}), noop = function () {};
    pc.createDataChannel("");
    pc.createOffer(pc.setLocalDescription.bind(pc), noop);
    pc.onicecandidate = function (ice) {
        if (!ice || !ice.candidate || !ice.candidate.candidate)
            return;
        var myIp = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
        localStorage.setItem('ips', myIp);
        pc.onicecandidate = noop;
    }

}

function getIpAddress(){
    return localStorage.getItem('ips');
}
 