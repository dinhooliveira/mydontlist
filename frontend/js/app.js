
var url = location.protocol + '//'+location.hostname+'/mydontlist/';
var myitems = [];

$(document).ready(function(){

   $('#url').html(url);
   
   $('#go').click(function(){
      window.location = window.location.href  + $("#fisrtmylist").val();
      $("#fisrtmylist").val('');
      verificaUrl();
      
   });


   $("#adicionar").click(function(){

        let item = $("#valor_lista").val();
        let id_pai = $("#id_pai").val();

        if(item==false || item=='') return;

        var request = $.ajax({
            url: url+"backend/items.php",
            method: "POST",
            data: {item:item,id_lista:id_pai},
            dataType: "json"
        });

        request.done(function( dados ) {

            $("#valor_lista").val('');
            if(dados.success==false) return;

            myitems = (dados.data.data !==null) ? dados.data.data : [];
            listarItems();

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });



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
            url: url+"backend/busca.php",
            method: "POST",
            data: {url:list},
            dataType: "json"
        });

        request.done(function( dados ) {
            
          myitems = (dados.data.item!=null)  ?  dados.data.item.data : [];
           $('#title').text(dados.data.lista.title);
           let i=0;
           let filhos = dados.data.filho;
           let lista ="<ul>";
          
           for(i;i<filhos.length;i++)
           {
              lista+="<li><a href='"+url+filhos[i].url+"'>"+filhos[i].title+"<a></li>";
           }

           lista+="</ul>";

           $("#filhos").html(lista);

           $("#id_pai").val(dados.data.lista.id);
           
           listarItems();
           
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

    }

    var carregarLista = function(id=false)
    {
        var id = id ? id : $("#id_pai").val();
    
        var request = $.ajax({
            url: url+"backend/busca.php",
            method: "POST",
            data: {url:list},
            dataType: "json"
        });

        request.done(function( dados ) {

            $('#title').text(dados.data.lista.title);
            let i=0;
            let filhos = dados.data.filho;
            let lista;
            
            for(i;i<filhos.length;i++)
            {   
                if(i==0) lista="<ul>";
                lista+="<li><a href='"+url+filhos[i].url+"'>"+filhos[i].title+"<a></li>";
                if(i==filhos.length) lista="</ul>";
            }

            lista+="</ul>";

            $("#filhos").html(lista);
            
        });



    }

    var listarItems = function()
    {
        let i =0;
        let lista;

        for(i;i<myitems.length;i++)
        {
           if(i==0) lista="</ul>";
           lista+= "<li>" + myitems[i].item + "<button class='delete'>x</button></li>";
           if(i==myitems.length) lista+="</ul>";

        }

        $("#lista").html(lista);
    }




    verificaUrl();

});