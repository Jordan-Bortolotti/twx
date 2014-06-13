<?xml version="1.0" ?>
<xsl:stylesheet 
  version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>

  <xsl:output
    method="xml"
    omit-xml-declaration="yes"
    indent="yes"
  />
 
  <xsl:template match="/">
    <xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html></xsl:text>
    <html>
      <head>
        <title><xsl:value-of select="/book/@title" /></title>
      </head>
      <body>
        <h1><xsl:value-of select="/book/@title" /></h1>
        <xsl:apply-templates />
      </body>
    </html>
  </xsl:template>

  <xsl:template match="book">
    <xsl:apply-templates />
  </xsl:template>

  <xsl:template match="chapter">
    <hr />
    <h2><xsl:value-of select="title" /></h2>
    <xsl:apply-templates select="para" />
  </xsl:template>

  <xsl:template match="para">
    <xsl:choose>
      <xsl:when test="@special='bold'">
        <p style="font-weight: bold"><xsl:value-of select="text()" /></p>
      </xsl:when>
      <xsl:otherwise>
        <p><xsl:value-of select="text()" /></p>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <!-- Catch everything else and ensure that nothing is output. -->
  <xsl:template match="@*|*|text()|comment()|processing-instruction()" />

</xsl:stylesheet>
