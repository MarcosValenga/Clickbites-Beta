document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var eventsData = JSON.parse(calendarEl.getAttribute('data-events'));

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        plugins: ['interaction', 'dayGrid'],
        editable: true,
        eventLimit: true,
        events: eventsData,
        extraParams: function () {
            return {
                cachebuster: new Date().valueOf()
            };
        },
        eventClick: function (info) {
            $("#apagar_evento").attr("href", "http://localhost/clickbitesofc/clickbites/delete-evento/index?id=" + info.event.id + "&idSala=" + info.event.extendedProps.fk_sala_id);

            info.jsEvent.preventDefault();
            $('#visualizar #id').text(info.event.id);
            $('#visualizar #id').val(info.event.id);
            $('#visualizar #title').text(info.event.title);
            $('#visualizar #title').val(info.event.title);
            $("#visualizar #descricao").text(info.event.extendedProps.descricao); // Aqui acessamos a propriedade 'descricao'
            $('#visualizar #start').text(info.event.start.toLocaleString());
            $('#visualizar #start').val(info.event.start.toLocaleString());
            $('#visualizar #end').text(info.event.end.toLocaleString());
            $('#visualizar #end').val(info.event.end.toLocaleString());
            $('#visualizar #color').val(info.event.backgroundColor);
            $('#visualizar').modal('show');
        },
        selectable: true,
        select: function (info) {
            //alert('Início do evento: ' + info.start.toLocaleString());
            $('#cadastrar #start').val(info.start.toLocaleString());
            $('#cadastrar #end').val(info.end.toLocaleString());
            $('#cadastrar').modal('show');
        }
        
    });

    calendar.render();
});

//Mascara para o campo data e hora
function DataHora(evento, objeto) {
    var keypress = (window.event) ? event.keyCode : evento.which;
    campo = eval(objeto);
    if (campo.value == '00/00/0000 00:00:00') {
        campo.value = "";
    }

    caracteres = '0123456789';
    separacao1 = '/';
    separacao2 = ' ';
    separacao3 = ':';
    conjunto1 = 2;
    conjunto2 = 5;
    conjunto3 = 10;
    conjunto4 = 13;
    conjunto5 = 16;
    if ((caracteres.search(String.fromCharCode(keypress)) != -1) && campo.value.length < (19)) {
        if (campo.value.length == conjunto1)
            campo.value = campo.value + separacao1;
        else if (campo.value.length == conjunto2)
            campo.value = campo.value + separacao1;
        else if (campo.value.length == conjunto3)
            campo.value = campo.value + separacao2;
        else if (campo.value.length == conjunto4)
            campo.value = campo.value + separacao3;
        else if (campo.value.length == conjunto5)
            campo.value = campo.value + separacao3;
    } else {
        event.returnValue = false;
    }
}


$(document).ready(function () {
    $("#addevent").on("submit", function (event) {
        event.preventDefault();
        var scriptElement = document.getElementById('recuperaridSala');
        // Obtém o valor do atributo de dados 'data-idsala'
        var idSala = scriptElement.getAttribute('data-idsala');
        var link = "http://localhost/clickbitesofc/clickbites/add-evento/index?idSala=" + idSala;


        // Obtenha os dados do formulário
        var formData = new FormData(this);


        $.ajax({
            method: "POST",
            url: link,
            data: formData,
            contentType: false,
            processData: false,
            success: location.reload()
            
        })
    });
    
    $('.btn-canc-vis').on("click", function(){
        $('.visevent').slideToggle();
        $('.formedit').slideToggle();
    });
    
    $('.btn-canc-edit').on("click", function(){
        $('.formedit').slideToggle();
        $('.visevent').slideToggle();
    });
    
    $("#editevent").on("submit", function (event) {
        event.preventDefault();

        var scriptElement = document.getElementById('recuperaridSala');
        // Obtém o valor do atributo de dados 'data-idsala'
        var idSala = scriptElement.getAttribute('data-idsala');
        var linkedit = "http://localhost/clickbitesofc/clickbites/edit-evento/index?idSala=" +idSala;
        console.log(linkedit);

        for (var pair of new FormData(this)) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
       $.ajax({
            method: "POST",
            url: linkedit,
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: location.reload()
        })
    });
});

