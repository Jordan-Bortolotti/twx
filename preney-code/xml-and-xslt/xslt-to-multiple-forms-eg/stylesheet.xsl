<?xml version="1.0" ?>
<xsl:stylesheet 
  version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>

<xsl:output method="html" indent="yes" />

<xsl:template match="/address-book">
  <html><head><title></title></head><body>
      <table border="1">
        <tr>
          <th>Action</th>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>City, State</th>
          <th>E-mail</th>
        </tr>
        <xsl:apply-templates select="person" />
      </table>
  </body></html>
</xsl:template>

<xsl:template match="person">
  <xsl:variable name="color" select="(position() mod 2)+1" />

  <tr class="row{$color}">
    <td>
      <form action="process.php" method="post">
        <input type="text" name="quantity{@id}" />
        <input type="submit" name="p{@id}" />
      </form>
    </td>
    <td><xsl:apply-templates select="@id" /></td>
    <td><xsl:apply-templates select="firstname" /></td>
    <td><xsl:apply-templates select="lastname" /></td>
    <td>
      <xsl:value-of select="city" />
      <xsl:text>, </xsl:text>
      <xsl:value-of select="state" />
    </td>
    <td><xsl:apply-templates select="email" /></td>
  </tr>
</xsl:template>

<xsl:template match="firstname|lastname|email|@id">
  <xsl:value-of select="." />
</xsl:template>

</xsl:stylesheet>
