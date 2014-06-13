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
    <table>
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Price</th>
          <th>Short Name</th>
          <th>Long Name</th>
        </tr>
      </thead>
      <tbody>
        <xsl:apply-templates select="products/prod" />
      </tbody>
    </table>
  </xsl:template>

  <xsl:template match="prod">
    <tr>
      <td><xsl:value-of select="@id" /></td>
      <td class="ar">$<xsl:value-of select="price" /></td>
      <td><xsl:value-of select="normalize-space(sname)" /></td>
      <td><xsl:value-of select="normalize-space(lname)" /></td>
    </tr>
  </xsl:template>

</xsl:stylesheet>
