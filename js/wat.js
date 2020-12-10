function _Get(param)
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = decodeURIComponent(hash[1]);
    }
    return vars[param];
}


IF(Q13="",
    "", 
    IF(E13="Complete", 
        DAYS(DATE(O13,N13,M13),DATE(L13,K13,J13))+1,
            IF(DAYS(Today(),DATE(L13,K13,J13))+1)<0,
            "h",
            DAYS(Today(),DATE(L13,K13,J13))+1)
            )