</body>
<script>
function dataAtualFormatada(dd){
    var data = new Date(dd);
    var dia = data.getDate();
    if (dia.toString().length == 1)
      dia = "0"+dia;
    var mes = data.getMonth()+1;
    if (mes.toString().length == 1)
      mes = "0"+mes;
    var ano = data.getFullYear();  
    return dia+"/"+mes+"/"+ano;
}

$('#dropDownFilter .dropdown-menu').on({
	"click":function(e){
      e.stopPropagation();
    }
});




</script>
</html>