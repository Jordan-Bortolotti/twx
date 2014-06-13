Notice that the stylesheet.xsl file has <xsl:element> and <xsl:attribute>
tags. These tags CREATE the element/attribute that is named in their name=
attribute and the contents of these tags are the contents of the created
tags. (NOTE: xsl:attribute inside xsl:element appear as an attribute
in the created element (tag).)