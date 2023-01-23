var process = "controller/oil_transform_controller.php";
var str = "get_disabled_slots=" + 1;
var disabled_slots;
$.ajax({
    type: "POST",
    url: process,
    data: str,  
    success: function(data) {
        var returned = JSON.parse(data);
        if(returned.status == "success"){
            disabled_slots = returned.disabled_slots.getdisabledslots;
        }
    }
});

function sendDate(date){
    var process = "controller/oil_transform_controller.php";
    var str = "appointment_date="+date + "&olive_type=" + document.getElementsByName("olive_type")[0].value + "&olive_weight=" + document.getElementsByName("olive_weight")[0].value;
    $.ajax({
        type: "POST",
        url: process,
        data: str,  
        success: function(data) {
            var returned = JSON.parse(data);
            if(returned.status == "success"){
                swal('Randevu Alındı!', 'Randevularınıza Yönlendiriliyor...', 'success');
                setTimeout(function(){
                    window.location.href = "my_appointments?situation=success";
                }, 2000);
            }else if(returned.status == "error"){
                swal('Hata!', 'Randevunuz Alınamadı!', 'error');
            }else if(returned.status == "empty_weight"){
                swal('Uyarı!', 'Lütfen Ağırlık Girin!', 'warning');
            }
        }
    });
}

setTimeout(function(){
    console.log(disabled_slots);
    if(disabled_slots != undefined && disabled_slots != null){
        for(var i = 0; i < 5; i++){
            for(var j = 0; j < 9; j++){
                if(disabled_slots.includes(document.getElementById("slot_" + i + j).value)){
                    document.getElementById("btn_" + i + j).disabled = true;
                    document.getElementById("btn_" + i + j).style.cursor = "not-allowed";
                    document.getElementById("btn_" + i + j).className = "btn btn-danger";
                    document.getElementById("text_" + i + j).className = "text-white";
                    document.getElementById("text_" + i + j).innerHTML = "Dolu";

                }else{
                    document.getElementById("btn_" + i + j).disabled = false;
                    document.getElementById("btn_" + i + j).style.cursor = "pointer";
                }
            }
        }
    }else{
        for(var i = 0; i < 5; i++){
            for(var j = 0; j < 9; j++){
                document.getElementById("btn_" + i + j).disabled = false;
                document.getElementById("btn_" + i + j).style.cursor = "pointer";
            }
        }
    }
}, 1000);