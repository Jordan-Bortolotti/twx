<?xml version="1.0" encoding="UTF-8"?>
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
	  <body>
	   <h3 style="text-align:center">Legal Statement</h3>
	   <br />
	   <xsl:apply-templates/>
	  </body>
	 </html>
	</xsl:template>
	
	<xsl:template match="name">
	 <div>
	  <xsl:value-of select="@id" /><br />
	  <xsl:value-of select="normalize-space(content)" />
	  ***<xsl:value-of select="normalize-space(smallprint)" />***
	 </div>
	</xsl:template>
</xsl:stylesheet>
	  
	  
