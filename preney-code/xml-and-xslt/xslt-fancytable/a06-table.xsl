<?xml version="1.0" ?>
<xsl:stylesheet 
  version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
>
  <!-- The next 3 lines allow one to access the parameters passed into this
       script. The names used here must match what was passed into the
       script. Later in the XSLT code, these variables are used when prefixed
       with a dollar sign character, $. -->
  <xsl:param name="sortby" />
  <xsl:param name="type" />
  <xsl:param name="order" />

  <!-- There is no standard way to output HTML5 with the DOCTYPE yet. To
       produce the proper output, we output this file as XML but we
       omit the xml processing instruction. The indent flag is set to "yes"
       to ensure the output is easily readable by you, however, on a real
       web site one would set it to "no" to avoid sending unnecessary
       whitespace. -->
  <xsl:output
    method="xml"
    encoding="utf-8"
    omit-xml-declaration="yes"
    indent="yes"
  />

  <!-- A match for "/" matches the input XML document --NOT that document's 
       root tag! Every time you receive an input document, you want to
       output the HTML5 DOCTYPE, the <head> and the <body> of the page.
       You also want to trigger the generation of the content of this
       page. 
       
       The disable-output-escaping allows use to write &lt; so that it
       comes out as <. This is needed since there is no other way to write
       out an HTML5 DOCTYPE yet. 
  -->
  <xsl:template match="/">
    <xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html>
</xsl:text>  
    <html>
      <head>
        <!-- TODO: Write a <title> tag to output "Employees Table" here. -->
        <!-- TODO: Write a <link> tag to refer to the a06.css stylesheet 
                   here. -->
      </head>
      <body>
        <!-- TODO: Write the xsl: command that will apply the templates in 
                   order of appearance here. -->
      </body>
    </html>
  </xsl:template>

  <!-- When an employees element is encountered you want to do the 
       following:
         1) Output a <table> ... </table> tag.
         2) Output a <thead> ... </thead> tag within the table.
         3) Within <thead> output a table row with these column headings
            in the order listed:
              a) "Index" (hyperlinked to ?s=i)
                 (More instructions appear below.)
              b) "Last Name" (hyperlinked to ?s=fn)
              c) "First Name" (hyperlinked to ?s=fn)
              d) "Street Address" (hyperlinked to ?s=sa)
              e) "City" (hyperlinked to ?s=sa)
              f) "Prov." (hyperlinked to ?s=p)
              g) "Postal Code" (hyperlinked to ?s=pc)
              h) "Phone" (hyperlinked to ?s=ph)
              i) "Email" (hyperlinked to ?s=e)
              j) "Salary" (hyperlinked to ?s=s)
         4) Output a <tbody> ... </tbody> tag (after the <thead>).
            (Follow the additional instructions provided below.)
  -->
  <xsl:template match="employees">
    <table>
      <!-- TODO: Write your <thead> element and contents here.
           For the first "Index" column, you want to additionally do the
           following after you output "Index" in a hyperlink:
             a) Add an <xsl:if> element whose test attribute is "$sortby".
                NOTE: Like JavaScript and PHP, if you test a variable on its
                      own, it is true iff it has a defined value, otherwise
                      it is false.
             b) Inside the <xsl:if> element, you want the following:
                <br /> (to create a line break)
                Output a '(' inside an <xsl:text> element.
                Output $sortby.
                Output a ')' inside an <xsl:text> element.
          Finally remember to write <td>...</td> for each column! :-)
      -->
      <!-- TODO: Write your <tbody> element and contents here.
           Here you'd want to use an "if..then..else" statement if you
           were writing code in most other programming languages. XSLT's
           "if..then..else" statement is done using these elements
           
             <xsl:choose>
               <xsl:when test="test1" />
               <xsl:when test="test2" />
               ...
               <xsl:when test="testN" />
               <xsl:otherwise />
             </xsl:choose>
             
           So here you want to do test="$sortby". If $sortby is set
           by the code calling this XSLT script, then you want to do the
           following within the <xsl:when> element:
           
             a) Invoke <xsl:apply-templates> with select="erecord".
             b) Within the <xsl:apply-templates> tag write the following:
                <xsl:sort 
                  select="child::*[name()=$sortby]"
                  data-type="$type"
                  order="$order"
                />

           Otherwise you want to apply the templates called "erecord". You
           do this by using <xsl:apply-templates> with the select attribute
           set to "erecord".
      -->
  </xsl:template>

  <xsl:template match="erecord">
    <!-- The next line stores the current position of the child node.
         Notice that this position is relative to the applied sorting if
         the nodes are sorted. If the nodes are not sorted then it is 
         relative to the ordering in the file. Thus, regardless of what this
         XSLT program does, this will always output: 1, 2, 3, ..., N.
         
         NOTE: In XSLT, once a variable or parameter has been set to a value 
               it is immutable.
    -->
    <xsl:variable name="index" select="position()" />
    <!-- TODO: You need to write a suitable <tr class="even"> or
               <tr class="odd"> tag here. There are two ways to do this
               in XSLT. One way, which is easier but less general is:
               
                 <tag-name attribute="{$variable-name}">
                 
               Notice that the attribute value has XSLT code inside of
               braces (i.e., {}). This is one method.
               
               A more general and flexible method is to use
               <xsl:element> and <xsl:attribute> elements to CONSTRUCT
               an element and an attribute respectively. For example:
               
                 <xsl:element name="a">
                   <xsl:attribute name="href">
                     <xsl:text>http://preney.ca/paul/</xsl:text>
                   </xsl:attribute>
                   <xsl:text>Paul Preney's Homepage</xsl:text>
                 </xsl:element>
                 
              would generate the following code:
              
                 <a href="http://preney.ca/paul/">Paul Preney's Homepage</a>
                 
              You could, of course, output the value of a variable using
              <xsl:value-of select="$variable-name" /> where needed.
                 
              Unfortunately, you don't have the variable value needed to 
              just output "even" or "odd" for the class attribute. To 
              accomplish this, you need to write another "if..then..else"
              statement in XSLT (see above). The test you want to use is:
              test="($index mod 2) = 0" (i.e., if it is even) or you could
              test for odd if you prefer.
              
              Write the code necessary to output the proper <tr> tag.
    -->
      <!-- TODO: Proper <tr> constructor goes here! -->
      <!-- The data for the "Index" column is just the position(). I have
           provided it for you: -->
      <td><xsl:value-of select="$index" /></td>
      <!-- TODO: Now you want to output each column in this order:
                 lname, fname, street, city, province, postalcode, phone,
                 email, annualsalary.
                 
                 To do this, you want to apply-templates selecting the
                 column name. If you do not write a select attribute then
                 it would apply the templates in order of their appearance
                 which might lead to a table with data in the wrong columns.
      -->
  </xsl:template>

  <!-- TODO: When an annualsalary element is encountered, you want to format 
             the number like this: "$###,###.00". Figure out how to do this 
             using XSLT's format-number() function. You will want to call 
             XSLT's text() function within the template.
  -->
  <xsl:template match="annualsalary">
    <!-- TODO: Write your code here. -->
  </xsl:template>

  <!-- This will match any node that isn't explicitly matched before this
       rule. This node outputs the text of the current node as a column's 
       cell. Don't delete this code!!!! -->
  <xsl:template match="node()">
    <td><xsl:value-of select="./text()" /></td>
  </xsl:template>

  <!-- This matches any attribute, text, comment, or processing instruction
       in the input document. Since the element is empty, nothing is 
       output. This is commonly used in XSLT as the last item in the file
       to prevent anything not explicitly matched above from generating any
       output. -->
  <xsl:template match="@*|text()|comment()|processing-instruction()" />
</xsl:stylesheet>
