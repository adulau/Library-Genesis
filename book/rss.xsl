<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
<html>
<head>
<title>Library Genesis: Book Record</title>
</head>

<body>
<table border="0" rules="cols" width="100%">
	<tr height="2" valign="top"><td bgcolor="brown" colspan="5"></td></tr>
	<xsl:for-each select="library/book">
		<tr valign="top"><td rowspan="20" width="240">
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="url"/></xsl:attribute>
				<xsl:element name="img">
				<xsl:attribute name="src"><xsl:value-of select="coverurl"/></xsl:attribute>
				<xsl:attribute name='border'>0</xsl:attribute>
				<xsl:attribute name='width'>240</xsl:attribute>
				<xsl:attribute name='style'>padding: 5px</xsl:attribute>
				</xsl:element></xsl:element></td>
                                 <td><font color="gray"><xsl:value-of select="titlelangselect"/>:</font></td><td colspan="2"><b><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="url"/></xsl:attribute><xsl:value-of select="title"/></xsl:element></b></td><td><font color="gray"><xsl:value-of select="volumelangselect"/>: </font> <xsl:value-of select="volume"/></td></tr>
		<tr valign="top"><td><font color="gray"><xsl:value-of select="authorlangselect"/>:</font></td><td colspan="3"><b><xsl:value-of select="authors"/></b></td></tr>
	        <tr valign="top"><td><font color="gray"><xsl:value-of select="serieslangselect"/>:</font></td><td><xsl:value-of select="series"/></td><td><font color="gray"><xsl:value-of select="periodicallangselect"/>:</font></td><td><xsl:value-of select="periodical"/></td></tr>
                <tr valign="top"><td><font color="gray"><xsl:value-of select="publisherlangselect"/>:</font></td><td><xsl:value-of select="publisher"/></td><td><font color="gray"><xsl:value-of select="citylangselect"/>:</font></td><td><xsl:value-of select="city"/></td></tr>
		<tr valign="top"><td><font color="gray"><xsl:value-of select="yearlangselect"/>:</font></td><td><xsl:value-of select="year"/></td><td><font color="gray"><xsl:value-of select="editionlangselect"/>:</font></td><td><xsl:value-of select="edition"/></td></tr>
		<tr valign="top"><td><font color="gray"><xsl:value-of select="languagelangselect"/>:</font></td><td><xsl:value-of select="language"/></td><td><font color="gray"><xsl:value-of select="pageslangselect"/>:</font></td><td><xsl:value-of select="pages"/></td></tr>
		<tr valign="top"><td><font color="gray">ISBN:</font></td><td><xsl:value-of select="isbn"/></td><td><font color="gray">ID:</font></td><td><xsl:value-of select="id"/></td></tr>
		<tr valign="top"><td><font color="gray"><xsl:value-of select="timeaddlangselect"/>:</font></td><td><xsl:value-of select="date"/></td><td><font color="gray"><xsl:value-of select="timelmlangselect"/>:</font></td><td><xsl:value-of select="date2"/></td></tr>
		<tr valign="top"><td><font color="gray"><xsl:value-of select="librarylangselect"/>:</font></td><td><xsl:value-of select="library"/></td><td><font color="gray"><xsl:value-of select="libraryisslangselect"/>:</font></td><td><xsl:value-of select="issue"/></td></tr>
		<tr valign="top"><td><font color="gray"><xsl:value-of select="sizelangselect"/>:</font></td><td><xsl:value-of select="size"/> (<xsl:value-of select="sizebytes"/> bytes)</td><td><font color="gray"><xsl:value-of select="extlangselect"/>:</font></td><td><xsl:value-of select="type"/></td></tr>

		



<tr valign="top">
   <td><font color="gray"><xsl:value-of select="worseverlangselect"/>:</font></td><td colspan="1"> 
          <xsl:for-each select="generic/md5">
            <xsl:element name="a">
              <xsl:attribute name="href">../book/index.php?md5=<xsl:value-of select="."/>
               </xsl:attribute>
               <xsl:value-of select="."/>
              </xsl:element>
             <xsl:element name="br">
            </xsl:element>
          </xsl:for-each></td>
   <td><font color="gray">BibTeX</font></td><td>
       <xsl:element name="a">
        <xsl:attribute name="href">
         <xsl:value-of select="bibtex"/>
        </xsl:attribute><b><xsl:value-of select="link"/></b>
       </xsl:element>
   </td>
</tr>


<tr valign="top">
<td><font color="gray"><xsl:value-of select="descroldlangselect"/>:</font></td><td colspan="1">
<xsl:for-each select="olddescr/md5olddescr">
<xsl:element name="a">
<xsl:attribute name="href">../book/index_old.php?md5=<xsl:value-of select="md5old"/>&amp;tlm=<xsl:value-of select="timelastmoifiedold"/>
</xsl:attribute>
<xsl:value-of select="timelastmoifiedold"/>
</xsl:element> | </xsl:for-each>
   </td>
<td><font color="gray"><xsl:value-of select="editlangselect"/>:</font></td><td><b><xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="edit"/></xsl:attribute><xsl:value-of select="edit1"/></xsl:element></b></td>
</tr>

<tr valign="top"><td><font color="gray"><xsl:value-of select="commentlangselect"/>:</font></td><td colspan="3"><xsl:value-of select="commentary"/></td></tr>
<tr valign="top"><td><font color="gray"><xsl:value-of select="topiclangselect"/>:</font></td><td colspan="3"><xsl:value-of select="topic"/></td></tr>

<tr valign="top"><td><font color="gray"><xsl:value-of select="identlangselect"/>:</font></td>
<td colspan="3"><table border="0"  rules="cols"  width="100%"><tr>
<td align="center" width="11,1%"><font color="gray">ISSN: </font></td>
<td align="center" width="11,1%"><font color="gray">UDC: </font></td>
<td align="center" width="11,1%"><font color="gray">LBC: </font></td>
<td align="center" width="11,1%"><font color="gray">LCC: </font></td>
<td align="center" width="11,1%"><font color="gray">DDC: </font></td>
<td align="center" width="11,1%"><font color="gray">DOI: </font></td>
<td align="center" width="11,1%"><font color="gray">OpenLibraryID: </font></td>
<td align="center" width="11,1%"><font color="gray">GoogleID: </font></td>
<td align="center" width="11,1%"><font color="gray">ASIN:</font></td>
</tr>
<tr>
<td align="center" width="11,1%"><xsl:value-of select="issn"/></td>
<td align="center" width="11,1%"><xsl:value-of select="udc"/></td>
<td align="center" width="11,1%"><xsl:value-of select="lbc"/></td>
<td align="center" width="11,1%"><xsl:value-of select="lcc"/></td>
<td align="center" width="11,1%"><xsl:value-of select="ddc"/></td>
<td align="center" width="11,1%"><xsl:value-of select="doi"/></td>
<td align="center" width="11,1%"><xsl:value-of select="ol"/></td>
<td align="center" width="11,1%"><xsl:value-of select="googlebookid"/></td>
<td align="center" width="11,1%"><xsl:value-of select="asin"/></td>
</tr></table></td></tr>


<tr valign="top"><td><font color="gray"><xsl:value-of select="bookattrlangselect"/>:</font></td>


<td colspan="3"><table border="0"  rules="cols" width="100%"><tr>
<td align="center" width="11,1%"><font color="gray">DPI: </font></td>
<td align="center" width="11,1%"><font color="gray">OCR:</font></td>
<td align="center" width="11,1%"><font color="gray">Bookmarked: </font></td>
<td align="center" width="11,1%"><font color="gray">Scanned: </font></td>
<td align="center" width="11,1%"><font color="gray">Orientation: </font></td>
<td align="center" width="11,1%"><font color="gray">Paginated: </font></td>
<td align="center" width="11,1%"><font color="gray">Color: </font></td>
<td align="center" width="11,1%"><font color="gray">Clean: </font></td>
<td align="center" width="11,1%"></td>
</tr>
<tr>
<td align="center" width="11,1%"><xsl:value-of select="dpi"/></td>
<td align="center" width="11,1%"><xsl:value-of select="searchable"/></td>
<td align="center" width="11,1%"><xsl:value-of select="bookmarked"/></td>
<td align="center" width="11,1%"><xsl:value-of select="scanned"/></td>
<td align="center" width="11,1%"><xsl:value-of select="orientation"/></td>
<td align="center" width="11,1%"><xsl:value-of select="paginated"/></td>
<td align="center" width="11,1%"><xsl:value-of select="color"/></td>
<td align="center" width="11,1%"><xsl:value-of select="cleaned"/></td>
<td align="center" width="11,1%"></td>
</tr></table></td></tr>


<tr valign="top"><td><font color="gray"><xsl:value-of select="mirrorslangselect"/>:</font></td>

<td colspan="3"><table border="0"  rules="cols"  width="100%"><tr>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="url1"/></font></td>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="url4-1"/></font></td>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="url2-1"/></font></td>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="url3-1"/></font></td>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="url6-1"/></font></td>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="url7-1"/></font></td>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="url8-1"/></font></td>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="url9-1"/></font></td>
<td align="center" width="11,1%"><font color="gray"><xsl:value-of select="torrent1"/></font></td>
</tr>
<tr>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="edonkey"/></xsl:attribute>[dl]</xsl:element></td>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="url4"/></xsl:attribute>[dl]</xsl:element></td>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="url2"/></xsl:attribute>[dl]</xsl:element></td>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="url3"/></xsl:attribute>[dl]</xsl:element></td>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="url6"/></xsl:attribute>[dl]</xsl:element></td>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="url7"/></xsl:attribute>[dl]</xsl:element></td>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="url8"/></xsl:attribute>[dl]</xsl:element></td>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="url9"/></xsl:attribute>[dl]</xsl:element></td>
<td align="center" width="11,1%"><xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="torrent"/></xsl:attribute>[dl]</xsl:element></td>


</tr></table></td></tr>

		















                   <tr valign="top">
 			<xsl:element name="td">
				<xsl:attribute name="colspan">4</xsl:attribute>
				<xsl:attribute name="style">padding: 25px</xsl:attribute>

				<xsl:copy-of select="descr"/>
			</xsl:element>





		</tr>
		<tr height="5" valign="top"><td bgcolor="brown" colspan="4"></td></tr>
	</xsl:for-each>
</table>

</body>
</html>
</xsl:template>

</xsl:stylesheet>
