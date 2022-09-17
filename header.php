<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title><? echo $pagetitle; ?></title>
	<script src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        function returnDate(hour, mins, month, day, year)
        {
            opener.resform.elements["arrival_hour"].value = hour;
            opener.resform.elements["arrival_min"].value = mins;
            opener.resform.elements["requested_month"].value = month;
            opener.resform.elements["requested_day"].value = day;
            opener.resform.elements["res_year"].value = year;
            window.close()
        }
        function calpopup() 
        {
            var kid_count=document.forms["resform"]["num_children"].value;
            var month=document.forms["resform"]["requested_month"].value;
            var cyear=document.forms["resform"]["res_year"].value;
            var resdate = window.open("calendar.php?m="+month+"&y="+cyear+"&kid_count="+kid_count,
            "resdate", "status=1,height=800,width=800,resizable=0,scrollbars=1"); 
            return false;
        }
        function removeAllOptions(sel, removeGrp) 
        {
            var len, groups, par;
            if (removeGrp) 
            {
                groups = sel.getElementsByTagName('optgroup');
                len = groups.length;
                for (var i=len; i; i--) 
                {
                    sel.removeChild( groups[i-1] );
                }
            }
            len = sel.options.length;
            for (var i=len; i; i--) 
            {
                par = sel.options[i-1].parentNode;
                par.removeChild( sel.options[i-1] );
            }
        }
        function appendDataToSelect(sel, obj) 
        {
            var f = document.createDocumentFragment();
            var labels = [], group, opts;
            function addOptions(obj) 
            {
                var f = document.createDocumentFragment();
                var o;
                for (var i=0, len=obj.text.length; i<len; i++) 
                {
                    o = document.createElement('option');
                    o.appendChild( document.createTextNode( obj.text[i] ) );
                    if ( obj.value ) 
                    {
                        o.value = obj.value[i];
                    }
                    f.appendChild(o);
                }
                return f;
            }
            if ( obj.text ) 
            {
                opts = addOptions(obj);
                f.appendChild(opts);
            } 
            else 
            {
                for ( var prop in obj ) 
                {
                    if ( obj.hasOwnProperty(prop) ) 
                    {
                        labels.push(prop);
                    }
                }
                for (var i=0, len=labels.length; i<len; i++) 
                {
                    group = document.createElement('optgroup');
                    group.label = labels[i];
                    f.appendChild(group);
                    opts = addOptions(obj[ labels[i] ] );
                    group.appendChild(opts);
                }
            }
            sel.appendChild(f);
        }
    </script>
</head>
<body>