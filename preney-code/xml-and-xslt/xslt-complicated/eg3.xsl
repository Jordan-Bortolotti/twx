<?xml version="1.0" ?>
<!--
 Unlike eg2.xsl, this stylesheet requires showChapter to be set to an id
 attribute of the chapter element. If no such id is found in the document, then
 no data is output.
-->
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

  <!--
    The select expression for $chapter below will:
      - First Predicate: select ALL chapter elements that have an id attribute 
        set to $showChapter
      - Second Predicate: select the first chapter element found (in the
        first predicate)
  -->
  <xsl:variable 
    name="chapter"
    select="/book/chapter[@id=string($showChapter)][position()=1]"
  />


  <!--
    In XPath, it is possible to query the nodes relative to a specific node.
    The following relative queries are possible:

      - ancestor
      - ancestor-or-self
      - attribute
      - child
      - descendent
      - descendent-or-self
      - following
      - following-sibling
      - namespace
      - parent
      - preceding
      - preceding-sibling
      - self

    XPath can be used, for example, in select and test attributes in XSLT.
    Below, $chapter is used to determine if there is a preceding-sibling
    element (whose name is chapter, i.e., preceding-sibling::chapter). The
    same is also done for following-sibling. If so, in each case, an
    appropriate XHTML hyperlink is created using the xsl:element and
    xsl:attribute tags.
  -->
  <xsl:template match="/">
    <html>
      <head>
        <title><xsl:value-of select="$chapter/title" /></title>
      </head>
      <body>
        <xsl:if test="$chapter">
          <b>Show Chapter: <xsl:value-of select="$chapter/@id" /></b>
          <xsl:apply-templates select="$chapter/node()" />

          <hr />

          <xsl:if test="$chapter/preceding-sibling::chapter[position()=1]/@id">
            <xsl:element name="a">
              <xsl:attribute name="href">
                <xsl:text>?id=</xsl:text>
                <xsl:value-of select="$chapter/preceding-sibling::chapter[position()=1]/@id" />
              </xsl:attribute>
              <xsl:text>Previous Chapter</xsl:text>
            </xsl:element>
          </xsl:if>
         
          <br />

          <xsl:if test="$chapter/following-sibling::chapter[position()=1]/@id">
            <xsl:element name="a">
              <xsl:attribute name="href">
                <xsl:text>?id=</xsl:text>
                <xsl:value-of select="$chapter/following-sibling::chapter[position()=1]/@id" />
              </xsl:attribute>
              <xsl:text>Next Chapter</xsl:text>
            </xsl:element>
          </xsl:if>

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
