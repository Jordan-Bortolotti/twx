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
    <table border="1">
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Price</th>
          <th>Short Name</th>
          <th>Long Name</th>
        </tr>
      </thead>
      <tbody>
        <xsl:apply-templates select="products/prod">
          <xsl:sort order="ascending" select="number(products/prod/@id)" />
        </xsl:apply-templates>
      </tbody>
    </table>
  </xsl:template>

  <xsl:template match="prod">
    <xsl:element name="tr">
      <xsl:attribute name="class">
        <xsl:choose>
          <xsl:when test="position() mod 2 = 0">
            <xsl:text>even</xsl:text>
          </xsl:when>
          <xsl:otherwise>
            <xsl:text>odd</xsl:text>
          </xsl:otherwise>
        </xsl:choose>
      </xsl:attribute>
      <td><xsl:value-of select="@id" /></td>
      <td class="ar">$<xsl:value-of select="price" /></td>
      <td><xsl:value-of select="normalize-space(sname)" /></td>
      <td><xsl:value-of select="normalize-space(lname)" /></td>
    </xsl:element>
  </xsl:template>

</xsl:stylesheet>
