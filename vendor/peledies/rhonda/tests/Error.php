<?php

echo "<h3>\Rhonda\Error</h3>";

// Format an exception the error log and for return
try{
  throw new Exception("Demo Error Exception 1");
}catch(\Exception $e){
  echo \Rhonda\Error::handle($e);
}
echo "</br>";

try{
  throw new Exception("Demo Error Exception 2");
}catch(\Exception $e){
  $error = new \Rhonda\Error();
  echo $error->handle($e);
}

\Rhonda\Error:: deprecation_warning("message", "http://alternate/route");
echo "</br>";