<?php

function myfunc($uid,$age,$fname)
{
  print_r($fname);
  return ucfirst($fname)." is $age years old and has uid $uid.\n";
}

$xml = <<<EOB
<allusers>
 <user>
  <uid>bob</uid>
  <age>39</age>
  <fname>Robert</fname>
  <lname>Smith</lname>
 </user>
 <user>
  <uid>joe</uid>
  <age>18</age>
  <fname>Joe</fname>
  <lname>Jones</lname>
 </user>
</allusers>
EOB;

$xsl = <<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
     xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
     xmlns:php="http://php.net/xsl">
<xsl:output method="html" encoding="utf-8" indent="yes"/>
 <xsl:template match="allusers">
  <html><body>
    <h2>Users</h2>
    <table>
    <xsl:for-each select="user">
      <tr><td>
        <xsl:value-of
         select="php:function('myfunc',string(uid),number(age),string(fname))"/>
      </td></tr>
    </xsl:for-each>
    </table>
  </body></html>
 </xsl:template>
</xsl:stylesheet>
EOB;

$xmldoc = DOMDocument::loadXML($xml);
$xsldoc = DOMDocument::loadXML($xsl);

$proc = new XSLTProcessor();
$proc->registerPHPFunctions();
$proc->importStyleSheet($xsldoc);
echo $proc->transformToXML($xmldoc);
?> 
