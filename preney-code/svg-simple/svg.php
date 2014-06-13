<?php 

//header('Content-Type: text/plain');
//header('Content-Type: text/html');
//header('Content-Type: application/octet-stream');
header('Content-Type: image/svg+xml');

function gen_header($width,$height,$jsFiles=array())
{
  echo <<<ZZEOF
<svg 
  id="svgRoot"
  version="1.1" 
  xmlns="http://www.w3.org/2000/svg"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  width="${width}" height="${height}"
  preserveAspectRatio="xMidYMid meet"
>
ZZEOF;

foreach ($jsFiles as $j)
  echo "<script xlink:href='${j}' type='text/javascript' />";
}

function gen_footer()
{
  echo "</svg>";
}

//******************************************************

gen_header(
  '100%','100%',
  array('drag-and-drop-code.js')
);
?>
	<g id="shape1">
    <svg x="10%" y="10%" width="100" height="100">
      <g> <!-- Unused <g>. Is only present for the 
above comment. -->
        <path
          d="M 1,1 50,99 99,1 Z"
          stroke="#000" stroke-width="3px"
          fill="#FFA"
        />
      </g>
    </svg>
  </g>
<?php
gen_footer();
?>
