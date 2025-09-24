<?php
// index.php

// Coreografía (la misma que en el JSON original)
// En un proyecto real, esto podría cargarse desde un archivo JSON
$choreography = [
    [
        "time" => 0.0,
        "pose" => [
            "left_arm_angle" => 45,
            "right_arm_angle" => 45,
            "left_shoulder_angle" => 0,
            "right_shoulder_angle" => 0
        ],
        "description" => "Ambos brazos ligeramente levantados hacia adelante (45°)"
    ],
    [
        "time" => 1.0,
        "pose" => [
            "left_arm_angle" => 90,
            "right_arm_angle" => 30,
            "left_shoulder_angle" => 90,
            "right_shoulder_angle" => 30
        ],
        "description" => "Brazo izquierdo en horizontal (90°) y brazo derecho levemente levantado (30°)"
    ],
    // ... agrega el resto de las poses aquí
    [
        "time" => 2.0,
        "pose" => [
            "left_arm_angle" => 135,
            "right_arm_angle" => 135,
            "left_shoulder_angle" => 135,
            "right_shoulder_angle" => 135
        ],
        "description" => "Ambos brazos en ángulo abierto hacia arriba (135°) formando una V"
    ],
    [
        "time" => 3.0,
        "pose" => [
            "left_arm_angle" => 180,
            "right_arm_angle" => 90,
            "left_shoulder_angle" => 180,
            "right_shoulder_angle" => 90
        ],
        "description" => "Brazo izquierdo completamente arriba (180°) y brazo derecho horizontal (90°)"
    ],
    [
        "time" => 4.0,
        "pose" => [
            "left_arm_angle" => 180,
            "right_arm_angle" => 0,
            "left_shoulder_angle" => 180,
            "right_shoulder_angle" => 0
        ],
        "description" => "Brazo izquierdo completamente arriba (180°) y brazo derecho completamente abajo (0°)"
    ],
    [
        "time" => 5.0,
        "pose" => [
            "left_arm_angle" => 90,
            "right_arm_angle" => 90,
            "left_shoulder_angle" => 90,
            "right_shoulder_angle" => 90
        ],
        "description" => "Ambos brazos a los lados, formando una T"
    ],
    [
        "time" => 6.0,
        "pose" => [
            "left_arm_angle" => 0,
            "right_arm_angle" => 0,
            "left_shoulder_angle" => 0,
            "right_shoulder_angle" => 0
        ],
        "description" => "Ambos brazos a los costados del cuerpo (0°)"
    ],
    [
        "time" => 7.0,
        "pose" => [
            "left_arm_angle" => 180,
            "right_arm_angle" => 180,
            "left_shoulder_angle" => 90,
            "right_shoulder_angle" => 90
        ],
        "description" => "Ambos brazos en horizontal a los lados (90°)"
    ],
    [
        "time" => 8.0,
        "pose" => [
            "left_arm_angle" => 30,
            "right_arm_angle" => 30,
            "left_shoulder_angle" => 60,
            "right_shoulder_angle" => 60
        ],
        "description" => "Ambos brazos cruzados frente al pecho"
    ],
    [
        "time" => 9.0,
        "pose" => [
            "left_arm_angle" => 90,
            "right_arm_angle" => 90,
            "left_shoulder_angle" => 90,
            "right_shoulder_angle" => 90
        ],
        "description" => "Brazos en 'L', codos doblados a 90°"
    ]
];

// Codificar el array PHP a JSON para que JavaScript pueda usarlo
$choreography_json = json_encode($choreography);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detección de Poses PHP + JS</title>
    <style>
        .pose-container {
            position: relative;
            width: 640px;
            height: 480px;
        }
        .score, .description {
            position: absolute;
            color: white;
            font-weight: bold;
            font-family: sans-serif;
            text-shadow: 2px 2px 4px #000;
        }
        .score { top: 10px; left: 10px; font-size: 2rem; }
        .description { bottom: 10px; left: 10px; font-size: 1.2rem; }
        canvas {
            display: block;
        }
    </style>
</head>
<body>

<div class="pose-container">
    <video id="videoEl" playsinline style="display:none;"></video>
    <canvas id="canvasEl" width="640" height="480"></canvas>
    <div id="score" class="score"></div>
    <div id="description" class="description"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@mediapipe/pose/pose.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js"></script>
<script>
    // Obtener la coreografía desde PHP
    const choreography = <?php echo $choreography_json; ?>;

    const videoEl = document.getElementById('videoEl');
    const canvasEl = document.getElementById('canvasEl');
    const canvasCtx = canvasEl.getContext('2d');
    const scoreEl = document.getElementById('score');
    const descriptionEl = document.getElementById('description');

    let pose = null;
    let camera = null;

    let currentPoseIndex = 0;
    let checkPointCounter = 0;

    // Función para calcular el ángulo entre 3 puntos
    function calculateAngle(A, B, C) {
        const AB = {x: B.x - A.x, y: B.y - A.y};
        const CB = {x: B.x - C.x, y: B.y - C.y};
        const dot = (AB.x * CB.x + AB.y * CB.y);
        const magAB = Math.sqrt(AB.x**2 + AB.y**2);
        const magCB = Math.sqrt(CB.x**2 + CB.y**2);
        const angle = Math.acos(dot / (magAB * magCB));
        return angle * (180 / Math.PI);
    }

    // Función para comparar poses
    function comparePose(userPose, refPose) {
        const diffLeftArm = Math.abs(userPose.left_arm_angle - refPose.left_arm_angle);
        const diffRightArm = Math.abs(userPose.right_arm_angle - refPose.right_arm_angle);
        const diffLeftShoulder = Math.abs(userPose.left_shoulder_angle - refPose.left_shoulder_angle);
        const diffRightShoulder = Math.abs(userPose.right_shoulder_angle - refPose.right_shoulder_angle);
        
        let totalDiff = 0;
        let count = 0;
        if (refPose.left_arm_angle !== null) { totalDiff += diffLeftArm; count++; }
        if (refPose.right_arm_angle !== null) { totalDiff += diffRightArm; count++; }
        if (refPose.left_shoulder_angle !== null) { totalDiff += diffLeftShoulder; count++; }
        if (refPose.right_shoulder_angle !== null) { totalDiff += diffRightShoulder; count++; }

        const avgDiff = count > 0 ? totalDiff / count : 100;

        if (avgDiff < 15) return 'Perfect';
        if (avgDiff < 30) return 'Good';
        return 'Miss';
    }

    // Inicializar MediaPipe y la cámara
    pose = new Pose({
        locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/pose/${file}`
    });

    pose.setOptions({
        modelComplexity: 1,
        smoothLandmarks: true,
        enableSegmentation: false,
        minDetectionConfidence: 0.5,
        minTrackingConfidence: 0.5
    });

    pose.onResults((results) => {
        canvasCtx.save();
        canvasCtx.clearRect(0, 0, canvasEl.width, canvasEl.height);
        canvasCtx.drawImage(results.image, 0, 0, canvasEl.width, canvasEl.height);

        if (results.poseLandmarks) {
            drawConnectors(canvasCtx, results.poseLandmarks, POSE_CONNECTIONS,
                { color: '#00FF00', lineWidth: 4 });
            drawLandmarks(canvasCtx, results.poseLandmarks,
                { color: '#FF0000', lineWidth: 2 });

            const landmarks = results.poseLandmarks;
            
            const userPose = {
                left_arm_angle: calculateAngle(landmarks[11], landmarks[13], landmarks[15]),
                right_arm_angle: calculateAngle(landmarks[12], landmarks[14], landmarks[16]),
                left_shoulder_angle: calculateAngle(landmarks[13], landmarks[11], landmarks[23]),
                right_shoulder_angle: calculateAngle(landmarks[14], landmarks[12], landmarks[24])
            };

            // Lógica de avance de la coreografía
            if (currentPoseIndex < choreography.length) {
                const refPose = choreography[currentPoseIndex];
                
                const poseStatus = comparePose(userPose, refPose.pose);
                scoreEl.textContent = poseStatus;
                
                if (poseStatus === 'Perfect' || poseStatus === 'Good') {
                    checkPointCounter++;
                    if (checkPointCounter > 30) {
                        currentPoseIndex++;
                        checkPointCounter = 0;
                        
                        if (currentPoseIndex < choreography.length) {
                            descriptionEl.textContent = 'Próxima pose: ' + choreography[currentPoseIndex].description;
                        } else {
                            descriptionEl.textContent = '¡Coreografía terminada!';
                            scoreEl.textContent = '¡Excelente!';
                        }
                    }
                } else {
                    checkPointCounter = 0;
                }
            } else {
                descriptionEl.textContent = '¡Coreografía terminada!';
                scoreEl.textContent = '¡Excelente!';
            }
        }
        canvasCtx.restore();
    });

    // Iniciar cámara
    camera = new Camera(videoEl, {
        onFrame: async () => {
            await pose.send({ image: videoEl });
        },
        width: 640,
        height: 480
    });
    camera.start();

    // Establecer la descripción de la primera pose
    if (choreography.length > 0) {
        descriptionEl.textContent = 'Próxima pose: ' + choreography[0].description;
    }
</script>

</body>
</html>