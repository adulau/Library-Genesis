<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
<html>
<head>
<title>Library Genesis</title>
<link rel="stylesheet" href="paginator.css" type="text/css"/>
<script src="paginator.js" type="text/javascript"></script>
</head>

<body>
<h1><font color="brown"><a href="/">Library Genesis</a></font></h1>
<table border="0" width="100%">
	<tr><td colspan="3"><div class="paginator" id="paginator1"></div></td></tr>
	<xsl:for-each select="library/book">
		<tr valign="top"><td rowspan="19">
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="url"/></xsl:attribute>
				<xsl:element name="img">
				<xsl:attribute name="src"><xsl:value-of select="coverurl"/></xsl:attribute>
				<xsl:attribute name='border'>0</xsl:attribute>
				<xsl:attribute name='width'>180</xsl:attribute>
				<xsl:attribute name='style'>padding: 5px</xsl:attribute>
				</xsl:element>
			</xsl:element></td><td><font color="gray">Title:</font></td><td><b>
			<xsl:element name="a">
			<xsl:attribute name="href"><xsl:value-of select="url"/></xsl:attribute>
			<xsl:value-of select="title"/></xsl:element></b></td></tr>
		<tr valign="top"><td><font color="gray">Authors:</font></td><td><b><xsl:value-of select="authors"/></b></td></tr>
		<tr valign="top"><td><font color="gray">Volume:</font></td><td><xsl:value-of select="volume"/></td></tr>
		<tr valign="top"><td><font color="gray">Edition:</font></td><td><xsl:value-of select="edition"/></td></tr>
		<tr valign="top"><td><font color="gray">Year:</font></td><td><xsl:value-of select="year"/></td></tr>
		<tr valign="top"><td><font color="gray">Language:</font></td><td><xsl:value-of select="language"/></td></tr>
		<tr valign="top"><td><font color="gray">Pages:</font></td><td><xsl:value-of select="pages"/></td></tr>
		<tr valign="top"><td><font color="gray">Publisher:</font></td><td><xsl:value-of select="publisher"/></td></tr>
		<tr valign="top"><td><font color="gray">ISBN:</font></td><td><xsl:value-of select="isbn"/></td></tr>
		<tr valign="top"><td><font color="gray">ASIN:</font></td><td><xsl:value-of select="asin"/></td></tr>
		<tr valign="top"><td><font color="gray">Topic:</font></td><td><xsl:value-of select="topic"/></td></tr>
		<tr valign="top"><td><font color="gray">Periodical:</font></td><td><xsl:value-of select="periodical"/></td></tr>
		<tr valign="top"><td><font color="gray">Series:</font></td><td><xsl:value-of select="series"/></td></tr>
		<tr valign="top"><td><font color="gray">ID:</font></td><td><xsl:value-of select="id"/></td></tr>
		<tr valign="top"><td><font color="gray">Date:</font></td><td><xsl:value-of select="date"/></td></tr>
		<tr valign="top"><td><font color="gray">Library:</font></td><td><xsl:value-of select="library"/></td></tr>
		<tr valign="top"><td><font color="gray">Size:</font></td><td><xsl:value-of select="size"/></td></tr>
		<tr valign="top"><td><font color="gray">Type:</font></td><td><xsl:value-of select="type"/></td></tr>
		<tr valign="top"><td><font color="gray">Commentary:</font></td><td><xsl:value-of select="commentary"/></td></tr>
		<tr height="5" valign="top"><td bgcolor="brown" colspan="3"></td></tr>
	</xsl:for-each>
		<tr><td colspan="3"><div class="paginator" id="paginator2"></div></td></tr>
</table>

<xsl:for-each select="library/paginator">
	<script type="text/javascript">
	window.onload = function(){
		pag1 = new Paginator('paginator1',<xsl:value-of select="pagestotal"/>,<xsl:value-of select="pagesperpage"/>,<xsl:value-of select="pagenumber"/>,"index.php?page=");
		pag2 = new Paginator('paginator2',<xsl:value-of select="pagestotal"/>,<xsl:value-of select="pagesperpage"/>,<xsl:value-of select="pagenumber"/>,"index.php?page=");
	}
	</script>
</xsl:for-each>
<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18056347-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
</xsl:template>

</xsl:stylesheet>
