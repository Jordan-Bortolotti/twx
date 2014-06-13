<?xml version="1.0" ?>
<xsl:stylesheet 
  version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>

<xsl:output method="text" indent="yes" />

<xsl:template match="/address-book">
  <xsl:apply-templates />
</xsl:template>

<xsl:template match="person">
  #person { background-color: #FF0; }
  <xsl:apply-templates />
</xsl:template>

<xsl:template match="firstname">
  .firstname { font-weight: bold; }
</xsl:template>

<xsl:template match="lastname">
  .lastname { font-weight: bold; }
</xsl:template>

<xsl:template match="city|state">
  .location { color: #F00; }
</xsl:template>

<xsl:template match="text()" />

</xsl:stylesheet>
