<?php
// choreography.php
header('Content-Type: application/json');

$choreography = [
  [
    "time" => 0.0,
    "pose" => [
      "left_arm_angle" => 45,
      "right_arm_angle" => 45
    ],
    "description" => "Ambos brazos ligeramente levantados hacia adelante (45°)"
  ],
  [
    "time" => 1.0,
    "pose" => [
      "left_arm_angle" => 90,
      "right_arm_angle" => 30
    ],
    "description" => "Brazo izquierdo en horizontal (90°) y brazo derecho levemente levantado (30°)"
  ],
  [
    "time" => 2.0,
    "pose" => [
      "left_arm_angle" => 135,
      "right_arm_angle" => 135
    ],
    "description" => "Ambos brazos en ángulo abierto hacia arriba (135°) formando una V"
  ],
  [
    "time" => 3.0,
    "pose" => [
      "left_arm_angle" => 180,
      "right_arm_angle" => 90
    ],
    "description" => "Brazo izquierdo completamente arriba (180°) y brazo derecho horizontal (90°)"
  ]
];

echo json_encode($choreography);
exit();