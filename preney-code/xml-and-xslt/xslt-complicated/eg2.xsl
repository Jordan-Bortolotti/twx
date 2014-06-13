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

  <xsl:param name="showChapter" />

  <xsl:variable
    name="chapterMax"
    select = "count(/book/chapter)"
  />

  <xsl:variable
    name="chapterNum"
  >
    <xsl:choose>
      <xsl:when test="number($showChapter) &gt; 0 and number($showChapter) &lt;= $chapterMax">
        <xsl:copy-of select="number($showChapter)" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:copy-of select="number(1)" />
      </xsl:otherwise>
    </xsl:choose>
  </xsl:variable>

  <xsl:variable
    name="chapter"
    select="/book/chapter[position()=$chapterNum]"
  />

  <xsl:template match="/">
    <html>
      <head>
        <title><xsl:value-of select="$chapter/title" /></title>
      </head>
      <body>
        <b>Show Chapter: <xsl:value-of select="$chapterNum" /> of <xsl:value-of select="$chapterMax" /></b>
        <xsl:apply-templates select="$chapter/node()" />

        <hr />

        <xsl:if test="$chapterNum &gt; 1">
          <xsl:element name="a">
            <xsl:attribute name="href">
              <xsl:text>?id=</xsl:text>
              <xsl:value-of select="$chapterNum - 1" />
            </xsl:attribute>
            <xsl:text>Previous Chapter</xsl:text>
          </xsl:element>
        </xsl:if>

        <br />

        <xsl:if test="$chapterNum &lt; $chapterMax">
          <xsl:element name="a">
            <xsl:attribute name="href">
              <xsl:text>?id=</xsl:text>
              <xsl:value-of select="$chapterNum + 1" />
            </xsl:attribute>
            <xsl:text>Next Chapter</xsl:text>
          </xsl:element>
        </xsl:if>
      
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
