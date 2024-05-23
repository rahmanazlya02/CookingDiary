//ambil elemen2 yang dibutuhkan
var keyword = document.getElementById('keyword');
//var searchButton = document.getElementById('mysearch-button');
var container = document.getElementById('container-myrecipe');

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
    ajax.open('GET', 'myrecipes.php?keyword=' + keyword.value, true);
    ajax.send();

});