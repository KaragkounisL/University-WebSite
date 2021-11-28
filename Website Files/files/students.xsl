<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:decimal-format decimal-separator="," grouping-separator="."/>
<xsl:output method = "html"></xsl:output>
<xsl:template match="/students">

<!-- Μεταβλητή για εύρεση μεγαλύτερου μέσου όρου -->
<xsl:variable name="max1">
	<xsl:for-each select="student/average">
		<xsl:sort data-type="number" order="descending"/>
	<xsl:if test="position()=1"><xsl:value-of select="."/></xsl:if>
	</xsl:for-each>
</xsl:variable>
<!-- Μεταβλητή για εύρεση δεύτερου μεγαλύτερου μέσου όρου  -->
<xsl:variable name="max2">
	<xsl:for-each select="student/average">
		<xsl:sort data-type="number" order="descending"/>
	<xsl:if test="position()=2"><xsl:value-of select="."/></xsl:if>
	</xsl:for-each>
</xsl:variable>
			
<html>
<body>
	<br/><h3> ΔΕΔΟΜΕΝΑ XML ΑΡΧΕΙΟΥ </h3><br/>
	<div id = "report_tbl">
		<table cellspacing="30" style="background-color: #f1f1f1">
			<tr>
				<th style="text-align:center">Συνολικός Αριθμός Φοιτητών Εξαμήνου</th>	  
				<th style="text-align:center">Συνολικός Μέσος Όρος Φοιτητών Εξαμήνου</th>	
			</tr>
			<!-- Συναρτήσεις για υπολογισμό συνολικού αριθμού φοιτητών και συνολικού μέσου όρου φοιτητών εξαμήνου -->			
			<tr>
				<td style="text-align:center"><xsl:value-of select="count(//student)" /></td>		
				<td style="text-align:center"><xsl:value-of select="format-number(sum(//average) div count(//student), '#.##')"/></td>
			</tr>			
		</table>
	</div>

	<br/><h3> Μαθητές Επιλεγμένου Εξαμήνου </h3><br/>
	<div id = "report_tbl">
		<table cellspacing="30" style="background-color: #f1f1f1">
			<tr>
				<th style="text-align:center">Επώνυμο</th>	  
				<th style="text-align:center">Όνομα</th>	
				<th style="text-align:center">Εξάμηνο Φοίτησης</th>	
				<th style="text-align:center">Μαθήματα με προσβάσιμο βαθμό</th>				
				<th style="text-align:center">Μέσος όρος μαθημάτων με προσβάσιμο βαθμό</th>	
			</tr>
			<!-- 'Ελεγχος και διαμόρφωση για τους φοιτητές με τους 2 μεγαλύτερους μέσους όρους  -->
			<xsl:for-each select="student">
			<tbody>
				<xsl:if test="average=$max1">
					<xsl:attribute name="bgcolor">yellow</xsl:attribute>
				</xsl:if>
				<xsl:if test="average=$max2">
					<xsl:attribute name="bgcolor">orange</xsl:attribute>
				</xsl:if>
				<!-- Εμφάνιση στοιχείων φοιτητών -->	
				<tr>
					<td style="text-align:center"><xsl:value-of select="surname"/></td>		
					<td style="text-align:center"><xsl:value-of select="name"/></td>
					<td style="text-align:center"><xsl:value-of select="semester"/></td>
					<td style="text-align:center"><xsl:value-of select="passed_subjects"/></td>
					<td style="text-align:center"><xsl:value-of select="average"/></td>
				</tr>
			</tbody>				
			</xsl:for-each>			
		</table>
	</div>		
</body>
</html>
</xsl:template>
</xsl:stylesheet>