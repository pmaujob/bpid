function onLoadBody(){
    
    $(document).ready(function(){
        // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();
    });
    
    $(document).ready(function(){
        $('.collapsible').collapsible();
    });

    $('.REQOBS').trigger('autoresize');

}

function buscarViabilidades(){
    
    var datos;

    value = document.getElementById("input_buscar").value;
    
    jQuery.ajax({	
        type: 'POST',
        url:'../../vistas/formulariosDinamicos/frmRadicados.php',
        async: true,
        data:{value:value},
        success:function(respuesta){

            document.getElementById('resultado').innerHTML='<p>'+ respuesta + '</p>';

        },

        error: function () {
            alert("Error inesperado")
            window.top.location ="../index.html";	
        }
        
    });
    
}

function mas(cod){
    
    $('#modal1').modal('open');
    
    value = cod;
    
    jQuery.ajax({	
        type: 'POST',
        url:'../../vistas/formulariosDinamicos/frmListas.php',
        async: true,
        data:{value:value},
        success:function(respuesta){
            
            document.getElementById('collapsible').innerHTML='<p>'+ respuesta + '</p>';      

        },

        error: function () {
            alert("Error inesperado")
            window.top.location ="../index.html";	
        } 
    });
    
}