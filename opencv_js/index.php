CTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Video Capture Example</title>
<link href="js_example_style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="control"><button id="startAndStop" disabled>Start</button></div>
<textarea class="code" rows="29" cols="100" id="codeEditor" spellcheck="false">
</textarea>
</div>
<p class="err" id="errorMessage"></p>
<div>
    <table cellpadding="0" cellspacing="0" width="0" border="0">
    <tr>
        <td>
            <video hidden id="videoInput" width=320 height=240></video>
        </td>
        <td>
            <canvas id="canvasOutput" width=320 height=240></canvas>
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <div class="caption">videoInput</div>
        </td>
        <td>
            <div class="caption">canvasOutput</div>
        </td>
        <td></td>
        <td></td>
    </tr>
    </table>
</div>
<script src="https://webrtc.github.io/adapter/adapter-5.0.4.js" type="text/javascript"></script>
<script src="utils.js" type="text/javascript"></script>
<script id="codeSnippet" type="text/code-snippet">
let video = document.getElementById('videoInput');
let cap = new cv.VideoCapture(video);

let frame = new cv.Mat(video.height, video.width, cv.CV_8UC4);
let fgmask = new cv.Mat(video.height, video.width, cv.CV_8UC1);
let fgbg = new cv.BackgroundSubtractorMOG2(500, 16, true);

const FPS = 30;
function processVideo() {
    try {
        if (!streaming) {
            // clean and stop.
            frame.delete(); fgmask.delete(); fgbg.delete();
            return;
        }
        let begin = Date.now();
        // start processing.
        cap.read(frame);
        fgbg.apply(frame, fgmask, 0);
        cv.imshow('canvasOutput', fgmask);
        // schedule the next one.
        let delay = 1000/FPS - (Date.now() - begin);
        setTimeout(processVideo, delay);
    } catch (err) {
        utils.printError(err);
    }
};

// schedule the first one.
setTimeout(processVideo, 0);

</script>
<script type="text/javascript">
let utils = new Utils('errorMessage');

utils.loadCode('codeSnippet', 'codeEditor');

let streaming = false;
let videoInput = document.getElementById('videoInput');
let startAndStop = document.getElementById('startAndStop');
let canvasOutput = document.getElementById('canvasOutput');
let canvasContext = canvasOutput.getContext('2d');

startAndStop.addEventListener('click', () => {
    if (!streaming) {
        utils.clearError();
        utils.startCamera('qvga', onVideoStarted, 'videoInput');
    } else {
        utils.stopCamera();
        onVideoStopped();
    }
});

function onVideoStarted() {
    streaming = true;
    startAndStop.innerText = 'Stop';
    videoInput.width = videoInput.videoWidth;
    videoInput.height = videoInput.videoHeight;
    utils.executeCode('codeEditor');
}

function onVideoStopped() {
    streaming = false;
    canvasContext.clearRect(0, 0, canvasOutput.width, canvasOutput.height);
    startAndStop.innerText = 'Start';
}

utils.loadOpenCv(() => {
    startAndStop.removeAttribute('disabled');
});
</script>
</body>
</html>




