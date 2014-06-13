<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>

<xsl:template match="/">
<html>
<head><title>ddsadsa</title></head>
<body>
  <xsl:apply-templates />
</body>
</html>
</xsl:template>

<xsl:template match="user">
  <table>
  <tr>
    <th>Name</th><th>Password</th>
  </tr>
  <tr>
    <xsl:apply-templates />
  </tr>
  </table>
</xsl:template>

<xsl:template match="userName|password">
  <td><xsl:value-of select="." /></td>
</xsl:template>

</xsl:stylesheet>
