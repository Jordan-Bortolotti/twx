<?xml version="1.0" ?>
<xsl:stylesheet 
  version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>

<xsl:output method="html" indent="yes" />

<xsl:template match="/address-book">
  <html><head><title></title></head><body>
    <form action="process.php" method="post">
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
    </form>
  </body></html>
</xsl:template>

<xsl:template match="person">
  <tr>
    <td><input type="submit" name="p{@id}" /></td>
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
