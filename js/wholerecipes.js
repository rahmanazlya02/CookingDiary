//ambil elemen2 yang dibutuhkan
var keywordd = document.getElementById('keyword');
var searchButton = document.getElementById('searching-button');
var container = document.getElementById('container-wholerecipes');

//tambahkan event ketika keyword ditulis
keyword.addEventListener('keyup', function() {
    
    //buat object ajax
    var ajax = new XMLHttpRequest();

    //cek kesiapan ajaxnya 
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            container.innerHTML = ajax.responseText;
        }
    }

    //eksekusi ajax
    ajax.open('GET', 'allrecipes.php?keyword=' + keyword.value, true);
    ajax.send();

});