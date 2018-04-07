
var url = location.protocol + '//'+location.hostname+'/mydontlist/';

$(document).ready(function(){

   $('#url').html(url);
   
   $('#go').click(function(){
      window.location = window.location.href  + $("#fisrtmylist").val();
      $("#fisrtmylist").val('');
      verificaUrl();
      
   });


    var verificaUrl = function(){

        if(url != window.location.href)
        {
           $('.home').hide();
           $('.mylist').show();
          
           buscarLista();

        }else{
           $('.home').show();
           $('.mylist').hide();

        }

    };


    var buscarLista = function(){
       
        var list = window.location.pathname;

        var request = $.ajax({
            url: url+"backend/mydontlist.php",
            method: "POST",
            data: {url:list},
            dataType: "json"
        });

        request.done(function( dados ) {

           $('#title').text(dados.data.lista.title);
           let i=0;
           let filhos = dados.data.filho;
           let lista ="<ul>";
          
           for(i;i<filhos.length;i++)
           {
              lista+="<li><a href='"+url+filhos[i].url+"'>"+filhos[i].url+"<a></li>";
           }

           lista+="</ul>";

           $("#filhos").html(lista);
           
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }




    verificaUrl();

});