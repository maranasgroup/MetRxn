-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` FUNCTION `synonymLink`(synVal varchar(2000),
href varchar(2000),
submit varchar(45),
RXN_MET varchar(45),
CURATION varchar(45),
abbr varchar(200),
src varchar(200)) RETURNS varchar(4000) CHARSET latin1
    READS SQL DATA
    DETERMINISTIC
BEGIN
declare val varchar(4000);
declare SynVal_disp varchar(4000);

    set href = '../searchResults/results.php?searchString=';

    set submit = 'Submit';
set SynVal_disp = synVal;
set synVal = replace(synVal,'\'','&#39;');
set synVal = replace(synVal,'<' ,'&#60;');
set synVal = replace(synVal,'>' ,'&#62;');
set synVal = replace(synVal,' ','&#32;');
set synVal = replace(synVal,'+','%2B');

set val = concat('<a href=',href,synVal);


set submit = concat('&submit=',submit);
set val = concat(val,submit);

set RXN_MET = concat('&RXN_MET=',RXN_MET);
set val = concat(val,RXN_MET);

set CURATION = concat('&CURATION=',CURATION);
set val = concat(val,coalesce(CURATION,''));

set abbr = concat('&abbr=',abbr);
set val = concat(val,coalesce(abbr,''));

set src =  concat('&src=',src);
set val = concat(val,coalesce(src,''));

set val = concat(val,'>',SynVal_disp,'</a>');

return val;
END
