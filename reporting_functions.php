<?php

include_once("functions.php");
function getTotals()
{
    return "SELECT 'Total Files' as Type, COUNT(`CID`) as Value FROM `DOCUMENT_TABLE` WHERE `CREATEDATE` BETWEEN '2022-11-14 00:00:00' AND '2022-11-30 23:59:59'
UNION
SELECT 'Total File Size' as Type, SUM(OCTET_LENGTH(CONTENT))as Value  FROM `DOCUMENT_TABLE` WHERE `CREATEDATE` BETWEEN '2022-11-14 00:00:00' AND '2022-11-30 23:59:59'
UNION
SELECT 'Average File Size' as Type, AVG(OCTET_LENGTH(CONTENT)) as Value FROM `DOCUMENT_TABLE` WHERE `CREATEDATE` BETWEEN '2022-11-14 00:00:00' AND '2022-11-30 23:59:59';";
}

function getCompleteSQL()
{

    return "SELECT DISTINCT DOCUMENT_TABLE.CID,credit, closing, title, financial, personal, internal, legal, other
from DOCUMENT_TABLE

INNER JOIN
(select `CID`,docType as credit 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'credit') as a
on DOCUMENT_TABLE.CID=a.CID

INNER JOIN
(select `CID`,docType as closing 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'closing') as b
on DOCUMENT_TABLE.CID=b.CID

INNER JOIN
(select `CID`,docType as title 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'title') as c
on DOCUMENT_TABLE.CID=c.CID

INNER JOIN
(select `CID`,docType as financial 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'financial') as d
on DOCUMENT_TABLE.CID=d.CID

INNER JOIN
(select `CID`,docType as personal 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'personal') as e
on DOCUMENT_TABLE.CID=e.CID

INNER JOIN
(select `CID`,docType as internal 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'internal') as h
on DOCUMENT_TABLE.CID=h.CID

INNER JOIN
(select `CID`,docType as legal 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'legal') as f
on DOCUMENT_TABLE.CID=f.CID

INNER JOIN
(select `CID`,docType as other 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'other') as g
on DOCUMENT_TABLE.CID=g.CID

WHERE `CREATEDATE` 
BETWEEN '2022-11-14 00:00:00' AND '2022-11-30 23:59:59';";
}

function getPartialSQL()
{

    return "SELECT DISTINCT DOCUMENT_TABLE.CID,credit, closing, title, financial, personal, internal, legal, other
from DOCUMENT_TABLE

LEFT JOIN
(select `CID`,docType as credit 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'credit') as a
on DOCUMENT_TABLE.CID=a.CID

LEFT JOIN
(select `CID`,docType as closing 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'closing') as b
on DOCUMENT_TABLE.CID=b.CID

LEFT JOIN
(select `CID`,docType as title 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'title') as c
on DOCUMENT_TABLE.CID=c.CID

LEFT JOIN
(select `CID`,docType as financial 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'financial') as d
on DOCUMENT_TABLE.CID=d.CID

LEFT JOIN
(select `CID`,docType as personal 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'personal') as e
on DOCUMENT_TABLE.CID=e.CID

LEFT JOIN
(select `CID`,docType as internal 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'internal') as h
on DOCUMENT_TABLE.CID=h.CID

LEFT JOIN
(select `CID`,docType as legal 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'legal') as f
on DOCUMENT_TABLE.CID=f.CID

LEFT JOIN
(select `CID`,docType as other 
 FROM `DOCUMENT_TABLE` 
 WHERE docType LIKE 'other') as g
on DOCUMENT_TABLE.CID=g.CID

WHERE `CREATEDATE`
BETWEEN '2022-11-14 00:00:00' AND '2022-11-30 23:59:59'
and(credit is NUll OR closing is NUll OR title is NUll OR financial is NUll OR personal is NUll OR internal is NUll OR legal is NUll OR other is NUll);";
}

function getCountsSQL()
{

    return "SELECT CID, 
sum(docType like 'credit')as credit,
sum(docType like 'closing')as closing, 
sum(docType like 'title')as title,
sum(docType like 'financial')as financial,
sum(docType like 'personal')as personal,
sum(docType like 'internal')as internal,
sum(docType like 'legal')as legal,
sum(docType like 'other')as other
        
FROM `DOCUMENT_TABLE`
WHERE `CREATEDATE` 
BETWEEN '2022-11-14 00:00:00' AND '2022-11-30 23:59:59'
group by CID;";
}

function getAvg()
{
return "SELECT CID,count(docType)
from DOCUMENT_TABLE 
WHERE `CREATEDATE` BETWEEN '2022-11-14 00:00:00' AND '2022-11-30 23:59:59'
GROUP by CID";
}



?>