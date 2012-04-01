<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
<html>
<head>
<title>Library Genesis: Book Record</title>
</head>

<body>
<table border="0" width="100%">
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
				</xsl:element>
			</xsl:element></td><td><font color="gray">Title:</font></td><td colspan="3"><b>
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="url"/></xsl:attribute>
			<xsl:value-of select="title"/></xsl:element></b></td></tr>
		<tr valign="top"><td><font color="gray">Series:</font></td><td><xsl:value-of select="series"/></td><td><font color="gray">Periodical:</font></td><td><xsl:value-of select="periodical"/></td></tr>
		<tr valign="top"><td><font color="gray">Author(s):</font></td><td colspan="3"><b><xsl:value-of select="authors"/></b></td></tr>
		<tr valign="top"><td><font color="gray">Volume:</font></td><td><xsl:value-of select="volume"/></td><td><font color="gray">Edition:</font></td><td><xsl:value-of select="edition"/></td></tr>
		<tr valign="top"><td><font color="gray">Year:</font></td><td><xsl:value-of select="year"/></td><td><font color="gray">Pages:</font></td><td><xsl:value-of select="pages"/></td></tr>
		<tr valign="top"><td><font color="gray">Language:</font></td><td><xsl:value-of select="language"/></td><td><font color="gray">Publisher:</font></td><td><xsl:value-of select="publisher"/></td></tr>
		<tr valign="top"><td><font color="gray">ISBN:</font></td><td><xsl:value-of select="isbn"/></td><td><font color="gray">ASIN:</font></td><td><xsl:value-of select="asin"/></td></tr>
		<tr valign="top"><td><font color="gray">Topic:</font></td><td><xsl:value-of select="topic"/></td><td><font color="gray">ID:</font></td><td><xsl:value-of select="id"/></td></tr>
		<tr valign="top"><td><font color="gray">Time added:</font></td><td><xsl:value-of select="date"/></td><td><font color="gray">Time modified:</font></td><td><xsl:value-of select="date2"/></td></tr>
		<tr valign="top"><td><font color="gray">Library:</font></td><td><xsl:value-of select="library"/></td><td><font color="gray">Library issue:</font></td><td><xsl:value-of select="issue"/></td></tr>
		<tr valign="top"><td><font color="gray">Size:</font></td><td><xsl:value-of select="size"/></td><td><font color="gray">Extension:</font></td><td><xsl:value-of select="type"/></td></tr>
		<tr valign="top"><td><font color="gray">Commentary:</font></td><td colspan="3"><xsl:value-of select="commentary"/></td></tr>

		<tr valign="top"><td><font color="gray">Identifiers:</font></td>
<td colspan="3"><font color="gray">ISSN: </font><xsl:value-of select="issn"/>
<font color="gray">;UDC: </font><xsl:value-of select="udc"/>
<font color="gray">;LBC: </font><xsl:value-of select="lbc"/>
<font color="gray">;LCC: </font><xsl:value-of select="lcc"/>
<font color="gray">;DDC: </font><xsl:value-of select="ddc"/>
<font color="gray">;DOI: </font><xsl:value-of select="doi"/>
<font color="gray">;GoogleID: </font><xsl:value-of select="googlebookid"/></td></tr>


		<tr valign="top"><td><font color="gray">Book attributes:</font></td>
<td colspan="3"><font color="gray">DPI: </font><xsl:value-of select="dpi"/>
<font color="gray">;OCR: </font><xsl:value-of select="searchable"/>
<font color="gray">;Bookmarked: </font><xsl:value-of select="bookmarked"/>
<font color="gray">;Vector: </font><xsl:value-of select="vector"/>
<font color="gray">;Scanned: </font><xsl:value-of select="scanned"/>
<font color="gray">;Orientation: </font><xsl:value-of select="orientation"/>
<font color="gray">;Paginated: </font><xsl:value-of select="paginated"/>
<font color="gray">;Color: </font><xsl:value-of select="color"/>
<font color="gray">;Clean: </font><xsl:value-of select="cleaned"/></td></tr>

                <tr valign="top"><td><font color="gray">Mirrors:</font></td><td><b>
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="edonkey"/></xsl:attribute>
			<xsl:value-of select="url1"/></xsl:element>  
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="url4"/></xsl:attribute>\
			<xsl:value-of select="url4-1"/></xsl:element> 
                        <xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="url2"/></xsl:attribute>\
			<xsl:value-of select="url2-1"/></xsl:element>
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="url3"/></xsl:attribute>\
			<xsl:value-of select="url3-1"/></xsl:element>
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="torrent"/></xsl:attribute>\
			<xsl:value-of select="torrent1"/></xsl:element></b></td><td><font color="gray">Edit record:</font></td><td><b>
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="edit"/></xsl:attribute>
			<xsl:value-of select="edit1"/></xsl:element></b></td></tr>
		
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
