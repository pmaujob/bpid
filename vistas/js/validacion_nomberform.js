/*
FUNCION QUE SIRVE PARA CARGAR EL MODAL
 */
$(document).ready(function() {
   // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
   $('.modal').modal();
});
/*
FUNCION QUE DESPUES DE HACER CLICK EN EL BOTON ENVIAR SE ABRE EL DIALOG
 */
function validar() {
   $('#modal1').modal('open');
}