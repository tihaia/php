//цикл for
<?php

$a = 0;
$b = 0;

for ($i = 0; $i <= 5; $i++) {
   $a += 10;
   echo "a = $a";
   $b += 5;
   echo "b = $b";
}

echo "End of the loop: a = $a, b = $b";


//цикл while

$i = 0;
$a = 0;
$b = 0;

while ($i <= 5) {
    $a += 10;
    $b += 5;
    $i++;
}
echo "End of the loop: a = $a, b = $b";


//цикл do while

$i = 0;
$a = 0;
$b = 0;

do {
    $a += 10;
    $b += 5;
    $i++;
} while ($i <= 5);

echo "End of the loop: a = $a, b = $b";