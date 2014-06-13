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
    <html>
      <head>
        <title><xsl:value-of select="book/chapter[position()=1]/title" /></title>
      </head>
      <body>
        <xsl:apply-templates select="book/chapter" />
      </body>
    </html>
  </xsl:template>

  <xsl:template match="chapter">
    <xsl:apply-templates select="title" />
    <ul>
      <xsl:apply-templates select="para" />
    </ul>
  </xsl:template>

  <xsl:template match="title">
    <h1>
      <xsl:apply-templates />
    </h1>
  </xsl:template>

  <xsl:template match="para">
    <li>
      <xsl:apply-templates />
    </li>
  </xsl:template>

</xsl:stylesheet>
