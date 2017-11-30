<html>
<head>
    <script src="GCF.js"></script>
</head>
<body>
    <input type="file" accept="image/*" capture="camera">
    <input type="file" accept="video/*" capture="camera">
    <div id="camera"></div>
    <div id="photo" style="margin-top: 100px; margin-left: 100px;">
        <h1>Заголовок</h1>
    </div>

    <script>
        if (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices) {
            navigator.enumerateDevices = function(callback) {
                navigator.mediaDevices.enumerateDevices().then(callback);
            };
        }

        if (!navigator.enumerateDevices && window.MediaStreamTrack && window.MediaStreamTrack.getSources) {
            navigator.enumerateDevices = window.MediaStreamTrack.getSources.bind(window.MediaStreamTrack);
        }

        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

        var camers = [];
        navigator.enumerateDevices(function(devices) {
            devices.forEach(function(device) {
                if (device.kind == 'videoinput') {
                    camers.push(device.deviceId);
                }
            });
        });

        camera = document.getElementById('camera');
        function getVideo(id) {
            if (window.stream) {
                camera.src = null;
                window.stream.getTracks()[0].stop();
            }
            if (navigator.getUserMedia) {
                navigator.getUserMedia({
                    video: {
                        optional: [{
                            sourceId: id
                        }],
                        deviceId: id
                    }
                }, handleVideo, handleError);
            }
        }
        function handleVideo(stream) {
            window.stream = stream;
            camera.src = window.URL.createObjectURL(stream);
        }
        function handleError(){}

        function photo() {
            var
                canvas = document.getElementById('photo'),
                ctx = canvas.getContext('2d');
            ctx.drawImage(camera, 0, 0, camera.videoWidth, camera.videoHeight);
        }
    </script>
</body>
</html>