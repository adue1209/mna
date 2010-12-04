function number(e)
{
    var key = (e.charCode === undefined ? e.keyCode : e.charCode);
    if (e.ctrlKey || e.altKey || key < 32) {
        return true;
    }
    return (/[\d]/.test(String.fromCharCode(key)));
}


function check(f, n, c)
{
    for (var i = 0; i < f[n].length; i++) {
        f[n][i].checked = c;
    }
}


function checkForm(f, n)
{
    if (f[n] === undefined) {
        return false;
    } else if (f[n] instanceof HTMLInputElement) {
        if (!f[n].checked) {
            window.alert(document.getElementById("chF").innerHTML);
        }
        return f[n].checked;
    }

    for (var i = 0; i < f[n].length; i++)
    {
        if (f[n][i].checked) {
            return true;
        }
    }

    window.alert(document.getElementById("chF").innerHTML);
    return false;
}


function delNotify()
{
    return window.confirm(document.getElementById("delN").innerHTML);
}


function insAtCaret(o, s)
{
    var r = null;
    o.focus();

    if (document.selection !== undefined) {
        r = document.selection.createRange();
        if (r.parentElement() !== o) {
            return;
        }
        r.text = s;
        r.select();
    } else if (o.selectionStart !== undefined) {
        r = o.selectionStart;
        o.value = o.value.substr(0, r) + s + o.value.substr(o.selectionEnd, o.value.length);
        r += s.length;
        o.setSelectionRange(r, r);
    } else {
        o.value += s;
    }
    o.focus();
}


function paste(p)
{
    var o = document.forms.post.sql;
    if (p !== "" && o) {
        insAtCaret(o, decodeURIComponent(p));
    }
}


function files(t)
{
    var f = document.createElement("input");
    var fl = document.getElementById("fl");
    var fli = null;
    var flb = null;
    var el1 = null;
    var el2 = null;

    f.setAttribute("name", "f[]");
    f.setAttribute("type", "file");

    if (t === 1) {
        fl.insertBefore(f, null);
        fl.appendChild(document.createElement("br"));
    } else {
        fli = fl.getElementsByTagName("input");
        flb = fl.getElementsByTagName("br");
        if (fli.length > 0) {
            el1 = fli[fli.length - 1];
            el1.parentNode.removeChild(el1);
            el2 = flb[flb.length - 1];
            el2.parentNode.removeChild(el2);
        }
    }
}


function edit(t, n)
{
    var tr = n.parentNode;
    var tb = tr.parentNode;
    var f = null;

    if (this.id === undefined) {
        this.id = tb.lastChild.getAttribute("id").substring(1);
    }
    this.id++;

    if (t === 1) {
        f = tr.cloneNode(true);
        f.setAttribute("id", "i" + this.id);
        f.getElementsByTagName("input").item(0).setAttribute("value", "");
        f.getElementsByTagName("td").item(0).innerHTML = "+";
        tb.insertBefore(f, tr.nextSibling);
    } else {
        tb.removeChild(tr);
    }
}