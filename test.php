<?

$testString = 'h3j3k1ld,f45.66443+*/-';

echo strlen($testString);
echo '<br>';
$new =  preg_replace("/[^0-9]/", "", $testString);
echo strlen($new);
echo '<br>';
echo strlen($testString);
echo '<br>';
echo $new;

?>