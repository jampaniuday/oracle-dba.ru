﻿<html>

<?php include_once "_header.php"?>


<body>




<br/><br/>

<div class="link">
<?php include_once "_pagenav.php"?>



<br/><br/><br/>
<h2>Резервное копирование баз данных Oracle</h2><br/>


<br/><br/>
Резервное копирование баз данных Oracle подразумевает создание резервных копий файлов данных, управляющих файлов и файлов архивных журналов повторного выполнения.
Вдобавок в состав запасного набора могут включать файлы spfile, init.ora, listener.ora и tnsnames.ora
<br/><br/>

Резервное копирование выполняеся:
<br/><br/>
<ul>
<li>Средствами операционной системы. </li>
<li>Средствами RMAN (Recovery Manager). </li>
</ul>

<br/><br/>

<h3>Режимы ARCHIVELOG  и NOARCHIVELOG</h3>
<br/><br/>

Oracle записывает все именения, которые вносятся в находящиеся в памяти блоки данных, в оперативные журналы повторного выполенения (online redo logs), и делает это, как правило, перед их записью в файлы базы данных. Во время процесса восстановления Oracle использует зафиксированные в файлах этих журналов изменения для приведения базы данных в актуальное состояние. Oracle поддерживает два режима для управления такими файлами.
<br/><br/>

<ul>
<li>Режим архивирования журналов (ARCHIVELOG). В этом режиме Oracle сохраняет (архивирует) заполненные журналы повторного выполнения. Следовательно, на сколько давно бы не выполнялось резервное копирование, если используется режим ARCHIVELOG, базу данных всегда можно будет восстановить до любой точки во времени с помощью архивнных журналов. </li>

<li>
Режим без архивирования журналов (NOARCHIVELOG). В этом режиме заполненные журналы повторного выполенения перезаписываются, а не сохраняются. Это, следовательно, означает, что в случае использования режима NOARCHIVELOG выполнять восстановление можно будет только из резервной копии и что все остальные изменения, которые были внесены в базу данных после выполнения резервного копирования, будут утрачиваться. Этот режим обеспечивает возможность выполнения восстановления только после отказа экземляра базы данных.  В случае возникновения неполадок с носителем (например, потеря диска), функционирующую в режиме NOARCHIVELOG базу данных можно будет восстановить только из резервной копии и, естественно, с потерей всех изменений, которые были внесены в нее после создания этой резервной копии. </li>
</ul>
<br/><br/>


В режиме ARCHIVELOG функционируют почти все производственные базы данных. Режим NOARCHIVELOG используется только  тогда, когда есть возможность восстановить данные из других источников, или когда база данных пока находится только на стадии разработки или тестирования и потому не нуждается в возможности восстановления ее данных с точностью до минуты.
<br/><br/>

<h3>Резервное копирование всей или части базы данных</h3>
<br/><br/>

Подвергать резервному копированию можно как всю базу данных так и только ее часть, вроде входящего в ее состав табличного пространства или файла данных. Обратите внимание, что в случае, когда база данных функционирует в режиме NOARCHIVELOG, осуществлять резервное копирование лишь части базы данных, также называемое частичным резервнм копированием (partial database backup), нельзя, если только все те табличные пространства и файлы, которые подлежат  резервному копированию, не явлются доступными только для чтения.  Выполнять резервное копирование всей базы данных, также называемое полным резервным копированием (whole database backup), можно как в режиме ARCHIVELOG, так и в режиме NOARCHIVELOG.
<br/><br/>

Чаще всего выполняется полное резервное копирование. Оно предполагает копирование не только всех файлов данных, но и еще одного важного файла – управляющего.  Без управляющего файла Oracle не будет открывать базу данных, поэтому для восстановления помимо резервных копий всех файлов данных, необходимо также обязательно обладать и новейшей резервной копией управляющего файла.
<br/><br/>

<h3>Согласованное и несогласованное резервное копирование</h3>

<br/><br/>

Согласованное резервное копирование (consistent backup) приводит к созданию согласованных резервных копий и не требует проводить процесс восстановления.  При применении резервной копии для восстановления базы данных или ее части (например, табличного пространства или файла данных), сначала обычно требуется проветси восстновление данных из резервной копии (т.е. процедуру RESOTRE), а затем – восстанволвение работоспособоности базы данны (т.е. процедуру RECOVER). В случае согласованнго резервного копирования ни один из этих восстановительных шагов выполнять не требуется. В случае несогласованного рзеревного копирования (inconsistent backup) выполнение эти восстановительных шагов всегда является обязательным.
<br/><br/>

Oracle присавивает каждой транзакции уникальный системный номер измененеия (System Change Number - SCN). Каждая фикасания, к примеру, будуте проводить к увеличению этого номера. Всякий раз, когда Oracle устанавивает контроольную точку, все изменившиеся данные в оперативных файла данных записываются на диск.  И всякий раз, когда это проихсодит. Oracle выполняет обновление контрольной точки потока (thread checkpoint) в управляющем файле. Во время этого обновления Orale делает так, чтобы все доступные для чтения и записи файлы данных и управляющие файлы соглаовались с одним и тем же SCN-номером. База данных считается согласованной тогда, когда SCN-номера, хранмые  в заголовках всех файлов данных, являются идентичными и совпадают с информацией о заголовках файлов данных, которая содержится в управляющих файлах. Главное запомнить, что один и тот же SCN-номер дожен обязательно присутствовать во всех файлах данных и управляющем файле (или файлах). Пристуствие идентичного SCN- номера, означает, что в файлах данных содержатся данные за один и тот же промежуток времени. Если данные являются согласованными, никакие шаги по восстановлению после возврата (или копирования) набора фалов резервных копий на преждее место не понадоятся.
<br/><br/>

Для создания согласованной резервной копии базы данных необходимо либо закрывать (обычной командой SHUTDOWN или SHUTDOWN TRANSACTIONAL, но не командой SHUTDOWN ABORT), либо оснавливать  ( с помощью команды аккуратного завершения раборты) и запускать снова в режиме монтирования.

<br/><br/>

При выполнении несоглаксованного резервного копирования получается, что в файлах резерной копии содержатся данные за разные промежутки времени. Дело в том, что работу большинства производственных систем не допускается прерывать для провоедения согласлованного резервного коприования. Вместо этого необходимо, чтобы эти базы данных работали 24 часа в сутки 7 дней в неделю. Это, следоватлеьно, означает, что резервное коприонвание этих баз данных дожно выполняться в оператином режиме, т.е. пока они остаются открытыми для транзакций.  Изменение файлов данных пользователями во время проведения резервного копирования  как раз и приводит к полчению несогласованных резервнх копий. Выполнение несогласованного резервного копирования не означает получения каких-то непрвильных резрвных  копий.  Однако во время восстановления одного только возврата таких резервных копий на прежнее место недостаточно. Помимо возврата их на преждее место требуется также обязательно применить все архивные и оперативные журналы повторного выполенния, кторые были созданы в промежутке с момента выполнения резервного копирования и до момента, до которого необходимо восстановить базу данных. Oracle будет считывуать эти файлы и автоматически применять к файлам этих резервнх копий все необходимые изменения.
<br/><br/>


Поскольку при отрытой базе данных можно осуществлять только неосогласованное резервное коприование, для большинства производственных баз данных приеняются стратегии именно с процедурами несогласованного резервного коприоваиня в основе.
<br/><br/>

<h3>Резервное копирование открытой и закрытой базы данных</h3>
<br/><br/>

Резервное коприовние открытой базы даных (open backup), также называемое оперативным (online backup) или горячим резервым коприовние (hot/warm backup), подразумевает создание резерных копий при открытой и доступной для пользоватлеей базе данных. Выполнять оперитвное резервное копирование всей базы данных (равно как и только принадлежащего ей табличного пространства или файла данных) можно только в том случае, если база данных функционирует в режиме ARCHIVELOG. Проводить его, когда база данных функционирует в режиме NOARCHIVELOG, нельзя.
<br/><br/>

Резервное копирование закрытой базы данных (closed backup), также называетмое холодным резервнм копированием (cold backup), подразумевает создание резервных копий при закрытой (остановленной) базе данных. Такое резервное копирование всегда приводит к созданию согласованных резервных копий, если только база данных не была остановлена командой SHUTDOWN ABORT.
<br/><br/>

<h3>Физическое и логическое резервное копирование</h3>
<br/><br/>

С технической точки зрения процедуры резервного копирования Oracle можно поделить на логичекие и физические. Под логическим рзеревным копированием (logical backup) подразумевается создание резервных копий с помощью утилиты Data Pump Export, которые содержат логические объекты неподобие таблиц и процедур. Эти резервные копии сохранются в особом двоичном формате,  и данные из них могу извлекаться только посредством утилиты Data Pump Import.
<br/><br/>

Под физическим резервным коприование (physical backup) подразумевается создание резервных копий ключевых файлов базы данных Oracle, т.е. файлов данных, файлов архивных журналов повторного выполенения и управялющих файлов. Эти резервные копии могут сохраняться как на дисковых, так и на ленточных накопителях.
<br/><br/>

<h3>Уровни резервного копирования</h3>
<br/><br/>

Ниже перечислены уровни, на которых допускается выполнять резервное копирование баз данных Oracle:
<br/><br/>
<ul>
<li>Уровень всей базы данных. Этот уровень подразумевает выполнение резервного копирования всех файлов, в том числе и управляющего файла. Выполнять резервное копирование на уровне всей базы данных можно как в режиме ARCHIVELOG, так и в режиме NOARCHIVELOG. </li>
<li>Уровень табличного пространства. Этот уровень подразумевает выполнение резервного копирования всех фалов данных, принадлежащих конеретному табличному пространству. Выполнять резервное копирование на таком уровне допускается только в случае использования режима ARCHIVELOG. </li>
<li>Уровень файла данных. Этот уровень подразумевает выполненеие резервного копирования одного единственного файла данных. Выполнять резервное копирование на таком уровне допускается тоько в случае использования режима ARCHIVELOG. </li>
</ul>



</div>		
		
	

<?php include_once "_footer.php"?>

</body>

</html>