﻿<html>

<?php include_once "_header.php"?>


<body>




<br/><br/>

<div class="link">
	<div align="left">


<a href="http://<?php echo $_SERVER['HTTP_HOST'];?>"><img src="remote_oracle_dba.jpeg" border="0" alt="Remote Oracle DataBase Administrator"></a><br/></div>




<br/>
<br/><br/>

<div align="center">
<h3>Сегменты > Экстенты > Блоки</h3><br/>
</div>
<br/><br/>

<div align="center">
<img src="http://img.rodin-andrey.com/images/segmentsex.gif" alt="Блоки Экстенты Сегменты" border="0" />
</div>


<br/><br/>

<h3>Блоки данных (Data Block)</h3>

<br/>

Блоки данных (Data Block) - мельчайший строительный блок базы данных Oracle, состоящий из определенного количества байт на диске.
Блок данных Oracle  -  логический компонент базы данных. Диски на которых располагаются блоки Oracle, сами делятся на блоки данных. Обычно блоки данных диска соответствуют блокам данных Oracle.
Размер блока базы данных Oracle устанавливается параметром DB_BLOCK_SIZE в файле init.ora. Размер блока следует воспринимать, как минимальную единицу обновления, выбора или вставки данных. 
Общепринятый размер блока - 8 KByte. Если выбрать размер блока 64 KByte, то даже при извлечении имени длиной в четыре символа, придется прочесть весь блок размером 64 
KByte, в котором содержатся интересующие четыре буквы.

Все блоки данных можно разделить на две основные части: часть строк данных и часть свободного пространства.

<br/><br/>

<h3>Экстенты (extent)</h3>

<br/>

Экстенты (extent) - это два или более последовательных блоков данных Oracle, представляющий собой единицу выделения места на диске.
Когда комбинируется несколько непрерывных блоков данных, они называются экстентом. Когда вы создаете объект базы данных вроде таблицы или индекса,
вы выделяете им некоторый начальный объем пространства, называемый начальным экстентом, и, кроме того, указываете размер следующего экстента. Однажды размещенные в таблице или индексе, экстенты остаются выделенными конкретному объекту, пока вы не удалите этот объект из базы данных - тогда пространство,
занимаемое им, вернется в пул свободного пространства базы данных.

<br/><br/>

<h3>Сегменты (segments)</h3>

<br/>
Сегменты (segments) - набор экстентов, которые вы выделяете логической структуре, такой как таблица или индекс (или некоторый другой объект).
Набор экстентов формирует следующую более крупную единицу хранения, именуемую сегментом. Oracle называет сегментом все пространство, выделенное любому конкретному объекту базы данных. 
Поэтому если у вас есть таблица по имени Customer, вы просто ссылаетесь на пространство, выделенное для нее, как на "сегмент Customer". Когда вы создаете индекс, он получает свой собственный сегмент, названные его именем.
Сегменты данных и индексов - наиболее распространенный тип сегментов Oracle. Есть также временные сегменты, которые база данных использует в транзакциях, включающих сортировку, а также сегменты отката, которые база использует для хранения информации отката.
Когда все экстенты сегмента заполнены, Oracle автоматически выделяет дополнительные экстенты при необходимости  и эти сегменты могут быть непрерывными.










<br/><br/>

<table class="RuleInformal" title="Viewing Information About Schema Object Space Use" summary="Column 1 contains the names of views, column 2 describes each view." dir="ltr" border="1" width="100%" frame="border" rules="all" cellpadding="3" cellspacing="0">
<col width="29%" />
<col width="*" />
<thead>
<tr align="left" valign="top">
<th align="left" valign="bottom" id="r1c1-t33">View</th>
<th align="left" valign="bottom" id="r1c2-t33">Description</th>
</tr>
</thead>
<tbody>
<tr align="left" valign="top">
<td align="left" id="r2c1-t33" headers="r1c1-t33"><code>DBA_SEGMENTS</code>
<p><code>USER_SEGMENTS</code></p>
</td>
<td align="left" headers="r2c1-t33 r1c2-t33"><span class="bold"><a id="sthref1724" name="sthref1724"></a></span>DBA view describes storage allocated for all database segments. User view describes storage allocated for segments for the current user.</td>
</tr>
<tr align="left" valign="top">
<td align="left" id="r3c1-t33" headers="r1c1-t33"><code>DBA_EXTENTS</code>
<p><code>USER_EXTENTS</code></p>
</td>
<td align="left" headers="r3c1-t33 r1c2-t33"><span class="bold"><a id="sthref1725" name="sthref1725"></a></span>DBA view describes extents comprising all segments in the database. User view describes extents comprising segments for the current user.</td>
</tr>
<tr align="left" valign="top">
<td align="left" id="r4c1-t33" headers="r1c1-t33"><code>DBA_FREE_SPACE</code>
<p><code>USER_FREE_SPACE</code></p>
</td>
<td align="left" headers="r4c1-t33 r1c2-t33">DBA view lists free extents in all tablespaces. User view shows free space information for tablespaces for which the user has quota.</td>
</tr>
</tbody>
</table>


<pre>

 
  SQL> desc DBA_SEGMENTS
 Name                                      Null?    Type
 ----------------------------------------- -------- ----------------------------
 OWNER                                              VARCHAR2(30)
 SEGMENT_NAME                                       VARCHAR2(81)
 PARTITION_NAME                                     VARCHAR2(30)
 SEGMENT_TYPE                                       VARCHAR2(18)
 SEGMENT_SUBTYPE                                    VARCHAR2(10)
 TABLESPACE_NAME                                    VARCHAR2(30)
 HEADER_FILE                                        NUMBER
 HEADER_BLOCK                                       NUMBER
 BYTES                                              NUMBER
 BLOCKS                                             NUMBER
 EXTENTS                                            NUMBER
 INITIAL_EXTENT                                     NUMBER
 NEXT_EXTENT                                        NUMBER
 MIN_EXTENTS                                        NUMBER
 MAX_EXTENTS                                        NUMBER
 MAX_SIZE                                           NUMBER
 RETENTION                                          VARCHAR2(7)
 MINRETENTION                                       NUMBER
 PCT_INCREASE                                       NUMBER
 FREELISTS                                          NUMBER
 FREELIST_GROUPS                                    NUMBER
 RELATIVE_FNO                                       NUMBER
 BUFFER_POOL                                        VARCHAR2(7)
 FLASH_CACHE                                        VARCHAR2(7)
 CELL_FLASH_CACHE                                   VARCHAR2(7)


SQL> desc DBA_EXTENTS
 Name                                      Null?    Type
 ----------------------------------------- -------- ----------------------------
 OWNER                                              VARCHAR2(30)
 SEGMENT_NAME                                       VARCHAR2(81)
 PARTITION_NAME                                     VARCHAR2(30)
 SEGMENT_TYPE                                       VARCHAR2(18)
 TABLESPACE_NAME                                    VARCHAR2(30)
 EXTENT_ID                                          NUMBER
 FILE_ID                                            NUMBER
 BLOCK_ID                                           NUMBER
 BYTES                                              NUMBER
 BLOCKS                                             NUMBER
 RELATIVE_FNO                                       NUMBER


 
 SQL> desc DBA_FREE_SPACE
 Name                                      Null?    Type
 ----------------------------------------- -------- ----------------------------
 TABLESPACE_NAME                                    VARCHAR2(30)
 FILE_ID                                            NUMBER
 BLOCK_ID                                           NUMBER
 BYTES                                              NUMBER
 BLOCKS                                             NUMBER
 RELATIVE_FNO                                       NUMBER
 


 


Displaying Segment Information

SELECT SEGMENT_NAME, TABLESPACE_NAME, BYTES, BLOCKS, EXTENTS
    FROM DBA_SEGMENTS
    WHERE SEGMENT_TYPE = 'INDEX'
    AND OWNER='HR'
    ORDER BY SEGMENT_NAME;
	
	
	
Displaying Extent Information

SELECT SEGMENT_NAME, SEGMENT_TYPE, TABLESPACE_NAME, EXTENT_ID, BYTES, BLOCKS
    FROM DBA_EXTENTS
    WHERE SEGMENT_TYPE = 'INDEX'
    AND OWNER='HR'
    ORDER BY SEGMENT_NAME;


Displaying the Free Space (Extents) in a Tablespace
	
SELECT TABLESPACE_NAME, FILE_ID, BYTES, BLOCKS
    FROM DBA_FREE_SPACE
    WHERE TABLESPACE_NAME='SMUNDO';

	
	

	
SELECT segment_name, file_id, block_id
FROM dba_extents
WHERE owner = 'SCOTT'
AND segment_name LIKE 'DEPT%';	
	
Alter system dump   datafile 4 block	 128;
	
	
	

 
	
</pre>
	
</div>		
		
	

<?php include_once "_footer.php"?>

</body>

</html>
